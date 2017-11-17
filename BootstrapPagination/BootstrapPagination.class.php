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

    // Pagination items, array of BootstrapPaginationItem objects
    protected $items = array();
    
    // Navigation items for going to previous/next page
    protected $navPrev = null;
    protected $navNext = null;
    
	public function __construct($type = self::TYPE_DEFAULT, $size = self::SIZE_DEFAULT, $id = null, $class = null){
        $this->typeSet($type);
        $this->sizeSet($size);
        $this->idSet($id);
		$this->classAdd($class);
	}
    
    public function ariaLabelGet(){
        return $this->ariaLabel;
    }

    public function ariaLabelSet($newAriaLabel){
        $this->ariaLabel = $newAriaLabel;
    }

    public function idGet(){
        return $this->id;
    }

    public function idSet($newId){
        $this->id = $newId;
    }

    public function itemActivateByLabel($label){
        foreach($this->items as $i){
            if( $i->isActive() && $i->labelGet() != $label ){
                $i->deactivate();
            }

            if( $i->labelGet() == $label ){
                $i->activate();
            }
        }
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
    }

    /*
    Create new item in pagination
    */
    public function itemAdd($label, $url, $isActive = false, $isDisabled = false){
        $itemObj = new BootstrapPaginationItem($label);
        $itemObj->urlSet($url);
        if( $isActive ){
            $itemObj->activate();
        }
        if( $isDisabled ){
            $itemObj->disable();
        }

        $this->items[] = $itemObj;
    }

    /*
    Add BootstrapPaginationItem object
    */
    public function itemObjAdd($itemObj){
        $validClass = 'ui\BootstrapPaginationItem';
        // Ensure object is an instance of the correct class
        if( is_a($itemObj, $validClass) && !is_subclass_of($itemObj, $validClass, false) ){
            $this->items[] = $itemObj;
        }
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

        $str .= "<nav aria-label='" . $this->ariaLabelGet() . "'>";
        $str .= "<ul class='" . $this->typeGet() . "'>";

        // View prev button if available
        if( !is_null($this->navPrev) ){
            if( $this->typeGet() == self::TYPE_DEFAULT ){
                $str .= $this->navPrev->view();
            }
            else{
                $str .= $this->navPrev->viewAsPager();
            }
        }

        // VIew other pagination items if present, and type is pagination, not pager.
        if( !empty($this->items) && $this->typeGet() == self::TYPE_DEFAULT ){
            foreach($this->items as $i){
                $str .= $i->view();
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
