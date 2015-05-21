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