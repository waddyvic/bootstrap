<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
require_once(__DIR__ . '/BootstrapFormFieldButton.class.php');  // Use button styles code in this class.
/*
This class extends BootstrapFormField class to implement view() function for button input.
*/

class BootstrapFormFieldAnchor extends BootstrapFormField{
    const TYPE_LINK = 'link';
    const TYPE_BUTTON = 'button';
    protected static $allowedTypes = array(self::TYPE_LINK, self::TYPE_BUTTON);
    protected $type = self::TYPE_LINK;

    const TARGET_BLANK = '_blank';
    const TARGET_PARENT = '_parent';
    const TARGET_SELF = '_self';
    const TARGET_TOP = '_top';
    protected static $allowedTargets = array(self::TARGET_BLANK, self::TARGET_PARENT, self::TARGET_SELF, self::TARGET_TOP);
    protected $target = self::TARGET_SELF;

    protected $href;
	protected $isShowLabel = false;		// Default to hide label
	protected $isActive = null;
	
	public function __construct($id = null, $label = null, $value = null){
        parent::__construct($id, $label, $value);
	}

    // Clear all button styles
    public function btnStyleClear(){
        $this->removeClass('btn');
        // Remove other btn styles
        foreach(BootstrapFormFieldButton::VALID_BTN_STYLES as $s){
            $this->removeClass($s);
        }
    }

    // Set button style if the anchor type is button
    public function btnStyleSet($btnStyle = BootstrapFormFieldButton::BTN_STYLE_DEFAULT){
        if( $this->type != self::TYPE_BUTTON ){
            return false;
        }

        if( !BootstrapFormFieldButton::isValidBtnStyle($btnStyle) ){
            return false;
        }

        $this->addClass($btnStyle);
        // Also add 'btn' just in case
        $this->addClass('btn');

        // Remove other btn styles
        foreach(BootstrapFormFieldButton::VALID_BTN_STYLES as $s){
            if( $s != $btnStyle ){
                $this->removeClass($s);
            }
        }
    }

    /*
    Returns if this anchor has any button styles
    */
    public function hasBtnStyle(){
        $hasBtnStyle = false;

        // Check if anchor has any valid button styles
        foreach(BootstrapFormFieldButton::VALID_BTN_STYLES as $s){
            if( in_array($s, $this->class) ){
                $hasBtnStyle = true;
                break;
            }
        }

        return $hasBtnStyle;
    }

    public function hrefGet(){
        return $this->href;
    }

    public function hrefSet($href){
        $this->href = $href;
    }

    public function targetGet(){
        return $this->target;
    }

    public function targetSet($target = self::TARGET_SELF){
        if (self::isValidTarget($target) ){
            $this->target = $target;
            return true;
        }
        else{
            return false;
        }
    }

    public function typeGet(){
        return $this->type;
    }

    public function typeSet($type = self::TYPE_LINK, $btnStyle = BootstrapFormFieldButton::BTN_STYLE_DEFAULT){
        if( self::isValidType($type) ){
            $this->type = $type;
            if( $type == self::TYPE_BUTTON ){
                $this->btnStyleSet($btnStyle);
            }
            else{
                $this->btnStyleClear();
            }

            return true;
        }
        else{
            return false;
        }
    }

	public function view(){
		$str = "<a target='" . $this->target . "' href='$this->href' ";
		$str .= ( !empty($this->class) ? "class='" . implode(' ', $this->class) . "' " : "");
        $str .= ( !empty($this->id) ? "id='" . $this->id . "' name='" . $this->id . "' " : "");
		$str .= ( !empty($this->additionalAttr) ? $this->additionalAttr . " " : "");
		$str .= ">" . $this->label . "</a>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewBasic() function
	*/
	public function viewBasic($isShowLabel = false){
		return parent::viewBasic($isShowLabel);
	}
	
	/*
	Override BootstrapFormField::viewHorizontal() function
	*/
	public function viewHorizontal($isShowLabel = true, $labelColConfig = null, $fieldColConfig = null ){
		// Set default grid size if not provided
		if( is_null($labelColConfig) ){
			$btnLabelColConfig = new BootstrapGridConfig('sm', 2);
		} else {
			$btnLabelColConfig = clone $labelColConfig;
		}
		if( is_null($fieldColConfig) ){
			$btnFieldColConfig = new BootstrapGridConfig('sm', 10);
		} else {
			$btnFieldColConfig = clone $fieldColConfig;
		}
		
		// Use label column grid size config to determine field column config
		foreach($btnLabelColConfig->getAllItemObjs() as $i){
			$i->isOffset = true;
			$btnFieldColConfig->addItemObj($i);
		}
		
		$str = "<div class='form-group'>
			<div data-item='test' class='" . $btnFieldColConfig->toString() . "'>" . $this->view() . "</div>
		</div>";
		
		return $str;
	}
	
	/*
	Override BootstrapFormField::viewInline() function
	*/
	public function viewInline($isShowLabel = false){
		return $this->view() . ' ';
    }
    
    ////////////////////// static functions //////////////////////

    public static function isValidTarget($target){
        return in_array($target, self::$allowedTargets);
    }

    public static function isValidType($type){
        return in_array($type, self::$allowedTypes);
    }
}
