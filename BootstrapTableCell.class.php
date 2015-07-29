<?php
namespace ui;
require_once(__DIR__ . "/BootstrapTableRow.class.php");

class BootstrapTableCell extends TableCell{
	protected $context = null;
	
	public function __construct($cellData, $type = self::TD, $context = self::NORMAL, $id = null, $class = null){
		$this->context = $context;
		parent::__construct($cellData, $type, $id, $class);
	}
	
	public function contextSet($context){
		if( !in_array($context, BootstrapTableRow::$contextValue) ){
			throw new \Exception("context $context is not a valid Bootstrap context");
		}
		
		$this->context = $context;
	}
	
	public function view(){
		// Add contextual class to row
		if( $this->context != self::NORMAL ){
			$this->classAdd($this->context);
		}
		
		return parent::view();
	}
}