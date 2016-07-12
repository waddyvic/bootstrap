<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for button input.
*/

class BootstrapFormFieldButton extends BootstrapFormField{
	public $type = 'button';
	protected $isShowLabel = false;		// Default to hide label
	protected $dataToggle = null;
	protected $ariaPressed = null;
	protected $autocomplete = null;
	protected $isActive = null;
	
	public function __construct($id = null, $label = null, $value = null){
		parent::__construct($id, $label, $value);
		$this->addClass('btn');
	}
	
	public function disableToggle(){
		$this->isActive = null;
		$this->dataToggle = null;
		$this->ariaPressed = null;
		$this->autocomplete = null;
		$this->removeClass('active');
	}
	
	public function enableToggle($isActive = false){
		$this->isActive = ($isActive ? true : false);
		$this->dataToggle = 'button';
		$this->ariaPressed = $this->isActive;
		$this->autocomplete = 'off';
		if( $isActive ){
			$this->addClass('active');
		}
	}
	
	public function view(){
		$str = "<button type='" . $this->type . "' ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->dataToggle) ? "data-toggle='" . $this->dataToggle . "' " : "");
		if( !is_null($this->ariaPressed) ) {
			$str .= "aria-pressed='" . ( $this->ariaPressed === true ? "true" : "false") . "' ";
		}
		$str .= ( !empty($this->autocomplete) ? "autocomplete='" . $this->autocomplete . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->label . "</button>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewBasic() function
	*/
	public function viewBasic($isShowLabel = false){
		return parent::viewBasic($isShowLabel);
	}
	
	/*
	Override BootstrapFormField::viewHorizontal() function
	*/
	public function viewHorizontal($isShowLabel = true, $labelColConfig = null, $fieldColConfig = null ){
		// Set default grid size if not provided
		if( is_null($labelColConfig) ){
			$labelColConfig = new BootstrapGridConfig('sm', 2);
		}
		if( is_null($fieldColConfig) ){
			$fieldColConfig = new BootstrapGridConfig('sm', 10);
		}
		
		// Use lalel column grid size config to determine field column config
		foreach($labelColConfig->getAllItemObjs() as $i){
			$i->isOffset = true;
			$fieldColConfig->addItemObj($i);
		}
		
		$str = "<div class='form-group'>
			<div class='" . $fieldColConfig->toString() . "'>" . $this->view() . "</div>
		</div>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view() . ' ';
	}
}
