<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for button input.
*/

class BootstrapFormFieldButton extends BootstrapFormField{
	const BTN_STYLE_DANGER = 'btn-danger';
	const BTN_STYLE_DEFAULT = 'btn-default';
	const BTN_STYLE_INFO = 'btn-info';
	const BTN_STYLE_LINK = 'btn-link';
	const BTN_STYLE_PRIMARY = 'btn-primary';
	const BTN_STYLE_SUCCESS = 'btn-success';
	const VALID_BTN_STYLES = array(
		self::BTN_STYLE_DANGER,
		self::BTN_STYLE_DEFAULT,
		self::BTN_STYLE_INFO,
		self::BTN_STYLE_LINK,
		self::BTN_STYLE_PRIMARY,
		self::BTN_STYLE_SUCCESS,
	);

	public $type = 'button';
	protected $isShowLabel = false;		// Default to hide label
	protected $dataToggle = null;
	protected $ariaPressed = null;		// Aria label for toggle
	protected $autocomplete = null;
	protected $isActive = null;

	protected $dataTarget = null;		// Target for collapse functionality
	protected $ariaExpanded = null;		// Aria label for collapse
	
	public function __construct($id = null, $label = null, $value = null){
		parent::__construct($id, $label, $value);
		$this->addClass('btn');
		$this->btnStyleSet();
	}

	public function btnStyleSet($btnStyle = self::BTN_STYLE_DEFAULT){
		if( !self::isValidBtnStyle($btnStyle) ){
			return false;
		}
		
		$this->addClass($btnStyle);
		// Remove all other btn styles
		foreach( self::VALID_BTN_STYLES as $s ){
			if( $s != $btnStyle ){
				$this->removeClass($s);
			}
		}
	}
	
	public function disableCollapse(){
		$this->dataToggle = null;
		$this->dataTarget = null;
		$this->ariaExpanded = null;
	}
	
	public function disableToggle(){
		$this->isActive = null;
		$this->dataToggle = null;
		$this->ariaPressed = null;
		$this->autocomplete = null;
		$this->removeClass('active');
	}
	
	public function enableCollapse($target){
		$this->disableToggle();
		$this->dataToggle = 'collapse';
		$this->dataTarget = $target;
		$this->ariaExpanded = 'false';
	}

	public function enableToggle($isActive = false){
		$this->disableCollapse;

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
		$str .= ( !empty($this->dataTarget) ? "data-target='" . $this->dataTarget . "' " : "");
		if( !is_null($this->ariaExpanded) ){
			$str .= "aria-expanded='" . $this->ariaExpanded . "' ";
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
			$btnLabelColConfig = new BootstrapGridConfig('sm', 2);
		} else {
			$btnLabelColConfig = clone $labelColConfig;
		}
		if( is_null($fieldColConfig) ){
			$btnFieldColConfig = new BootstrapGridConfig('sm', 10);
		} else {
			$btnFieldColConfig = clone $fieldColConfig;
		}
		
		// Use label column grid size config to determine field column config
		foreach($btnLabelColConfig->getAllItemObjs() as $i){
			$i->isOffset = true;
			$btnFieldColConfig->addItemObj($i);
		}
		
		$str = "<div class='form-group'>
			<div data-item='test' class='" . $btnFieldColConfig->toString() . "'>" . $this->view() . "</div>
		</div>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view() . ' ';
	}

	///////////////////// static functions ///////////////////////

	public static function isValidBtnStyle($btnStyle){
		return in_array( $btnStyle, self::VALID_BTN_STYLES );
	}
}
