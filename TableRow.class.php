<?php
namespace ui;
require_once(__DIR__ . "/TableCell.class.php");

class TableRow{
	protected $cells = array();
	public $id;
	protected $classes = array();
	
	public function __construct($id = null, $class = null){
		$this->id = $id;
		$this->classAdd($class);
	}
	
	public function cellAdd($cell){
		$this->cells[] = $cell;
	}
	
	public function classAdd($class){
		// Do not add class if parameter is empty.
		if( !empty($class) ){
			$this->classes[] = $class;
		}
	}
	
	public function isEmpty(){
		return empty($this->cells);
	}
	
	public function view(){
		$str = '';
		
		$str .= "<tr";
		if( !empty($this->id) ){
			$str .= " id='" . $this->id . "'";
		}
		if( !empty($this->classes) ){
			$str .= " class='" . implode(' ', $this->classes) . "'";
		}
		$str .= ">" . PHP_EOL;
		
		foreach($this->cells as $c){
			$str .= $c->view();
		}
		$str .= "</tr>" . PHP_EOL;
		
		return $str;
	}
}