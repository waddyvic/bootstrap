<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for text input.
*/

class BootstrapFormFieldText extends BootstrapFormField{
	public function __construct($id = null, $label = null, $value = null){
		$this->addClass('form-control');
		
		parent::__construct($id, $label, $value);
	}
	
	public function view(){
		$str = "<input type='text' ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->value) ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( strlen($this->helpText) > 0 ? "aria-describedby='" . $this->id . "HelpText' " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
}
