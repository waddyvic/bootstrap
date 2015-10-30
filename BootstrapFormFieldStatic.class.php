<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for static form field.
*/

class BootstrapFormFieldStatic extends BootstrapFormField{
	public function view(){
		$str = "<p class='form-control-static";
		$str .= ( !empty($this->class) ? " " . implode(' ', $this->class) : "") . "' ";
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->value . "</p>";
		
		return $str;
	}
}
