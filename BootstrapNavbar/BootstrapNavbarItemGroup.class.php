<?php
namespace ui;
/*
This is a PHP wrapper for bootstrap 3 navbar item:
https://getbootstrap.com/docs/3.3/components/#navbar
*/

require_once(__DIR__ . "/BootstrapNavbarItem.class.php");

class BootstrapNavbarItemGroup{
    const ALIGN_NONE = '';
    const ALIGN_LEFT = 'navbar-left';
    const ALIGN_RIGHT = 'navbar-right';
    const VALID_ALIGNS = array(
        self::ALIGN_NONE,
        self::ALIGN_LEFT,
        self::ALIGN_RIGHT,
    );

    const TYPE_DEFAULT = 'default';
    const TYPE_FORM = 'form';
    const VALID_TYPES = array(
        self::TYPE_DEFAULT,
        self::TYPE_FORM,
    );

    protected $id = null;
    protected $classes = array();
    protected $type = null;
    protected $items = array();

    /////////////////// functions /////////////////////////

    public function __construct($type = self::TYPE_DEFAULT, $align = self::ALIGN_NONE){
        $this->typeSet($type);
        $this->alignSet($align);
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
    
    public function alignGet(){
        return $this->align;
    }

    public function alignSet($align){
        if( self::isValidAlign($align) ){
            $this->align = $align;
        }
    }

    public function isEmpty(){
        return empty($this->items);
    }

    public function itemAdd($item){
        $this->items[] = $item;
    }

    public function typeGet(){
        return $this->type;
    }

    public function typeSet($type){
        if( self::isValidType($type) ){
            $this->type = $type;
        }
    }

    public function view(){
        $str = null;

        // Add alignment class
        if( $this->align != self::ALIGN_NONE ){
            $this->addClass($this->align);
        }

        // Return string based on item type
        switch($this->type){
            case self::TYPE_DEFAULT:
                $this->addClass('nav navbar-nav');
                $classStr = implode(' ', $this->classes);
                $isUlOpened = false;    // Indicate whether <ul> is opened
                foreach($this->items as $k => $i){
                    // If current item is not a button and no <ul> is opened, open one
                    if( !$i->isButton() && !$isUlOpened ){
                        $str .= "<ul class='$classStr'>";
                        $isUlOpened = true;
                    }

                    $str .= $i->view();
                    
                    // If no next item, or next item is button and <ul> is currently opened, close it
                    if( $isUlOpened && ( !isset( $this->items[$k+1] ) || $this->items[$k+1]->isButton() ) ){
                        $str .= "</ul>";
                        $isUlOpened = false;
                    }
                }
                break;
            case self::TYPE_FORM:
                $this->addClass('navbar-form');
                $classStr = implode(' ', $this->classes);
                $str .= "<form class='$coassStr'>";
                foreach($this->items as $i){
                    $str .= $i->view();
                }
                $str .= "</form>";
                break;
        }

        return $str;
    }

    ///////////////////// static functions ////////////////////////

    public static function isValidAlign($align){
        return in_array($align, self::VALID_ALIGNS);
    }

    public static function isValidType($type){
        return in_array($type, self::VALID_TYPES);
    }
}
