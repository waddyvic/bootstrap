<?php
namespace ui;
require_once('BootstrapGridConfig.class.php');
require_once('BootstrapFormFieldButton.class.php');
require_once('BootstrapFormFieldCheckbox.class.php');
require_once('BootstrapFormFieldHidden.class.php');
require_once('BootstrapFormFieldNumber.class.php');
require_once('BootstrapFormFieldPassword.class.php');
require_once('BootstrapFormFieldRadio.class.php');
require_once('BootstrapFormFieldStatic.class.php');
require_once('BootstrapFormFieldText.class.php');
require_once('BootstrapFormFieldTextArea.class.php');
require_once('BootstrapFormRow.class.php');
/*
This class creates an array of form fields and generate HTML form using Bootstrap 3.

Instance variables:
- type: type of Bootstrap 3 forms, can be
	-> basic: normal form
	-> inline: inline form
	-> horizontal: horizontal form
- formTypes: array of possible form types
- rows: array of form rows, each row contains 1 or more form fields
- buttons: array of BootstrapFormFieldButton objects, typically the "Submit" and "Cancel" buttons.
- isNewRow: flag to control whether new form field is added to a new row.
- isShowLabel: whether to show or hide form field labels; can be overriden by individual form field
- method: either POST or GET
- action: form action, usually a URL
- labelColConfig: BootstrapGridConfig object for horizontal form label column
- fieldColConfig: BootstrapGridConfig object for horizontal form field column
*/

class BootstrapForm
{
	const POST = 'POST';
	const GET = 'GET';
	const FORM_TYPE_BASIC = 'basic';
	const FORM_TYPE_INLINE = 'inline';
	const FORM_TYPE_HORIZONTAL = 'horizontal';
	protected static $allowedMethods = array(self::POST, self::GET);
	
	protected $id;
	protected $type;
	protected $formTypes = array('basic', 'inline', 'horizontal');
	protected $rows = array();
	protected $buttons = array();
	protected $isNewRow = true;
	protected $isShowLabel = true;
	protected $method = self::POST;
	protected $action = null;
	public $additionalAttr = '';
	public $labelColConfig = null;
	public $fieldColConfig = null;
	
	public function __construct($newType = self::FORM_TYPE_BASIC, $newId = null){
		$this->typeSet($newType);
		$this->idSet($newId);
	}
	
	public function actionSet($action){
		$this->action = $action;
	}
	
	public function actionGet(){
		return $this->action;
	}
	
	public function addButton($button){
		$this->buttons[] = $button;
	}
	
	public function addField($formField, $gridConfig = null){
		$newItem = new BootstrapFormItem($formField, $gridConfig);
		
		// Start a new row if isNewRow flag is set to true, or there is no existing row in this object
		if( $this->isNewRow || count($this->rows) == 0 ){
			$newRow = new BootstrapFormRow();
			$newRow->addItem( $newItem );
			$this->rows[] = $newRow;
		}
		else{
			$lastRowIndex = count($this->rows) - 1;
			$this->rows[$lastRowIndex]->addItem($newItem);
		}
	}
	
	public function idSet($newId){
		$this->id = $newId;
	}
	
	public function idGet(){
		return $this->id;
	}
	
	public function labelShow(){
		$this->isShowLabel = true;
	}
	
	public function labelHide(){
		$this->isShowLabel = false;
	}
	
	public function methodGet(){
		return $this->method;
	}
	
	public function methodSet($method){
		$method = strtoupper($method);
		if( !in_array($method, self::$allowedMethods) ){
			throw new \Exception("invalid method $method");
		}
		
		$this->method = $method;
	}
	
	public function rowStart(){
		$this->rows[] = new BootstrapFormRow();
		$this->isNewRow = false;
	}
	
	public function rowEnd(){
		$this->isNewRow = true;
	}
	
	public function typeGet(){
		return $this->type;
	}
	
	public function typeSet($newType){
		// Ensure supplied form type is valid
		if( in_array($newType, $this->formTypes) ){
			$this->type = $newType;
			
			// Initialize label and field column grid config if form is horizontal.
			if( $newType == 'horizontal' ){
				$this->labelColConfig = new BootstrapGridConfig('sm', 2);
				$this->fieldColConfig = new BootstrapGridConfig('sm', 10);
			}
		}
	}
	
	public function view(){
		$formClass = '';
		if( $this->type != 'basic' ){
			$formClass = "class='form-" . $this->type . "'";
		}
		$formId = '';
		if( !empty($this->id) ){
			$formId = "id='" . $this->id . "'";
		}
		$formAction = '';
		if( !empty($this->action) ){
			$formAction = "action='" . $this->action . "'";
		}
		$str = "<form $formClass $formId $formAction" . $this->additionalAttr . ">";
		
		foreach($this->rows as $r){
			switch($this->type){
				case 'basic':
					$str .= $r->viewBasic($this->isShowLabel);
					break;
				
				case 'inline':
					$str .= $r->viewInline($this->isShowLabel) . ' ';
					break;
				
				case 'horizontal':
					$str .= $r->viewHorizontal($this->isShowLabel, $this->labelColConfig, $this->fieldColConfig);
					break;
				
				default:
					\util\Debug::switchFailed("switch failed this->type: " . $this->type);
					break;
			}
		}
		
		// Print form buttons
		$str .= $this->viewButtons();
		
		$str .= "</form>";
		return $str;
	}
	
	public function viewButtons(){
		$str = '';
		
		if( !empty($this->buttons) ){
			$buttonStr = '';
			
			foreach($this->buttons as $b){
				$buttonStr .= $b->view() . "\n";
			}
			
			// Only print form-group divs for horizontal form
			if( $this->type == 'horizontal' ){
				// Add offset to field column grid config
				foreach($this->labelColConfig->getAllItemObjs() as $i){
					$this->fieldColConfig->addItemObj( $i->getOffsetObj() );
				}
				
				$str .= "<div class='form-group'>
					<div class='" . $this->fieldColConfig->toString() . "'>
						$buttonStr
					</div>
				</div>";
			}
			else{
				$str .= $buttonStr;
			}
		}
		
		return $str;
	}
}
