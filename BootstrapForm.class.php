<?php
namespace ui;
require_once('BootstrapGridConfig.class.php');
require_once('BootstrapFormFieldButton.class.php');
require_once('BootstrapFormFieldCheckbox.class.php');
require_once('BootstrapFormFieldHidden.class.php');
require_once('BootstrapFormFieldPassword.class.php');
require_once('BootstrapFormFieldRadio.class.php');
require_once('BootstrapFormFieldStatic.class.php');
require_once('BootstrapFormFieldText.class.php');
require_once('BootstrapFormFieldTextArea.class.php');
/*
This class creates an array of form fields and generate HTML form using Bootstrap 3.

Instance variables:
- type: type of Bootstrap 3 forms, can be
	-> basic: normal form
	-> inline: inline form
	-> horizontal: horizontal form
- formTypes: array of possible form types
- formFields: array of form fields
- formButtons: array of form fields with type "button". Typically "Submit" and "Cancel" buttons.
*/

class BootstrapForm
{
	protected $type;
	protected $formTypes = array('basic', 'inline', 'horizontal');
	protected $formFields = array();
	protected $formButtons = array();
	
	public function __construct($newType = 'basic'){
		$this->typeSet($newType);
	}
	
	public function addButton($formButton){
		$this->formButtons[] = $formButton;
	}
	
	public function addField($formField){
		$this->formFields[] = $formField;
	}
	
	public function typeGet(){
		return $this->type;
	}
	
	public function typeSet($newType){
		// Ensure supplied form type is valid
		if( in_array($newType, $this->formTypes) ){
			$this->type = $newType;
		}
	}
	
	public function view(){
		$formClass = '';
		if( $this->type != 'basic' ){
			$formClass = "class='form-" . $this->type . "'";
		}
		
		$str = "<form $formClass>";
		
		foreach($this->formFields as $f){
			switch($this->type){
				case 'basic':
					$str .= $f->viewBasic();
					break;
				
				case 'inline':
					$str .= $f->viewInline() . ' ';
					break;
				
				case 'horizontal':
					$str .= $f->viewHorizontal();
					break;
				
				default:
					\util\Debug::switchFailed("switch failed this->type: " . $this->type);
					break;
			}
		}
		
		$str .= "</form>";
		return $str;
	}	
}
