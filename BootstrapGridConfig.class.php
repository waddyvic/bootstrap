<?php
namespace ui;
require_once(__DIR__ . '/BootstrapGridConfigItem.class.php');

/*
This class stores multiple Bootstrap grid size config items and output appropriate HTML class string.
*/

class BootstrapGridConfig{
	private $items = array();
	
	public function __construct($screen, $col, $isOffset = false){
		$this->addItem($screen, $col, $isOffset);
	}

	public function __clone() {
		$object_vars = get_object_vars($this);
		foreach ($object_vars as $attr_name => $attr_value) {
			if (is_object($this->$attr_name)) {
				$this->$attr_name = clone $this->$attr_name;
			} else if (is_array($this->$attr_name)) {
				// Note: This copies only one dimension arrays
				foreach ($this->$attr_name as &$attr_array_value) {
					if (is_object($attr_array_value)) {
						$attr_array_value = clone $attr_array_value;
					}
					unset($attr_array_value);
				}
			}
		}
	}

	public function addItem($screen, $col, $isOffset = false){
		$this->items[] = new BootstrapGridConfigItem($screen, $col, $isOffset);
	}
	
	public function addItemObj($item){
		$this->items[] = $item;
	}
	
	public function deleteItem($screen, $col, $isOffset){
		foreach( $this->items as $index => $i ){
			if( $i->screen == $screen && $i->col == $col && $i->isOffset == $isOffset ){
				unset( $this->items[$index] );
			}
		}
	}
	
	public function deleteItemObj($item){
		$this->deleteItem($item->screen, $item->col, $item->isOffset);
	}
	
	public function getAllItemObjs(){
		return $this->items;
	}
	
	public function toString(){
		$strArray = array();
		
		foreach($this->items as $i){
			$strArray[] = $i->toString();
		}
		
		return implode(' ', $strArray);
	}
}