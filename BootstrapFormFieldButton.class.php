<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for button input.
*/

class BootstrapFormFieldButton extends BootstrapFormField{
	public function view(){
		$str = "<button type='button' ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->label . "</button>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewBasic() function
	*/
	public function viewBasic(){
		return $this->view() . ' ';
	}
	
	/*
	Override BootstrapFormField::viewHorizontal() function
	*/
	public function viewHorizontal(){
		$str = "<div class='form-group'>
			<div class='col-sm-offset-2 col-sm-10'>" . $this->view() . "</div>
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
