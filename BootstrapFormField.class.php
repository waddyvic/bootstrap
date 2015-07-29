<?php
namespace ui;
require_once(__DIR__ . '/FormField.class.php');
require_once(__DIR__ . '/BootstrapGridConfig.class.php');
/*
This class extends FormField class and adds Bootstrap 3 features. This will act as parent class for all Bootstrap form field subclass for different input types.
*/

class BootstrapFormField extends FormField{
	public $addonPre;
	public $addonPost;
	
	public function viewBasic(){
		$inputStr = $this->view();
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$inputStr = "<div class='input-group'>";
			
			if( !empty($this->addonPre) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			$inputStr .= $this->view();
			
			if( !empty($this->addonPost) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$inputStr .= "</div>";
		}
		
		$str = "<div class='form-group'>
			<label for='" . $this->id . "'>" . $this->label . "</label>
			$inputStr
		</div>";
		
		return $str;
	}
	
	/*
	@param labelColConfig: BootstrapGridSize object that specifies size for label column
	@param fieldColConfig: BootstrapGridSize object that specifies size for field column
	*/
	public function viewHorizontal($labelColConfig = null, $fieldColConfig = null){
		// Set default grid size if not provided
		if( is_null($labelColConfig) ){
			$labelColConfig = new BootstrapGridConfig('sm', 2);
		}
		if( is_null($fieldColConfig) ){
			$fieldColConfig = new BootstrapGridConfig('sm', 10);
		}
		
		$inputStr = $this->view();
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$inputStr = "<div class='input-group'>";
			
			if( !empty($this->addonPre) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			$inputStr .= $this->view();
			
			if( !empty($this->addonPost) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$inputStr .= "</div>";
		}
		
		$str = "<div class='form-group'>
			<label for'" . $this->id . "' class='" . $labelColConfig->toString() . " control-label'>" . $this->label . "</label>
			<div class='" . $fieldColConfig->toString() . "'>$inputStr</div>
		</div>";
		
		return $str;
	}
	
	public function viewInline($isShowLabel = false){
		$inputStr = $this->view();
		
		// Make label screen reader only if not showing label
		$labelClass = '';
		if( !$isShowLabel ){
			$labelClass = 'sr-only';
		}
		
		// Add addon to input if exists
		if( !empty($this->addonPre) || !empty($this->addonPost) ){
			$inputStr = "<div class='input-group'>";
			
			if( !empty($this->addonPre) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPre . "</div>";
			}
			
			$inputStr .= $this->view();
			
			if( !empty($this->addonPost) ){
				$inputStr .= "<div class='input-group-addon'>" . $this->addonPost . "</div>";
			}
			
			$inputStr .= "</div>";
		}
		
		$str = "<div class='form-group'>
			<label class='$labelClass' for='" . $this->id . "'>" . $this->label . "</label>
			$inputStr
		</div>";
		
		return $str;
	}
}
