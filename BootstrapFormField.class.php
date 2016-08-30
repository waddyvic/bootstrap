<?php
namespace ui;
require_once(__DIR__ . '/FormField.class.php');
require_once(__DIR__ . '/BootstrapGridConfig.class.php');
/*
This class extends FormField class and adds Bootstrap 3 features. This will act as parent class for all Bootstrap form field subclass for different input types.
*/

class BootstrapFormField extends FormField{
	const VALIDATION_STATE_NONE = null;
	const VALIDATION_STATE_SUCCESS = 'success';
	const VALIDATION_STATE_WARNING = 'warning';
	const VALIDATION_STATE_ERROR = 'error';
	
	public $addonPre;
	public $addonPost;
	public $isVisible = true;
	protected $validationState;
	protected $isShowLabel = null;		// Override form's isShowLabel setting
	public $isShowFeedback = false;
	public $helpText = null;
	
	protected function feedbackStrGet(){
		$feedbackStr = "<span class='glyphicon glyphicon-ok form-control-feedback' aria-hidden='true'></span>
		<span class='glyphicon glyphicon-warning-sign form-control-feedback' aria-hidden='true'></span>
		<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>";
		
		return $feedbackStr;
	}
	
	public function labelHide(){
		$this->isShowLabel = false;
	}
	
	// Remove label visibility override
	public function labelVisibilityReset(){
		$this->isShowLabel = null;
	}
	
	public function labelShow(){
		$this->isShowLabel = true;
	}
	
	public function validationStateSet($validationState = self::VALIDATION_STATE_NONE, $isShowFeedback = false){
		// Ensure input is correct
		$allowedValue = array(self::VALIDATION_STATE_SUCCESS, self::VALIDATION_STATE_WARNING, self::VALIDATION_STATE_ERROR);
		
		if( $validationState != self::VALIDATION_STATE_NONE && !in_array($validationState, $allowedValue) ){
			throw new \Exception("invalid input: $validationState");
		}
		
		$this->validationState = $validationState;
		$this->isShowFeedback = ( $isShowFeedback == true );
	}
	
	public function viewBasic($isShowLabel = true){
		$inputStr = $this->view();
		if( $this->isShowFeedback ){
			$inputStr .= $this->feedbackStrGet();
		}
		$inputStr .= $this->viewHelpText();
		
		$formGroupClass = 'form-group';
		if( $this->validationState != self::VALIDATION_STATE_NONE ){
			$formGroupClass .= " has-" . $this->validationState;
			
			if( $this->isShowFeedback ){
				$formGroupClass .= " has-feedback";
			}
		}
		
		$labelClass = '';
		// Check if form field has override isShowLabel setting of form
		if( !is_null($this->isShowLabel) ){
			if( !$this->isShowLabel ){
				$labelClass = 'sr-only';
			}
		}
		// If no override, follow form setting
		else if( !$isShowLabel ){
			$labelClass = 'sr-only';
		}
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$preInputStr = "<div class='input-group'>";
			$postInputStr = '';
			
			if( !empty($this->addonPre) ){
				$preInputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			if( !empty($this->addonPost) ){
				/*
					In order to make feedback icon show up correctly when there is addon post, we need to wrap the input and the icon together with a relative position div.
				*/
				if( $this->isShowFeedback){
					$preInputStr .= "<div style='position:relative;'>";
					$postInputStr .= "</div>";
				}
				
				$postInputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$postInputStr .= "</div>";
			
			$inputStr = $preInputStr . $inputStr . $postInputStr;
		}
		
		$visibilityStr = '';
		if( !$this->isVisible ){
			$visibilityStr .= "style='display: none;'";
		}
		
		$str = "<div class='$formGroupClass' " . $visibilityStr . ">
			<label for='" . $this->id . "' class='$labelClass'>" . $this->label . "</label>
			$inputStr
		</div>";
		
		return $str;
	}
	
	public function viewHelpText(){
		$str = null;
		
		if( strlen($this->helpText) > 0 ){
			$str .= "<span id='" . $this->id . "HelpText' class='help-block'>" . $this->helpText . "</span>";
		}
		
		return $str;
	}
	
	/*
	@param labelColConfig: BootstrapGridSize object that specifies size for label column
	@param fieldColConfig: BootstrapGridSize object that specifies size for field column
	*/
	public function viewHorizontal($isShowLabel = true, $labelColConfig = null, $fieldColConfig = null){
		// Set default grid size if not provided
		if( is_null($labelColConfig) ){
			$labelColConfig = new BootstrapGridConfig('sm', 2);
		}
		if( is_null($fieldColConfig) ){
			$fieldColConfig = new BootstrapGridConfig('sm', 10);
		}
		
		$inputStr = $this->view();
		if( $this->isShowFeedback ){
			$inputStr .= $this->feedbackStrGet();
		}
		$inputStr .= $this->viewHelpText();
		
		$formGroupClass = 'form-group';
		if( $this->validationState != self::VALIDATION_STATE_NONE ){
			$formGroupClass .= " has-" . $this->validationState;
			
			if( $this->isShowFeedback ){
				$formGroupClass .= " has-feedback";
			}
		}
		
		// Check if form field has override isShowLabel setting of form
		if( !is_null($this->isShowLabel) ){
			$isShowLabel = $this->isShowLabel;
		}
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$preInputStr = "<div class='input-group'>";
			$postInputStr = '';
			
			if( !empty($this->addonPre) ){
				$preInputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			if( !empty($this->addonPost) ){
				if( $this->isShowFeedback ){
					/*
						In order to make feedback icon show up correctly when there is addon post, we need to wrap the input and the icon together with a relative position div.
					*/
					$preInputStr .= "<div style='position:relative;'>";
					$postInputStr .= "</div>";
				}
				
				$postInputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$postInputStr .= "</div>";
			
			$inputStr = $preInputStr . $inputStr . $postInputStr;
		}
		
		$visibilityStr = '';
		if( !$this->isVisible ){
			$visibilityStr .= "style='display: none;'";
		}
		
		$str = "<div class='$formGroupClass' " . $visibilityStr . ">
			<label for='" . $this->id . "' class='" . $labelColConfig->toString() . " control-label'>" . ($isShowLabel ? $this->label : '') . "</label>
			<div class='" . $fieldColConfig->toString() . "'>$inputStr</div>
		</div>";
		
		return $str;
	}
	
	public function viewInline($isShowLabel = false){
		$inputStr = $this->view();
		if( $this->isShowFeedback ){
			$inputStr .= $this->feedbackStrGet();
		}
		
		$formGroupClass = 'form-group';
		if( $this->validationState != self::VALIDATION_STATE_NONE ){
			$formGroupClass .= " has-" . $this->validationState;
			
			if( $this->isShowFeedback ){
				$formGroupClass .= " has-feedback";
			}
		}
		
		$labelClass = '';
		// Check if form field has override isShowLabel setting of form
		if( !is_null($this->isShowLabel) ){
			if( !$this->isShowLabel ){
				$labelClass = 'sr-only';
			}
		}
		// If no override, follow form setting
		else if( !$isShowLabel ){
			$labelClass = 'sr-only';
		}
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$preInputStr = "<div class='input-group'>";
			$postInputStr = '';
			
			if( !empty($this->addonPre) ){
				$preInputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			if( !empty($this->addonPost) ){
				if( $this->isShowFeedback ){
					/*
						In order to make feedback icon show up correctly when there is addon post, we need to wrap the input and the icon together with a relative position div.
					*/
					$preInputStr .= "<div style='position:relative;'>";
					$postInputStr .= "</div>";
				}
				
				$postInputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$postInputStr .= "</div>";
			
			$inputStr = $preInputStr . $inputStr . $postInputStr;
		}
		
		$str = "<div class='$formGroupClass'>
			<label class='$labelClass' for='" . $this->id . "'>" . $this->label . "</label>
			$inputStr
		</div>";
		
		return $str;
	}
}
