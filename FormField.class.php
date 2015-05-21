<?php
namespace ui;
require_once(__DIR__ . '/FormFieldOption.class.php');
/*
This class acts as data store for form field. Instance variables are:
- id: the HTML id of the field
- label: the label of the field
- placeholder: HTML 5 placeholder
- type: the input type supported by HTML 5, and "button" for form buttons.
- value: the value of the field
- options: array of FormFieldOption objects for select, radio and checkbox.
- class: the class attribute of the field
- style: any custom style of the field
- additionalAttr: any additional attributes of the field (e.g. javascript events).
- isOptional (boolean): whether the field is optional
- isDisabled (boolean): whether the field is disabled
- helpText: help text for this field
- useSrcCode (boolean): whether to use the code in "srcCode" option to display the field. This will output the field using "srcCode" and ignore all options except label.
- srcCode: the customized HTML code to display the field.
- children: an array of FormField objects which group with the current field. Such as displaying an "Other" textbox for a dropdown box and group them together. Each element in this array will contain all previous options of a field (e.g. id, label, type, etc).
*/

class FormField{
	public $id;
	public $label;
	public $placeholder;
	public $value;
	public $options = array();
	public $class;
	public $style;
	public $additionalAttr;
	public $isOptional = false;
	public $isDisabled = false;
	public $helpText;
	public $useSrcCode = false;
	public $srcCode;
	protected $children = array();
	
	public function __construct($id = null, $label = null, $value = null){
		$this->id = $id;
		$this->label = $label;
		$this->placeholder = $label;
		$this->value = $value;
	}
	
	/*
	This function adds child field to current form field.
	*/
	public function addChild($formField){
		$this->children[] = $formField;
	}
	
	/*
	This function adds option to current form field.
	*/
	public function addOption($label, $value, $isSelected = false){
		$this->options[] = new FormFieldOption($label, $value, $isSelected);
	}
	
	/*
	Child class must implement this function to return HTML of field.
	*/
	public function view(){
		if( $this->useSrcCode ){
			return $this->srcCode;
		}
		else{
			return null;
		}
	}
}
