<?php
namespace ui;
/*
This is a PHP wrapper for bootstrap 3 navbar item:
https://getbootstrap.com/docs/3.3/components/#navbar
*/

class BootstrapNavbarItem{
    const TYPE_BUTTON = 'button';
    const TYPE_LINK = 'link';
    const TYPE_TEXT = 'text';
    const VALID_TYPES = array(
        self::TYPE_BUTTON,
        self::TYPE_LINK,
        self::TYPE_TEXT,
    );

    protected $isActive = false;

    // Item value, can be different object based on item type
    protected $value = null;

    // Children items for dropdown functionality
    protected $children = array();

    /////////////////// functions /////////////////////////

    public function __construct($value, $type = self::TYPE_BUTTON){
        $this->value = $value;
        $this->typeSet($type);
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

        // Return string based on item type
        switch($this->type){
            case self::TYPE_LINK:
                if( empty($this->children) ){
                    $str .= "<li>" . $this->value->view() . "</li>";
                }
                else{
                    $str .= "<li class='dropdown'>";
                    $this->value->addClass('dropdown-toggle');
                    $this->value->additionalAttr = 'data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
                    $this->value->label = $this->value->label . " <span class='caret'></span>";
                    $str .= $this->value->view();
                    $str .= "</li>";
                }
                break;

            case self::TYPE_BUTTON:
                $str .= "<li>" . $this->value->view() . "</li>";
                break;
            
            case self::TYPE_TEXT:
                $str = $this->value;
                break;
        }

        return $str;
    }

    ///////////////////// static functions ////////////////////////

    public static function isValidType($type){
        return in_array($type, self::VALID_TYPES);
    }
}
