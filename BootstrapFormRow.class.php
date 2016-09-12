<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormItem.class.php');

/*
This class stores a row of Bootstrap form item.
Instance variables:
- items: array of BootstrapFormItem objects
*/

class BootstrapFormRow{
	public $items = array();
	
	public function __construct(){
		
	}
	
	public function addItem($item){
		$this->items[] = $item;
	}
	
	public function viewBasic($isShowLabel = true){
		$str = '';
		
		// If row contains only 1 item, and the item does not have a grid config, print the item as is
		if( count($this->items) == 1 && is_null($this->items[0]->gridConfig) ){
			$str .= $this->items[0]->field->viewBasic($isShowLabel);
		}
		else{
			$str .= "<div class='row'>";
			
			foreach($this->items as $i){
				$str .= "<div class='" . $i->gridConfig->toString() . "'>" . $i->field->viewBasic($isShowLabel) . "</div>";
			}
			
			$str .= "</div>";
		}
		
		return $str;
	}
	
	public function viewHorizontal($isShowLabel = true, $labelColConfig = null, $fieldColConfig = null){
		$str = '';
		
		// Set default grid size if not provided
		if( is_null($labelColConfig) ){
			$labelColConfig = new \ui\BootstrapGridConfig('sm', 2);
		}
		if( is_null($fieldColConfig) ){
			$fieldColConfig = new \ui\BootstrapGridConfig('sm', 10);
		}
		
		foreach($this->items as $i){
			$str .= $i->field->viewHorizontal($isShowLabel, $labelColConfig, $fieldColConfig);
		}
		
		return $str;
	}
	
	public function viewInline($isShowLabel = false){
		$str = '';
		
		foreach($this->items as $i){
			$str .= $i->field->viewInline($isShowLabel) . "\n";
		}
		
		return $str;
	}
}
