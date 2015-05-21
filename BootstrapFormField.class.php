<?php
namespace ui;
require_once(__DIR__ . '/FormField.class.php');
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
	
	public function viewHorizontal(){
		$str = "<div class='form-group'>
			<label for'" . $this->id . "' class='col-sm-2 control-label'>" . $this->label . "</label>
			<div class='col-sm-10'>" . $this->view() . "</div>
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
