<?php
namespace ui;
require_once(__DIR__ . "/TableRow.class.php");

class Table{
	public $id = null;
	protected $classes = array();
	protected $styles = array();
	protected $border = false;
	public $caption = null;
	protected $currRow = null;		// Current table row; will be used for header, body, and footer
	protected $header = array();	// Array of table rows for header
	protected $body = array();
	protected $footer = array();
	
	public function __construct($id = null, $class = null, $style = null){
		$this->id = $id;
		$this->classAdd($class);
		$this->styleAdd($style);
		$this->resetCurrRow();
	}
	
	/*
	Allow deep clone
	*/
	public function __clone(){
		$newHeader = array();
		foreach($this->header as $h){
			$newHeader[] = clone $h;
		}
		$this->header = $newHeader;
		
		$newBody = array();
		foreach($this->body as $b){
			$newBody[] = clone $b;
		}
		$this->body = $newBody;
		
		$newFooter = array();
		foreach($this->footer as $f){
			$newFooter[] = clone $f;
		}
		$this->footer = $newFooter;
		
		$this->currRow = clone $this->currRow;
	}
	
	public function classAdd($class){
		// Do not add class if parameter is empty.
		if( !empty($class) ){
			$this->classes[] = $class;
		}
	}
	
	public function styleAdd($style){
		// Do not add class if parameter is empty.
		if( !empty($style) ){
			$this->styles[] = $style;
		}
	}
	
	public function borderSet($bool = false){
		$this->border = $bool;
	}
	
	public function newCell($cellData = '', $id = null, $class = null, $rowSpan = null, $colSpan = null){
		$cell = new TableCell($cellData, TableCell::TD, $id, $class);
		$cell->rowSpan = $rowSpan;
		$cell->colSpan = $colSpan;
		$this->currRow->cellAdd($cell);
	}
	
	public function newCellObj($cell){
		$this->currRow->cellAdd($cell);
	}
	
	public function newHeaderCell($cellData = '', $id = null, $class = null, $rowSpan = null, $colSpan = null){
		$cell = new TableCell($cellData, TableCell::TH, $id, $class);
		$cell->rowSpan = $rowSpan;
		$cell->colSpan = $colSpan;
		$this->currRow->cellAdd($cell);
	}
	
	public function newHeaderCellObj($cell){
		$this->currRow->cellAdd($cell);
	}
	
	public function resetCurrRow(){
		$this->currRow = new TableRow();
	}
	
	// Add class to current row
	public function rowClassAdd($class){
		$this->currRow->classAdd($class);
	}
	
	// Put current row into table header and start a new row
	public function saveHeaderRow(){
		if( !$this->currRow->isEmpty() ){
			$this->header[] = $this->currRow;
		}
		
		$this->resetCurrRow();
	}
	
	// Put current row into table footer and start a new row
	public function saveFooterRow(){
		if( !$this->currRow->isEmpty() ){
			$this->footer[] = $this->currRow;
		}
		
		$this->resetCurrRow();
	}
	
	// Put current row into table body and start a new row
	public function saveRow(){
		if( !$this->currRow->isEmpty() ){
			$this->body[] = $this->currRow;
		}
		
		$this->resetCurrRow();
	}
	
	public function view(){
		$str = '';
		
		$str .= "<table";
		if( !empty($this->id) ){
			$str .= " id='" . $this->id . "'";
		}
		if( !empty($this->classes) ){
			$str .= " class='" . implode(' ', $this->classes) . "'";
		}
		if( !empty($this->styles) ){
			$str .= " style='" . implode('; ', $this->styles) . "'";
		}
		if( $this->border ){
			$str .= " border=1";
		}
		$str .= ">" . PHP_EOL;
		
		// Print caption if available
		if( !empty($this->caption) ){
			$str .= "<caption>" . $this->caption . "</caption>" . PHP_EOL;
		}
		
		// Print table header if any
		if( !empty($this->header) ){
			$str .= "<thead>";
			foreach($this->header as $h){
				$str .= $h->view();
			}
			$str .= "</thead>";
		}
		
		// Print table body if any
		if( !empty($this->body) ){
			$str .= "<tbody>";
			foreach($this->body as $b){
				$str .= $b->view();
			}
			$str .= "</tbody>";
		}
		
		// Print table footer if any
		if( !empty($this->footer) ){
			$str .= "<tfoot>";
			foreach($this->footer as $f){
				$str .= $f->view();
			}
			$str .= "</tfoot>";
		}
		
		$str .= "</table>";
		
		return $str;
	}
}
