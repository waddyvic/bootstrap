<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for textarea input.
*/

class BootstrapFormFieldTextArea extends BootstrapFormField{
	public function __construct($id = null, $label = null, $value = null){
		$this->addClass('form-control');
		
		parent::__construct($id, $label, $value);
	}
	
	public function view(){
		$str = "<textarea ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">";
		$str .= $this->value;
		$str .= "</textarea>";
		
		return $str;
	}
}
