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
	
	public function viewBasic(){
		$str = '';
		
		// If row contains only 1 item, print the item as is
		if( count($this->items) == 1){
			$str .= $this->items[0]->field->viewBasic();
		}
		else{
			$str .= "<div class='row'>";
			
			foreach($this->items as $i){
				$str .= "<div class='" . $i->gridConfig->toString() . "'>" . $i->field->viewBasic() . "</div>";
			}
			
			$str .= "</div>";
		}
		
		return $str;
	}
	
	public function viewHorizontal(){
		$str = '';
		
		foreach($this->items as $i){
			$str .= $i->field->viewHorizontal();
		}
		
		return $str;
	}
	
	public function viewInline(){
		$str = '';
		
		foreach($this->items as $i){
			$str .= $i->field->viewInline();
		}
		
		return $str;
	}
}
