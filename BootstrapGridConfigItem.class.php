<?php
namespace ui;

/*
This class stores inidividual Bootstrap grid size config item.
A grid size config item consists of the following:
- screen size: 1 of "xs", "xm", "md", "lg"
- column size: integer range from 1 to 12
- is offset: whether the size is for offset use
*/

class BootstrapGridConfigItem{
	public $screen;
	public $col;
	public $isOffset;
	
	public function __construct($screen, $col, $isOffset = false){
		$this->screen = $screen;
		$this->col = $col;
		$this->isOffset = $isOffset;
	}
	
	/*
	This function returns a BootstrapGridConfigItem object which offsets the current config item. If current config item is already an offset, return null.
	*/
	public function getOffsetObj(){
		$offsetObj = null;
		
		if( !$this->isOffset ){
			$offsetObj = new BootstrapGridConfigItem($this->screen, $this->col, true);
		}
		
		return $offsetObj;
	}
	
	public function toString(){
		$str = 'col-' . $this->screen . '-' . ( $this->isOffset ? 'offset-' : '' ) . $this->col;
		return $str;
	}
}