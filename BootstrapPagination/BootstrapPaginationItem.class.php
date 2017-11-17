<?php
/*
A PHP wrapper for items in Bootstrap 3 pagination component
https://getbootstrap.com/docs/3.3/components/#pagination
*/
namespace ui;

class BootstrapPaginationItem{
    // CSS class for object
    protected $classes = array();

    // Item label
    protected $label = null;

    // Is this item disabled?
    protected $isDisabled = false;

    // Is this item active?
    protected $isActive = false;

    // target URL for this item
    protected $url = '#';

	public function __construct($label, $class = null){
        $this->labelSet($label);
        $this->classAdd($class);
	}
    
    public function activate(){
        $this->isActive = true;
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

    public function deactivate(){
        $this->isActive = false;
    }

    public function disable(){
        $this->isDisabled = true;
    }

    public function enable(){
        $this->isDisabled = false;
    }

    public function isActive(){
        return $this->isActive;
    }

    public function isDisabled(){
        return $this->isDisabled;
    }

    public function labelGet(){
        return $this->label;
    }

    public function labelSet($newLabel){
        $this->label = $newLabel;
    }

    public function urlGet(){
        return $this->url;
    }

    public function urlSet($newUrl){
        $this->url = $newUrl;
    }

    public function view(){
        $str = '';

        // Opening <li> tag
        $str .= "<li";
        // Determine class for li element (active & disabled)
        $liClass = array();
        if( $this->isActive() ){
            $liClass[] = 'active';
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
        $str .= "<a href='" . $this->url . "'>" . $this->label;
        // Add screen reader only label for active item
        if( $this->isActive() ){
            $str .= " <span class='sr-only'>(current)</span>";
        }
        $str .= "</a>"; // Closing <a> tag.

        $str .= "</li>";    // Closing <li> tag.

        return $str;
    }
}
