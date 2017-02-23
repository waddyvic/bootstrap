<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
/*
This class extends BootstrapFormField class to implement view() function for radio inputs.
*/

class BootstrapFormFieldRadio extends BootstrapFormField{
	public $layout = 'stacked';

	public function view(){
		$str = '';
		
		foreach($this->options as $o){
			$inputStr = "<input type='radio' ";
			$inputStr .= ( !empty($this->id) ? "name='" . $this->id . "' " : "");
			$inputStr .= "value='" . $o->value . "' ";
			$inputStr .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
			$inputStr .= ( $this->isDisabled ? "disabled " : "" );
			$inputStr .= ( $o->isSelected ? "checked " : "" );
			$inputStr .= ( !empty($o->additionalAttr) ? $o->additionalAttr . " " : "");
			$inputStr .= "/> " . $o->label;
			
			if( $this->layout == 'stacked' ){
				$str .= "<div class='radio" . ( !empty($this->class) ? ' ' . implode(' ', $this->class) : '' ) . "'>
					<label>
						$inputStr
					</label>
				</div>";
			}
			else if( $this->layout == 'inline' ){
				$str .= "<label class='radio-inline" . ( !empty($this->class) ? ' ' . implode(' ', $this->class) : '' ) . "'>$inputStr</label>\n";
			}
			else{
				$str .= $inputStr . ' ';
			}
		}
		
		return $str;
	}
	
	/*
	Override BootstrapFormField default viewBasic().
	Note that the function will ignore $isShowLabel, since radio buttons without a label is useless.
	*/
	public function viewBasic($isShowLabel = true){
		return $this->view();
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view();
	}
}
