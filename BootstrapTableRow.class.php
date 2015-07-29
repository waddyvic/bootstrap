<?php
namespace ui;
require_once(__DIR__ . "/TableRow.class.php");
require_once(__DIR__ . "/BootstrapTableCell.class.php");

class BootstrapTableRow extends TableRow{
	const ACTIVE = 'active';
	const DANGER = 'danger';
	const INFO = 'info';
	const NORMAL = null;
	const SUCCESS = 'success';
	const WARNING = 'warning';
	protected $context = null;
	
	protected static $contextValue = array(self::ACTIVE, self::DANGER, self::INFO, self::NORMAL, self::SUCCESS, self::WARNING);
	
	public function __construct($context = self::NORMAL, $id = null, $class = null){
		$this->context = $context;
		parent::__construct($id, $class);
	}
	
	public function contextSet($context){
		if( !in_array($context, self::$contextValue) ){
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