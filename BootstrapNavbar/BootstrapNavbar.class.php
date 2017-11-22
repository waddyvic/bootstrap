<?php
namespace ui;
/*
This is a PHP wrapper for bootstrap 3 navbar:
https://getbootstrap.com/docs/3.3/components/#navbar
*/

require_once(__DIR__ . "BootstrapNavbarItem.class.php");
require_once(__DIR__ . "BootstrapNavbarItemGroup.class.php");
require_once(__DIR__ . "/../BootstrapFormFieldAnchor.class.php");
require_once(__DIR__ . "/../BootstrapFormFieldButton.class.php");

class BootstrapNavbar{
    // Constants for navbar style
    const STYLE_DEFAULT = 'navbar-default';
    const STYLE_INVERTED = 'navbar-inverted';
    const VALID_STYLES = array(
        self::STYLE_DEFAULT,
        self::STYLE_INVERTED,
    );

    // Constants for navbar positions
    const POSITION_FIXED_BOTTOM = 'navbar-fixed-bottom';
    const POSITION_FIXED_TOP = 'navbar-fixed-top';
    const POSITION_STATIC_TOP = 'navbar-static-top';
    const VALID_POSITIONS = array(
        self::POSITION_FIXED_BOTTOM,
        self::POSITION_FIXED_TOP,
        self::POSITION_STATIC_TOP,
    );

    // ID of the navbar element
    protected $id = null;

    // HTML classes
    protected $classes = array();

    // navbar style
    protected $style = null;

    // group of navbar items that doesn't have alignment specified.
    protected $items = null;

    // group of navbar items that are left aligned
    protected $itemsLeft = null;

    // group of navbar items that are right aligned
    protected $itemsRight = null;

    // Collapse button for responsive design
    protected $btnCollapse = null;

    // Navbar brand, a BootstrapFormFieldAnchor obj
    protected $brand = null;

    /////////////////// functions /////////////////////////

    /*
    Set a default ID so collapse button knows which container to collapse
    */
    public function __construct($id = 'myNavbar', $style = self::STYLE_DEFAULT){
        $this->idSet($id);
        $this->styleSet($style);
        $this->btnCollapseSet();
    }

    /*
	This function adds class to form field
	*/
	public function addClass($newClass){
		$classes = explode(' ', $newClass);
		
		foreach($classes as $c){
			if( !in_array($c, $this->classes) ){
				$this->classes[] = $c;
			}
		}		
	}
	
	/*
	This function removes class from form field
	*/
	public function removeClass($classStr){
		$classes = explode(' ', $classStr);
		
		$this->classes = array_diff($this->classes, $classes);
	}

    /*
    Set text for brand. Can contain image.
    */
    public function brandStrSet($str){
        if( is_null($this->brand) ){
            $this->brand = new \ui\BootstrapFormFieldAnchor();
        }
        $this->brand->label = $str;
    }

    public function brandUrlSet($url){
        if( is_null($this->brand) ){
            $this->brand = new \ui\BootstrapFormFieldAnchor();
        }
        $this->brand->hrefSet($url);
    }

    public function btnCollapseSet($btn = null){
        if( is_null($btn) ){
            $btn = self::btnCollapseGetDefault($this->id);
        }
        $this->btnCollapse = $btn;
    }

    public function idGet(){
        return $this->id;
    }

    public function idSet($id){
        $this->id = $id;
    }

    public function positionGet(){
        return $this->position;
    }

    public function positionSet($position){
        if( self::isValidPosition($position) ){
            $this->position = $position;
        }
    }

    public function styleGet(){
        return $this->style;
    }

    public function styleSet($style){
        if( self::isValidStyle($style) ){
            $this->style = $style;
        }
    }

    public function view(){
        $str = "";

        // Include navbar style in class string
        $this->addClass($this->style);
        $str .= "<nav class='" . implode(' ', $this->classes) . "' id='" . $this->id . "'>";
        $str .= "<div class='container-fluid'>";

        // Navbar header, includes collapse button and brand if specified
        $str .= "<div class='navbar-header'>";
        $str .= $this->btnCollapse->view();
        $str .= ( !is_null($this->brand) ? $this->brand->view() : '');
        $str .= "</div>";

        // Navbar body
        $str .= "<div class='collapse navbar-collapse' id='" . $this->id . "Collapse'>";
        // Include items that does not have alignment
        if( !$this->items->isEmpty() ){
            $str .= $this->items->view();
        }
        // Include items that are left aligned
        if( !$this->itemsLeft->isEmpty() ){
            $str .= $this->itemsLeft->view();
        }
        // Include items that are right aligned
        if( !$this->itemsRight->isEmpty() ){
            $str .= $this->itemsRight->view();
        }
        $str .= "</div>";   // Close navbar body

        $str .= "</div>";   // Close <div> container
        $str .= "</nav>";   // Close <nav>

        return $str;
    }

    /////////////////// static functions //////////////////

    public static function isValidPosition($position){
        return in_array($position, self::VALID_POSITIONS);
    }

    public static function isValidStyle($style){
        return in_array($style, self::VALID_STYLES);
    }

    public static function btnCollapseGetDefault($navId){
        $btn = new \ui\BootstrapFormFieldButton();
        $btn->removeClass('btn');
        $btn->addClass('navbar-toggle collapsed');
        $btn->enableCollapse('#' . $navId . 'Collapse');
        $btn->label = "<span class='sr-only'>Toggle navigation</span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>";

        return $btn;
    }
}