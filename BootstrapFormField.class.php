<?php
namespace ui;
require_once(__DIR__ . '/FormField.class.php');
/*
This class extends FormField class and adds Bootstrap 3 features.
*/

class BootstrapFormField extends FormField{
	public $layout = 'stacked';		// Field layout used for radio or checkbox. Can be either stacked or inline.
	
	protected function viewAsButton(){
		$str = "<button type='button' ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->label . "</button>";
		
		return $str;
	}
	
	protected function viewAsCheckbox(){
		$str = '';
		
		$inputStr = "<input type='checkbox' ";
		$inputStr .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$inputStr .= ( $this->value ? "checked " : "");
		$inputStr .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$inputStr .= ( $this->isDisabled ? "disabled " : "" );
		$inputStr .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$inputStr .= "/> " . $this->label;
		
		if( $this->layout == 'stacked' ){
			$str .= "<div class='checkbox'>
				<label>
					$inputStr
				</label>
			</div>";
		}
		else if( $this->layout == 'inline' ){
			$str .= "<label class='checkbox-inline'>$inputStr</label>\n";
		}
		
		return $str;
	}
	
	protected function viewAsHidden(){
		$str = "<input type='hidden' ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->value) ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
	
	protected function viewAsPassword()
	{
		$str = "<input type='password' ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->value) ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
	
	protected function viewAsStatic(){
		$str = "<p class='form-control-static";
		$str .= ( !empty($this->class) ? " " . $this->class : "") . "' ";
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->value . "</p>";
		
		return $str;
	}
	
	protected function viewAsRadio(){
		$str = '';
		
		foreach($this->options as $o){
			$inputStr = "<input type='radio' ";
			$inputStr .= ( !empty($this->id) ? "name='" . $this->id . "' " : "");
			$inputStr .= ( !empty($this->value) ? "value='" . $o->value . "' " : "");
			$inputStr .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
			$inputStr .= ( $this->isDisabled ? "disabled " : "" );
			$inputStr .= ( $o->isSelected ? "checked " : "" );
			$inputStr .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
			$inputStr .= "/> " . $o->label;
			
			if( $this->layout == 'stacked' ){
				$str .= "<div class='radio'>
					<label>
						$inputStr
					</label>
				</div>";
			}
			else if( $this->layout == 'inline' ){
				$str .= "<label class='radio-inline'>$inputStr</label>\n";
			}
		}
		
		return $str;
	}
	
	protected function viewAsSelect(){
		//@todo. FWK DB class already has viewAsSelect.
		return null;
	}
	
	protected function viewAsText(){
		$str = "<input type='text' ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->value) ? "value='" . $this->value . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= "/>";
		
		return $str;
	}
	
	protected function viewAsTextArea()
	{
		$str = "<textarea ";
		$str .= ( !empty($this->class) ? "class='" . $this->class . "' " : "");
		$str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->placeholder) ? "placeholder='" . $this->label . "' " : "");
		$str .= ( !empty($this->style) ? "style='" . $this->style . "' " : "");
		$str .= ( $this->isDisabled ? "disabled " : "" );
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">";
		$str .= $this->value;
		$str .= "</textarea>";
		
		return $str;
	}
	
	public function viewBasic(){
		// For hidden input, just return the hidden field
		if( $this->type == 'hidden' || $this->type == 'button' ){
			return $this->viewInput() . "\n";
		}
		else{
			$str = "<div class='form-group'>\n";
			
			// radio and checkbox will print its own <label> tag as each option has its own label tag.
			if( $this->type != 'radio' && $this->type != 'checkbox' ){
				$str .= "<label for='" . $this->id . "'>" . $this->label . "</label>\n";
			}
			
			$str .= $this->viewInput() . "\n";
			
			$str .= "</div>\n";
			
			return $str;
		}
	}
	
	/*
	@param labelCol: array of class for label column. Each element is in the following format:
		labelCol = array(
			screen: screen size (i.e., the "sm" of "col-sm-2")
			size: column size, 1 to 12
		);
	*/
	public function viewHorizontal( $labelCol = array() ){
		// For hidden input, just return the hidden field
		if( $this->type == 'hidden'){
			return $this->viewInput() . "\n";
		}
		else{
			// Make default value if not exist.
			if( empty($labelCol) ){
				$labelCol[] = array(
					'screen' => 'sm',
					'size' => 2
				);
			}
			
			// Create HTML class for label and field column
			$labelColClass = array();
			$fieldColClass = array();
			
			foreach($labelCol as $c){
				$fieldColSize = 12 - $c['size'];
				$labelColClass[] = 'col-' . $c['screen'] . '-' . $c['size'];
				$fieldColClass[] = 'col-' . $c['screen'] . '-' . $fieldColSize;
			}
			
			$str = "<div class='form-group'>\n";
			
			// radio, checkbox and buttons will not display label in label column. Instead, add class to container
			$noLabelType = array('radio', 'checkbox', 'button');
			if( in_array($this->type, $noLabelType) ){
				foreach($labelCol as $c){
					$fieldColClass[] = 'col-' . $c['screen'] . '-offset-' . $c['size'];
				}
			}
			else{
				$str .= "<label class='" . implode(' ', $labelColClass) . "' for='" . $this->id . "'>" . $this->label . "</label>\n";
				
			}
			
			$str .= "<div class='" . implode(' ', $fieldColClass) . "'>\n";
			$str .= $this->viewInput();
			$str .= "</div>\n";
			$str .= "</div>\n";
			
			return $str;
		}
	}
	
	public function viewInline(){
		// For hidden input, just return the hidden field
		if( $this->type == 'hidden' || $this->type == 'button'  ){
			return $this->viewInput() . "\n";
		}
		else{
			$str = "<div class='form-group'>\n";
			
			// radio and checkbox will print its own <label> tag as each option has its own label tag.
			if( $this->type != 'radio' && $this->type != 'checkbox' ){
				$str .= "<label class='sr-only' for='" . $this->id . "'>" . $this->label . "</label>\n";
			}
			
			// Force show placeholder
			$this->placeholder = $this->label;
			
			$str .= $this->viewInput() . "\n";
			
			$str .= "</div>\n";
			
			return $str;
		}
	}
	
	protected function viewInput(){
		$str = '';
		
		// Return srcCode if current input is set to use srcCode
		if( $this->useSrcCode ){
			$str = $this->srcCode;
		}
		else{
			// Add form-control class to inputs
			switch($this->type){
				case 'password':
				case 'select':
				case 'text':
				case 'textarea':
					$this->class = ( strlen($this->class) == 0 ? "" : " " ) . "form-control";
					break;
			}
		
			switch($this->type){
				case 'button':
					$str .= $this->viewAsButton();
					break;
					
				case 'checkbox':
					$str .= $this->viewAsCheckbox();
					break;
				
				case 'hidden':
					$str .= $this->viewAsHidden();
					break;
				
				case 'password':
					$str .= $this->viewAsPassword();
					break;
				
				case 'radio':
					$str .= $this->viewAsRadio();
					break;
				
				case 'select':
					$str .= $this->viewAsSelect();
					break;
				
				case 'text':
					$str .= $this->viewAsText();
					break;
					
				case 'textarea':
					$str .= $this->viewAsTextArea();
					break;
				
				default:
					\util\Debug::switchFailed("switch failed type: " . $this->type);
					break;
			}
		}
		
		return $str;
	}
}
