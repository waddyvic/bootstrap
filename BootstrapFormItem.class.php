<?php
namespace ui;

/*
This class stores an item of a bootstrap form row.
Instance variables:
- field: a bootstrap form field object.
- gridConfig: BootstrapGridConfig object that specifies the size of the field if there are multiple items in a single row.
*/

class BootstrapFormItem{
	public $field;
	public $gridConfig;
	
	public function __construct($field = null, $gridConfig = null){
		$this->field = $field;
		$this->gridConfig = $gridConfig;
	}
}
