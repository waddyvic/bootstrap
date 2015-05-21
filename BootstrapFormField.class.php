<?php
namespace ui;
require_once(__DIR__ . '/FormField.class.php');
require_once(__DIR__ . '/BootstrapGridConfig.class.php');
/*
This class extends FormField class and adds Bootstrap 3 features. This will act as parent class for all Bootstrap form field subclass for different input types.
*/

class BootstrapFormField extends FormField{
	
	public function viewBasic(){
		$str = "<div class='form-group'>
			<label for='" . $this->id . "'>" . $this->label . "</label>
			" . $this->view() . "
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
		
		$str = "<div class='form-group'>
			<label for'" . $this->id . "' class='" . $labelColConfig->toString() . " control-label'>" . $this->label . "</label>
			<div class='" . $fieldColConfig->toString() . "'>" . $this->view() . "</div>
		</div>";
		
		return $str;
	}
	
	public function viewInline($isShowLabel = false){
		$str = "<div class='form-group'>
			<label class='sr-only' for='" . $this->id . "'>" . $this->label . "</label>
			" . $this->view() . "
		</div>";
		
		return $str;
	}
}
