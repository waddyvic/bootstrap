<?php
namespace fwk\ui;

class BootstrapModal{
	const SIZE_SMALL = 'modal-sm';
	const SIZE_NORMAL = null;
	const SIZE_LARGE = 'modal-lg';
	
	protected static $validSize = array(self::SIZE_SMALL, self::SIZE_NORMAL, self::SIZE_LARGE);
	
	public $id;
	public $title;
	public $body;
	public $footerButtons = array();
	public $isAnimationOn = true;
	
	protected $size;
	
	
	public function __construct($newId = null, $newTitle = null, $newBody = null){
		$this->id = $newId;
		$this->title = $newTitle;
		$this->body = $newBody;
	}
	
	public function animationOff(){
		$this->isAnimationOn = false;
	}
	
	public function animationOn(){
		$this->isAnimationOn = true;
	}
	
	public function sizeGet(){
		return $this->size;
	}
	
	public function sizeReset(){
		$this->size = self::SIZE_NORMAL;
	}
	
	public function sizeSet($newSize = self::SIZE_NORMAL){
		if( !in_array($newSize, self::$validSize) ){
			$newSize = self::SIZE_NORMAL;
		}
		$this->size = $newSize;
	}
	
	public function view(){
		$str = "";
		$str .= "<div class='modal ";
		// Animation
		if( $this->isAnimationOn ){
			$str .= "fade";
		}
		$str .= "' ";
		// Modal ID
		if( !is_null($this->id) ){
			$str .= "id='" . $this->id . "' ";
		}
		$str .= "tabindex='-1' role='dialog' ";
		if( !is_null($this->id) ){
			$str .= "aria-labelledby='" . $this->id . "Label' ";
		}
		$str .= ">\n";
		
		$str .= "<div class='modal-dialog " . $this->size . "' role='document'>
			<div class='modal-content'>
				<div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;<span></button>";
					
		$str .= "<h4 class='modal-title' ";
		if( !is_null($this->id) ){
			$str .= "id='" . $this->id . "Label' ";
		}
		$str .= ">" . $this->title . "</h4>\n";
		
		$str .= "</div>
				<div class='modal-body'>
					" . $this->body . "
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				</div>
			</div>
		</div>";
		
		return $str;
	}
}
