<?php
namespace ui;

use ui\BootstrapNavbarItemGroup;
use ui\BootstrapNavbarItem;

/*
This is a PHP wrapper for bootstrap 3 navbar:
https://getbootstrap.com/docs/3.3/components/#navbar
*/

require_once(__DIR__ . "/BootstrapNavbarItem.class.php");
require_once(__DIR__ . "/BootstrapNavbarItemGroup.class.php");
require_once(__DIR__ . "/../BootstrapFormFieldAnchor.class.php");
require_once(__DIR__ . "/../BootstrapFormFieldButton.class.php");
require_once(__DIR__ . "/../../gnu/http_build_url/1.0.1/src/http_build_url.php");

class BootstrapNavbar{
    // Constants for navbar style
    const STYLE_DEFAULT = 'navbar-default';
    const STYLE_INVERTED = 'navbar-inverse';
    const VALID_STYLES = array(
        self::STYLE_DEFAULT,
        self::STYLE_INVERTED,
    );

    // Constants for navbar positions
    const POSITION_DEFAULT = '';
    const POSITION_FIXED_BOTTOM = 'navbar-fixed-bottom';
    const POSITION_FIXED_TOP = 'navbar-fixed-top';
    const POSITION_STATIC_TOP = 'navbar-static-top';
    const VALID_POSITIONS = array(
        self::POSITION_DEFAULT,
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

    // Flag to control navbar to produce currMenu query string in url
    protected $isCurrMenuEnabled = false;

    /////////////////// functions /////////////////////////

    /*
    Set a default ID so collapse button knows which container to collapse
    */
    public function __construct($id = 'myNavbar', $style = self::STYLE_DEFAULT){
        $this->addClass('navbar');
        $this->idSet($id);
        $this->styleSet($style);
        $this->btnCollapseSet();
        $this->items = new BootstrapNavbarItemGroup();
        $this->itemsLeft = new BootstrapNavbarItemGroup(BootstrapNavbarItemGroup::TYPE_DEFAULT, BootstrapNavbarItemGroup::ALIGN_LEFT);
        $this->itemsRight = new BootstrapNavbarItemGroup(BootstrapNavbarItemGroup::TYPE_DEFAULT, BootstrapNavbarItemGroup::ALIGN_RIGHT);
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
            $this->brand->addClass('navbar-brand');
        }
        $this->brand->label = $str;

    }

    public function brandUrlSet($url){
        if( is_null($this->brand) ){
            $this->brand = new \ui\BootstrapFormFieldAnchor();
            $this->brand->addClass('navbar-brand');
        }
        $this->brand->hrefSet($url);
    }

    public function btnCollapseSet($btn = null){
        if( is_null($btn) ){
            $btn = self::btnCollapseGetDefault($this->id);
        }
        $this->btnCollapse = $btn;
    }

    public function currMenuDisable(){
        $this->isCurrMenuEnabled = false;
    }

    public function currMenuEnable(){
        $this->isCurrMenuEnabled = true;
    }

    public function idGet(){
        return $this->id;
    }

    public function idSet($id){
        $this->id = $id;
    }

    public function itemAdd($itemObj, $align = BootstrapNavbarItemGroup::ALIGN_NONE){
        $validClass = 'ui\BootstrapNavbarItem';
        // Ensure object is an instance of the correct class
        if( is_a($itemObj, $validClass) ){
            $varName = 'items';
            switch($align){
                case BootstrapNavbarItemGroup::ALIGN_LEFT:
                    $varName .= 'Left';
                    break;
                
                case BootstrapNavbarItemGroup::ALIGN_RIGHT:
                    $varName .= 'Right';
                    break;
            }
            $this->$varName->itemAdd($itemObj);
        }
    }

    public function itemAddButton($label, $align = BootstrapNavbarItemGroup::ALIGN_NONE, $id = null){
        $btn = new BootstrapFormFieldButton($id, $label);
        if( $align != BootstrapNavbarItemGroup::ALIGN_NONE ){
            $btn->addClass($align);
        }
        $itemObj = new BootstrapNavbarItem($btn, BootstrapNavbarItem::TYPE_BUTTON);
        $this->itemAdd($itemObj, $align);
    }

    public function itemAddLink($label, $href, $align = BootstrapNavbarItemGroup::ALIGN_NONE, $isActive = false, $id = null){
        $link = new BootstrapFormFieldAnchor($id, $label);
        $link->hrefSet($href);
        $itemObj = new BootstrapNavbarItem($link);
        $itemObj->activate();
        
        // Find current active item and deactivate it.
        foreach($this->items->itemsGet() as $i){
            if( $i->isActive() ){
                $i->deactivate();
            }
        }
        foreach($this->itemsLeft->itemsGet() as $i){
            if( $i->isActive() ){
                $i->deactivate();
            }
        }
        foreach($this->itemsRight->itemsGet() as $i){
            if( $i->isActive() ){
                $i->deactivate();
            }
        }

        $this->itemAdd($itemObj, $align);
    }

    public function itemAddLinkButton($label, $href, $align = BootstrapNavbarItemGroup::ALIGN_NONE, $isActive = false, $id = null){
        $link = new BootstrapFormFieldAnchor($id, $label);
        $link->hrefSet($href);
        if( $align != BootstrapNavbarItemGroup::ALIGN_NONE ){
            $link->addClass($align);
        }
        $link->addClass("btn btn-default");
        $itemObj = new BootstrapNavbarItem($link, BootstrapNavbarItem::TYPE_BUTTON);

        $this->itemAdd($itemObj, $align);
    }

    public function itemAddText($str, $align = BootstrapNavbarItemGroup::ALIGN_NONE){
        $itemObj = new BootstrapNavbarItem($str, BootstrapNavbarItem::TYPE_TEXT);
        $this->itemAdd($itemObj, $align);
    }

    public function itemAddFormField($formField, $align = BootstrapNavbarItemGroup::ALIGN_NONE){
        $varName = 'items';
        switch($align){
            case BootstrapNavbarItemGroup::ALIGN_LEFT:
                $varName .= 'Left';
                break;
            
            case BootstrapNavbarItemGroup::ALIGN_RIGHT:
            $varName .= 'Right';
                break;
        }

        // If the item group is empty, change its type to form
        if( $this->$varName->isEmpty() ){
            $this->$varName->typeSet(BootstrapNavbarItemGroup::TYPE_FORM);
        }

        // Check if the item group is a form
        if( $this->$varName->typeGet() != BootstrapNavbarItemGroup::TYPE_FORM ){
            throw new \Exception("item group is not of type 'form'");
        }

        $itemObj = new BootstrapNavbarItem($formField, BootstrapNavbarItem::TYPE_FORM_FIELD);
        $this->$varName->itemAdd($itemObj);
    }

    public function itemSetActiveByLabel($label){
        $newActiveItem = null;
        
        // Deactivate current active item, and activate item that matches url
        foreach($this->items->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }
            
            // If item is active and href doesn't match url
            if( $i->isActive() && $i->labelGet() != $label ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && $i->labelGet() == $label ){
                $i->activate();
                $newActiveItem = $i;
            }
        }

        foreach($this->itemsLeft->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }

            // If item is active and href doesn't match url
            if( $i->isActive() && $i->labelGet() != $label ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && $i->labelGet() == $label ){
                $i->activate();
                $newActiveItem = $i;
            }
        }

        foreach($this->itemsRight->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }

            // If item is active and href doesn't match url
            if( $i->isActive() && $i->labelGet() != $label ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && $i->labelGet() == $label ){
                $i->activate();
                $newActiveItem = $i;
            }
        }
    }

    /*
    Find and set active item by URL
    */
    public function itemSetActiveByUrl($url){
        $newActiveItem = null;

        // Deactivate current active item, and activate item that matches url
        foreach($this->items->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }
            
            // If item is active and href doesn't match url
            if( $i->isActive() && parse_url($i->urlGet(), PHP_URL_PATH) != $url ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && parse_url($i->urlGet(), PHP_URL_PATH) == $url ){
                $i->activate();
                $newActiveItem = $i;
            }
        }

        foreach($this->itemsLeft->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }

            // If item is active and href doesn't match url
            if( $i->isActive() && parse_url($i->urlGet(), PHP_URL_PATH) != $url ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && parse_url($i->urlGet(), PHP_URL_PATH) == $url ){
                $i->activate();
                $newActiveItem = $i;
            }
        }

        foreach($this->itemsRight->itemsGet() as $i){
            // Skip if item is not a link
            if( !$i->isLink() ){
                continue;
            }

            // If item is active and href doesn't match url
            if( $i->isActive() && parse_url($i->urlGet(), PHP_URL_PATH) != $url ){
                $i->deactivate();
            }
            // If item href matches given url, activate it, unless another item with same url is already activated
            else if( is_null($newActiveItem) && parse_url($i->urlGet(), PHP_URL_PATH) == $url ){
                $i->activate();
                $newActiveItem = $i;
            }
        }
    }

    public function positionGet(){
        return $this->position;
    }

    public function positionSet($position){
        if( self::isValidPosition($position) ){
            $this->position = $position;
            if( $position != self::POSITION_DEFAULT ){
                $this->addClass($position);
            }
            
            foreach(self::VALID_POSITIONS as $p){
                if( $p != $position ){
                    $this->removeClass($p);
                }
            }
        }
    }

    public function styleGet(){
        return $this->style;
    }

    public function styleSet($style){
        if( self::isValidStyle($style) ){
            $this->style = $style;
            $this->addClass($style);

            foreach(self::VALID_STYLES as $s){
                if( $s != $style ){
                    $this->removeClass($s);
                }
            }
        }
    }

    public function view(){
        $str = "";

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
