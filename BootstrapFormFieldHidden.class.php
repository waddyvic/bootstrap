<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for hidden input.
*/

class BootstrapFormFieldHidden extends BootstrapFormField{
	public function view(){
		$str = "<input type='hidden' ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( strlen($this->value) > 0 ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewBasic() function
	$isShowLabel will be ignored
	*/
	public function viewBasic($isShowLabel = true){
		return $this->view();
	}
	
	/*
	Override BootstrapFormField::viewHorizontal() function
	*/
	public function viewHorizontal($isShowLabel = true, $labelColConfig = null, $fieldColConfig = null){
		return $this->view();
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view();
	}
}
