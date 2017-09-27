<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for dropdown inputs.
*/

class BootstrapFormFieldSelect extends BootstrapFormField{
    public function __construct($id = null, $label = null, $value = null){
		$this->addClass('form-control');
		
		parent::__construct($id, $label, $value);
    }
    
	public function view(){
        $str = '';

        $str = "<select ";
        $str .= ( !empty($this->id) ? "id='" . $this->id . "' ": "");
        $str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
        $str .= ( $this->isDisabled ? "disabled " : "" );
        $str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
        $str .= ( !empty($o->additionalAttr) ? $o->additionalAttr . " " : "");
        $str .= ">";
		
		foreach($this->options as $o){
			$str .= "<option value='" . $o->value . "'";
			$str .= ( $o->isSelected ? " selected" : "" );
			$str .= "> " . $o->label . "</option>";
		}
        
        $str .= "</select>";

		return $str;
	}
}
