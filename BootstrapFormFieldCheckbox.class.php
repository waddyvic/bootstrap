<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for checkbox.
*/

class BootstrapFormFieldCheckbox extends BootstrapFormField{
	public $layout = 'stacked';

	public function view(){
		$str = '';
		
		$inputStr = "<input type='checkbox' ";
		$inputStr .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$inputStr .= ( $this->value ? "checked " : "");
		$inputStr .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$inputStr .= ( $this->isDisabled ? "disabled " : "" );
		$inputStr .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$inputStr .= "/> " . $this->label;
		
		if( empty($this->layout) || $this->layout == 'stacked' ){
			$str .= "<div class='checkbox" . ( !empty($this->class) ? ' ' . implode(' ', $this->class) : '' ) . "'>
				<label>" . $inputStr . "</label>
			</div>";
		}
		else if( $this->layout == 'inline' ){
			$str .= "<label class='checkbox-inline" . ( !empty($this->class) ? ' ' . implode(' ', $this->class) : '' ) . "'>" . $inputStr . "</label>\n";
		}
		else{
			$str .= $inputStr;
		}
		
		return $str;
	}
	
	/*
	Override BootstrapFormField default viewBasic().
	*/
	public function viewBasic(){
		return $this->view();
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view();
	}
}
