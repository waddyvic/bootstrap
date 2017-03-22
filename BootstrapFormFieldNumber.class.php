<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for text input.
*/

class BootstrapFormFieldNumber extends BootstrapFormField{
	public $min = null;
	public $max = null;
	public $step = null;
	
	public function __construct($id = null, $label = null, $value = null){
		$this->addClass('form-control');
		
		parent::__construct($id, $label, $value);
	}
	
	public function view(){
		$str = "<input type='number' ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( strlen($this->value) > 0 ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !is_null($this->min) ? "min='" . $this->min . "' " : "");
		$str .= ( !is_null($this->max) ? "max='" . $this->max . "' " : "");
		$str .= ( !is_null($this->step) ? "step='" . $this->step . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
}
