<?php
namespace ui;

/*
This class acts as data store for form field option. Instance variables are:
- label: option label
- value: option value
- isSelected (boolean): whether the option is selected
- additionalAttr: any additional attributes to the option
*/

class FormFieldOption{
	public $label;
	public $value;
	public $isSelected;
	public $additionalAttr;
	
	public function __construct($newLabel, $newValue, $isSelected = false){
		$this->label = $newLabel;
		$this->value = $newValue;
		$this->isSelected = $isSelected;
	}
}