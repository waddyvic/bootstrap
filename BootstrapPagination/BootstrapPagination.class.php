<?php
/*
A PHP wrapper for Bootstrap 3 pagination component
https://getbootstrap.com/docs/3.3/components/#pagination
*/
namespace ui;

require_once(__DIR__ . "/BootstrapPaginationItem.class.php");
require_once(__DIR__ . "/BootstrapPaginationItemNav.class.php");

class BootstrapPagination{
    // Define class constants for pagination types.
    const TYPE_DEFAULT = 'pagination';
    const TYPE_PAGER = 'pager';
    const VALID_TYPES = array(
        self::TYPE_DEFAULT,
        self::TYPE_PAGER,
    );
    
    // Define class constants for pagination sizes
    const SIZE_DEFAULT = '';
    const SIZE_SM = 'pagination-sm';
    const SIZE_LG = 'pagination-lg';
    const VALID_SIZES = array(
        self::SIZE_DEFAULT,
        self::SIZE_SM,
        self::SIZE_LG,
    );

    // Element ID
    protected $id = null;

    // CSS class for object
    protected $classes = array();

    // Aria label for screen readers to identify current pagination usage
    protected $ariaLabel = '';

    // Pagination size
    protected $size = self::SIZE_DEFAULT;

    // Pagination type
    protected $type = self::TYPE_DEFAULT;

    // Pagination items, doubly linked list of BootstrapPaginationItem objects
    protected $items = null;

    // Index of active item
    protected $activeItemIndex = null;
    
    // Navigation items for going to previous/next page
    protected $navPrev = null;
    protected $navNext = null;

    // Number of visible items if too long. 0 or null means unlimited
    protected $numVisible = 0;
    

    ///////////////////// Functions //////////////////////////

	public function __construct($type = self::TYPE_DEFAULT, $size = self::SIZE_DEFAULT, $id = null, $class = null){
        $this->typeSet($type);
        $this->sizeSet($size);
        $this->idSet($id);
        $this->classAdd($class);
        
        // Initialize (doubly linked) list of items
        $this->items = new \SplDoublyLinkedList();
	}
    
    public function activeItemIndexGet(){
        return $this->activeItemIndex;
    }

    /*
    Deactivate current active item
    */
    public function activeItemDeactivate(){
        if( !is_null($this->activeItemIndex) && $this->items->offsetExists($this->activeItemIndex()) ){
            $this->items->offsetSet($this->activeItemIndex, $this->items->offsetGet( $this->activeItemIndex)->deactivate() );
            $this->activeItemIndex = null;
        }
    }

    public function ariaLabelGet(){
        return $this->ariaLabel;
    }

    public function ariaLabelSet($newAriaLabel){
        $this->ariaLabel = $newAriaLabel;
    }

    /*
    Function to add given css class in this object. Can use space separated value or an array to add multiple classes at once.
    */
    public function classAdd($newClass){
        $newClasses = array();
        if( !empty($newClass) ){
            // If parameter is an array, use it directly
            if( is_array($newClass) ){
                $newClasses = $newClass;
            }
            // Else, treat it as string and break them into array using space
            else{
                $newClasses = explode(' ', $newClass);
            }
        }

        foreach($newClasses as $n){
            if( !in_array($n, $this->classes) ){
                $this->classes[] = $n;
            }
        }
    }

    /*
    Function to add given css class in this object. Can use space separated value or an array to delete multiple classes at once.
    */
    public function classDelete($class){
        $classesDelete = array();
        if( !empty($class) ){
            // If parameter is an array, use it directly
            if( is_array($class) ){
                $classesDelete = $class;
            }
            // Else, treat it as string and break them into array using space
            else{
                $classesDelete = explode(' ', $classesDelete);
            }
        }

        foreach($classesDelete as $d){
            $index = array_search($d, $this->classes);
            if( $index !== false ){
                unset($this->classes[$index]);
            }
        }
    }

    public function classesGet(){
        return $this->classes;
    }

    public function createDefaultNav(){
        $this->navPrev = new BootstrapPaginationItemNav( BootstrapPaginationItemNav::LABEL_DEFAULT_PREV );
        $this->navNext = new BootstrapPaginationItemNav( BootstrapPaginationItemNav::LABEL_DEFAULT_NEXT );
        $this->navUpdate();
    }

    public function idGet(){
        return $this->id;
    }

    public function idSet($newId){
        $this->id = $newId;
    }

    public function itemActivateByLabel($label){
        // Rewind list iterator to beginning
        $this->items->rewind();

        // Iterate through the list, deativate any old active item, and activate the new item
        while( $this->items->valid() ){
            $currItem = $this->items->current();
            $currIndex = $this->items->key();
            if( $currItem->isActive() && $currItem->labelGet() != $label ){
                $currItem->deactivate();
                $this->items->offsetSet($currIndex, $currItem);
                $this->activeItemIndex = null;
            }
            else if( $currItem->labelGet() == $label ){
                $currItem->activate();
                $this->items->offsetSet($currIndex, $currItem);
                $this->activeItemIndex = $currIndex;
            }
            $this->items->next();
        }

        // Auto enable/disable prev/next button when active item is the 1st/last item
        $this->navUpdate();
    }

    /*
    Returns item after active item. Null if no next item, or no active item exist
    */
    public function itemGetNext(){
        $prevItem = null;

        if( !is_null($this->activeItemIndex) && $this->items->offsetExists($this->activeItemIndex + 1) ){
            $prevItem = $this->items->offsetGet($this->activeItemIndex + 1);
        }

        return $prevItem;
    }

    /*
    Returns item before active item. Null if no previous item, or no active item exist
    */
    public function itemGetPrev(){
        $prevItem = null;

        if( !is_null($this->activeItemIndex) && $this->items->offsetExists($this->activeItemIndex - 1) ){
            $prevItem = $this->items->offsetGet($this->activeItemIndex - 1);
        }

        return $prevItem;
    }

    /*
    Add BootstrapPaginationItem object
    */
    public function itemObjPush($itemObj){
        $validClass = 'ui\BootstrapPaginationItem';
        // Ensure object is an instance of the correct class
        if( is_a($itemObj, $validClass) && !is_subclass_of($itemObj, $validClass, false) ){
            // Update active item if needed
            if( $itemObj->isActive() ){
                $this->activeItemDeactivate();
            }
            $this->items->push($itemObj);
            $this->activeItemIndex = $this->items->count() - 1;
            $this->navUpdate();
        }
    }

    /*
    Create new item at the end
    */
    public function itemPush($label, $url, $isActive = false, $isDisabled = false){
        $itemObj = new BootstrapPaginationItem($label);
        $itemObj->urlSet($url);
        if( $isActive ){
            $itemObj->activate();
            // Deactivate old active item
            $this->activeItemDeactivate();
        }
        if( $isDisabled ){
            $itemObj->disable();
        }

        $this->items->push($itemObj);
        if( $isActive ){
            $this->activeItemIndex = $this->items->count() - 1;
        }

        $this->navUpdate();
    }

    public function itemObjGetActive(){
        $activeItem = null;
        if( !is_null($this->activeItemIndex) && $this->items->offsetExists($this->activeItemIndex) ){
            $activeItem = $this->items->offsetGet($this->activeItemIndex);
        }

        return $activeItem;
    }

    /*
    Return array of items visible in pagination
    */
    public function itemObjsGetVisible(){
        $visibleItems = new \SplDoublyLinkedList();

        // If pagination is set to show everything (i.e. $this->numVisible == 0 or null), or total num of items is less than visible number of items set, return everything
        if( is_null($this->numVisible) || $this->numVisible == 0 || $this->numVisible > count($this->items) ){
            return $this->items;
        }

        // Get active item index. If no item is active, treat 1st item as active (but don't activate it)
        $activeIndex = ( is_null($this->activeItemIndex) ? 0 : $this->activeItemIndex );

        // Calculate num of items to show before active item. We use intval() here to get whole integer if result is decimal.
        $numBefore = intval( ($this->numVisible - 1) / 2);
        // Calculate num of items to show after active item. Simple subtraction.
        $numAfter = $this->numVisible - 1 - $numBefore;

        // If there's not enough item to show before active item, shift them to after
        if( $activeIndex < $numBefore ){
            $numToShift = $numBefore - $activeIndex;
            $numBefore -= $numToShift;
            $numAfter += $numToShift;
        }
        // Else if there's not enough item to show after active item (i.e. active index + num after = index larger than last index), shift them to before
        else if( ($activeIndex + $numAfter) > ( count($this->items) - 1 ) ){
            // Actual number of items after active item
            $numAfterActive = count($this->items) - 1 - $activeIndex;
            $numToShift = $numAfter - $numAfterActive;
            $numAfter -= $numToShift;
            $numBefore += $numToShift;
        }

        // Construct the list
        // First insert active item
        $visibleItems->push( $this->items->offsetGet($activeIndex) );
        // Then prepend items before active item if any
        if( $numBefore > 0 ){
            // Move iterator to active item first
            $this->items->rewind();
            while( $this->items->key() != $activeIndex ){
                $this->items->next();
            }
            // Then iterate backward and prepend items to the visibleItems list
            for($i = $numBefore; $i > 0 ; $i--){
                $this->items->prev();
                $visibleItems->unshift( $this->items->current() );
            }
            // Additionally, show gap item (i.e. "...") and the 1st item if the 1st visible item is not the 1st item.
            if( $this->items->key() != 0 ){
                // Add gap item
                $visibleItems->unshift( \ui\BootstrapPaginationItem::objGetGap() );
                // Add first item
                $visibleItems->unshift( $this->items->bottom() );
            }
        }

        // Finally append items after active item if any
        if( $numAfter > 0 ){
            // Move iterator to active item first
            $this->items->rewind();
            while( $this->items->key() != $activeIndex ){
                $this->items->next();
            }
            // Then iterate backward and prepend items to the visibleItems list
            for($i = $numAfter; $i > 0 ; $i--){
                $this->items->next();
                $visibleItems->push( $this->items->current() );
            }
            // Additionally, show gap item (i.e. "...") and the last item if the last visible item is not the last item.
            if( $this->items->key() != $this->items->count() - 1 ){
                // Add gap item
                $visibleItems->push( \ui\BootstrapPaginationItem::objGetGap() );
                // Add first item
                $visibleItems->push( $this->items->top() );
            }
        }

        return $visibleItems;
    }

    /*
    Customize nav prev (label, url, alignment)
    */
    public function navNextSet($label, $url, $align = null){
        $this->navNext->labelSet($label);
        $this->navNext->urlSet($url);
        if( !is_null($align) ){
            $this->navNext->alignSet($align);
        }
    }

    public function navNextSetAlign($align){
        $this->navNext->alignSet($align);
    }

    public function navNextSetLabel($label){
        $this->navNext->labelSet($label);
    }

    public function navNextSetUrl($url){
        $this->navNext->urlSet($url);
    }

    /*
    Customize nav prev (label, url, alignment)
    */
    public function navPrevSet($label, $url, $align = null){
        $this->navPrev->labelSet($label);
        $this->navPrev->urlSet($url);
        if( !is_null($align) ){
            $this->navPrev->alignSet($align);
        }
    }

    public function navPrevSetAlign($align){
        $this->navPrev->alignSet($align);
    }

    public function navPrevSetLabel($label){
        $this->navPrev->labelSet($label);
    }

    public function navPrevSetUrl($url){
        $this->navPrev->urlSet($url);
    }

    /*
    Auto enable/disable prev/next buttons based on current active item:
    - If less than or equal to 1 item exist, both are disabled
    - If active item is at the beginning, disable "prev" and enable "next"
    - If active item is at the end, disable "next" and enable "prev"
    - If active item is neigher at the beginning nor at the end, enable both "next" and "prev"
    */
    public function navUpdate(){
        if( $this->items->count() <= 1 ){
            if( !is_null($this->navPrev) ){
                $this->navPrev->disable();
            }
            if( !is_null($this->navNext) ){
                $this->navNext->disable();
            }
        }
        else if( $this->activeItemIndex == 0 ){
            if( !is_null($this->navPrev) ){
                $this->navPrev->disable();
            }
            if( !is_null($this->navNext) ){
                $this->navNext->enable();
            }
        }
        else if( $this->activeItemIndex == $this->items->count() - 1 ){
            if( !is_null($this->navPrev) ){
                $this->navPrev->enable();
            }
            if( !is_null($this->navNext) ){
                $this->navNext->disable();
            }
        }
        else{
            if( !is_null($this->navPrev) ){
                $this->navPrev->enable();
            }
            if( !is_null($this->navNext) ){
                $this->navNext->enable();
            }
        }
    }

    public function numVisibleGet(){
        return $this->numVisible;
    }

    public function numVisibleSet($num){
        // If input is integer
        if( is_int($num) ){
            $this->numVisible = $num;
        }
        // If input is not integer but numeric, take integer value
        else if( is_numeric($num) ){
            $this->numVisible = intval($num);
        }

        // Finally, use absolute value
        $this->numVisible = abs($this->numVisible);
    }

    public function numVisibleUnset(){
        $this->numVisible = 0;
    }

    public function sizeGet(){
        return $this->size;
    }

    public function sizeSet($newSize){
        if( self::isValidSize($newSize) ){
            $this->size = $newSize;
        }
    }

    public function typeGet(){
        return $this->type;
    }

    public function typeSet($newType){
        if( self::isValidType($newType) ){
            $this->type = $newType;
        }
    }

    public function view(){
        $str = '';

        $navClassStr = null;
        if( !empty($this->classes) ){
            $navClassStr = "class='" . implode(' ', $this->classes) . "'";
        }
        $str .= "<nav aria-label='" . $this->ariaLabelGet() . "' $navClassStr>";

        $ulClasses = array();
        $ulClasses[] = $this->typeGet();
        if( $this->size != self::SIZE_DEFAULT ){
            $ulClasses[] = $this->size;
        }
        $ulClassStr = implode(' ', $ulClasses);
        $str .= "<ul class='$ulClassStr'>";

        // View prev button if available
        if( !is_null($this->navPrev) ){
            if( $this->typeGet() == self::TYPE_DEFAULT ){
                $str .= $this->navPrev->view();
            }
            else{
                $str .= $this->navPrev->viewAsPager();
            }
        }

        // View other pagination items if present, and type is pagination, not pager.
        if( !empty($this->items) && $this->typeGet() == self::TYPE_DEFAULT ){
            $visibleItems = $this->itemObjsGetVisible();    // Array of visible items
            
            $visibleItems->rewind();
            while( $visibleItems->valid() ){
                $str .= $visibleItems->current()->view();
                $visibleItems->next();
            }
        }

        // View next button if available
        if( !is_null($this->navNext) ){
            if( $this->typeGet() == self::TYPE_DEFAULT ){
                $str .= $this->navNext->view();
            }
            else{
                $str .= $this->navNext->viewAsPager();
            }
        }

        $str .= "</ul>";    // Closing <ul> tag
        $str .= "</nav>";   // Closing <nav> tag

        return $str;
    }

    /////////////// Static functions //////////////////
    
    public static function isValidSize($newSize){
        return in_array($newSize, self::VALID_SIZES);
    }

    public static function isValidType($newType){
        return in_array($newType, self::VALID_TYPES);
    }
}
