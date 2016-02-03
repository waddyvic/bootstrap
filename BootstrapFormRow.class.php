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
		
		// If row contains only 1 item, print the item as is
		if( count($this->items) == 1){
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
	
	public function viewHorizontal($isShowLabel = true){
		$str = '';
		
		foreach($this->items as $i){
			$str .= $i->field->viewHorizontal($isShowLabel);
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
