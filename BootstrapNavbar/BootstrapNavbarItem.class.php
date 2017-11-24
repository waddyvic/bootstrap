<?php
namespace ui;
/*
This is a PHP wrapper for bootstrap 3 navbar item:
https://getbootstrap.com/docs/3.3/components/#navbar
*/

class BootstrapNavbarItem{
    const TYPE_BUTTON = 'navbar-btn';
    const TYPE_LINK = 'navbar-link';
    const TYPE_TEXT = 'navbar-text';
    const TYPE_FORM_FIELD = 'form-field';
    const VALID_TYPES = array(
        self::TYPE_BUTTON,
        self::TYPE_LINK,
        self::TYPE_TEXT,
        self::TYPE_FORM_FIELD,
    );

    protected $isActive = false;

    // Item value, can be different object based on item type
    protected $value = null;

    // Children items for dropdown functionality
    protected $children = array();

    /////////////////// functions /////////////////////////

    public function __construct($value, $type = self::TYPE_LINK){
        $this->value = $value;
        $this->typeSet($type);
    }

    public function activate(){
        $this->isActive = true;
    }

    /*
    Set currMenu param for links. The param will be uncoded into url component so no need to encode it before passing in.
    */
    public function currMenuSet($currMenu = null){
        if( $this->isLink() ){
            if( is_null($currMenu) ){
                $currMenu = $this->value->label;
            }

            $currMenuStr = "currMenu=" . urlencode($currMenu);

            $urlParsed = parse_url($this->urlGet());
            $queryStr = '';
            if( isset($urlParsed['query']) ){
                $queryStr = $urlParsed['query'];
            }
            $query = explode('&', $queryStr);

            if( strpos($queryStr, 'currMenu') === false) {
                $query[] = $currMenuStr;
            }
            else{
                foreach($query as $k => $q){
                    if( strpos($q, 'currMenu') !== false ){
                        $query[$k] = $currMenuStr;
                    }
                    break;
                }
            }

            $urlParsed['query'] = implode('&', $query);
            $this->value->hrefSet( \http_build_url($urlParsed) );
        }
    }

    public function deactivate(){
        $this->isActive = false;
    }

    public function isActive(){
        return $this->isActive;
    }

    public function isButton(){
        return ($this->type == self::TYPE_BUTTON);
    }

    public function isFormField(){
        return ($this->type == self::TYPE_FORM_FIELD);
    }

    public function isLink(){
        return ($this->type == self::TYPE_LINK);
    }

    public function isText(){
        return ($this->type == self::TYPE_TEXT);
    }

    public function labelGet(){
        $label = null;
        switch($this->type){
            case self::TYPE_BUTTON:
            case self::TYPE_FORM_FIELD:
            case self::TYPE_LINK:
                $label = $this->value->label;
                break;
            
            case self::TYPE_TEXT:
                $label = $this->value;
                break;
        }

        return $label;
    }

    public function typeGet(){
        return $this->type;
    }

    public function typeSet($type){
        if( self::isValidType($type) ){
            $this->type = $type;
        }
    }

    public function urlGet(){
        $url = null;

        if( $this->isLink() ){
            $url = $this->value->hrefGet();
        }

        return $url;
    }

    public function view($isIncludeCurrMenu = true, $currMenu = null){
        $str = null;

        // Return string based on item type
        switch($this->type){
            case self::TYPE_LINK:
                if( $isIncludeCurrMenu ){
                    $this->currMenuSet($currMenu);
                }

                if( empty($this->children) ){
                    $activeClass = ( $this->isActive() ? "class='active'" : '');
                    $str .= "<li $activeClass>" . $this->value->view() . "</li>";
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
                $this->value->addClass($this->type);
                $str .= $this->value->view();
                break;
            
            case self::TYPE_TEXT:
                $str = "<p class='" . $this->type . "'>" . $this->value . "</p>";
                break;
            
            case self::TYPE_FORM_FIELD:
                $str = $this->value->viewInline(false);
                break;
        }

        return $str;
    }

    ///////////////////// static functions ////////////////////////

    public static function isValidType($type){
        return in_array($type, self::VALID_TYPES);
    }
}
