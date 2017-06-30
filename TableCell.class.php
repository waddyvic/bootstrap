<?php
namespace ui;

class TableCell{
	const TH = 'th';
	const TD = 'td';
	const NORMAL = null;
	public $cellData = null;
	public $type = self::TD;
	public $id = null;
	protected $classes = array();
	public $rowSpan = null;
	public $colSpan = null;
	public $additionalAttr = null;
	
	public function __construct($cellData = '', $type = self::TD, $id = null, $class = null){
		$this->cellData = $cellData;
		$this->typeSet($type);
		$this->id = $id;
		$this->classAdd($class);
	}
	
	public function classAdd($class){
		// Do not add class if parameter is empty.
		if( !empty($class) ){
			$this->classes[] = $class;
		}
	}
	
	public function typeSet($type){
		if( $type != 'th' && $type != 'td' ){
			throw new \Exception("invalid type $type");
		}
		
		$this->type = $type;
	}
	
	public function view(){
		$str = '';
		
		$str .= "<" . $this->type;
		if( !empty($this->id) ){
			$str .= " id='" . $this->id . "'";
		}
		if( !empty($this->classes) ){
			$str .= " class='" . implode(' ', $this->classes) . "'";
		}
		if( !is_null($this->rowSpan) ){
			$str .= " rowspan='" . $this->rowSpan . "'";
		}
		if( !is_null($this->colSpan) ){
			$str .= " colspan='" . $this->colSpan . "'";
		}
		if( !is_null($this->additionalAttr) ){
			$str .= " $this->additionalAttr";
		}
		$str .= ">";
		
		$str .= $this->cellData;
		$str .= "</" . $this->type . ">" . PHP_EOL;
		
		return $str;
	}
}
