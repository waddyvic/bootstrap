<?php
namespace ui;
require_once(__DIR__ . "/Table.class.php");
require_once(__DIR__ . "/BootstrapTableRow.class.php");

class BootstrapTable extends Table{
	const BORDERED = 'table-bordered';
	const CONDENSED = 'table-condensed';
	const HOVER = 'table-hover';
	const STRIPED = 'table-striped';
	public $isResponsive = false;
	
	
	public function __construct($id = null, $class = null, $style = null){
		parent::__construct($id, $class, $style);
		$this->classAdd('table');
	}
	
	public function resetCurrRow(){
		$this->currRow = new BootstrapTableRow();
	}
	
	// overriden
	public function saveHeaderRow($context = BootstrapTableRow::NORMAL){
		$this->currRow->contextSet($context);
		parent::saveHeaderRow();
	}
	
	// overriden
	public function saveFooterRow($context = BootstrapTableRow::NORMAL){
		$this->currRow->contextSet($context);
		parent::saveFooterRow();
	}
	
	// overriden
	public function saveRow($context = BootstrapTableRow::NORMAL){
		$this->currRow->contextSet($context);
		parent::saveRow();
	}
	
	// overriden
	public function view(){
		$str = '';
		if( $this->isResponsive ){
			$str .= "<div class='table-responsive'>" . PHP_EOL;
		}
		
		$str .= parent::view();
		
		if( $this->isResponsive ){
			$str .= "</div>" . PHP_EOL;
		}
		
		return $str;
	}
}
