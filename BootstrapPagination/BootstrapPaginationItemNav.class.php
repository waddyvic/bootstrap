<?php
/*
A PHP wrapper for nav items in Bootstrap 3 pagination component
https://getbootstrap.com/docs/3.3/components/#pagination
*/
namespace ui;

require_once(__DIR__ . "/BootstrapPaginationItem.class.php");

class BootstrapPaginationItemNav extends \ui\BootstrapPaginationItem{
    // Constants for alignment when using as pager
    const PAGER_ALIGN_NONE = '';
    const PAGER_ALIGN_PREV = 'previous';
    const PAGER_ALIGN_NEXT = 'next';
    const VALID_PAGER_ALIGN = array(
        self::PAGER_ALIGN_NONE,
        self::PAGER_ALIGN_PREV,
        self::PAGER_ALIGN_NEXT,
    );

    // Constants for default label and aria label
    const LABEL_DEFAULT_PREV = '&laquo;';
    const LABEL_DEFAULT_NEXT = '&raquo;';
    const ARIA_LABEL_DEFAULT_PREV = 'Previous';
    const ARIA_LABEL_DEFAULT_NEXT = 'Next';

    // Alignment when using as pager
    protected $align = null;

    // Aria label
    protected $ariaLabel = '';

	public function __construct($label, $class = null, $align = self::PAGER_ALIGN_NONE){
        parent::__construct($label, $class);
        $this->alignSet($align);
	}
    
    public function alignGet(){
        return $this->align;
    }

    public function alignSet($newAlign = self::PAGER_ALIGN_NONE){
        if( self::isValidAlign($newAlign) ){
            $this->align = $newAlign;
        }
    }

    public function ariaLabelGet(){
        return $this->ariaLabel;
    }

    public function ariaLabelSet($newAriaLabel){
        $this->ariaLabel = $newAriaLabel;
    }

    // Overriden to auto set aria label if not set, and new label is one of the default
    public function labelSet($newLabel){
        parent::labelSet($newLabel);

        if( strlen($this->ariaLabel) == 0){
            switch($newLabel){
                case self::LABEL_DEFAULT_PREV:
                    $this->ariaLabelSet(self::ARIA_LABEL_DEFAULT_PREV);
                    break;
                
                case self::LABEL_DEFAULT_NEXT:
                    $this->ariaLabelSet(self::ARIA_LABEL_DEFAULT_NEXT);
                    break;
            }
        }
    }

    // overriden
    public function view(){
        $str = '';
        
        // Opening <li> tag
        $str .= "<li";
        // Add class for <li> if disabled
        // Note: we don't check isActive b/c navigation items technically will never be active
        if( $this->isDisabled() ){
            $str .= " class='disabled'";
        }
        $str .= ">";    // End of opening <li> tag.

        // If not disabled, wrap label with <a> tag; otherwise wrap with <span> tag as recommended by documentation
        if( !$this->isDisabled() ){
            $str .= "<a href='" . $this->url . "'>";
        }
        else{
            $str .= "<span>";
        }
        $str .= $this->label;
        
        if( !$this->isDisabled() ){
            $str .= "</a>"; // Closing <a> tag.
        }
        else{
            $str .= "</span>";
        }

        $str .= "</li>";    // Closing <li> tag.

        return $str;
    }

    /*
    Function to view as pager
    */
    public function viewAsPager(){
        $str = '';
        
        // Opening <li> tag
        $str .= "<li";
        // Determine class for li element (align & disabled)
        $liClass = array();
        if( $this->align != self::PAGER_ALIGN_NONE ){
            $liClass[] = $this->align;
        }
        if( $this->isDisabled() ){
            $liClass[] = 'disabled';
        }

        // If there are li class(es), add in output
        if( !empty($liClass) ){
            $str .= " class='" . implode(' ', $liClass) . "'";
        }
        $str .= ">";    // End of opening <li> tag.

        // <a> tag
        $str .= "<a href='" . $this->url . "'>" . $this->label . "</a>";

        $str .= "</li>";    // Closing <li> tag.

        return $str;
    }

    /////////////// static functions /////////////////////

    public static function isValidAlign($newAlign){
        return in_array($newAlign, self::VALID_PAGER_ALIGN);
    }
}
