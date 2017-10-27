<?php
namespace ui;
require_once(__DIR__ . '/BootstrapFormField.class.php');
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

    public function typeSet($type = self::TYPE_LINK){
        if( self::isValidType($type) ){
            $this->type = $type;
            if( $type == self::TYPE_BUTTON ){
                $this->addClass('btn btn-default');
            }
            else{
                $this->removeClass('btn btn-default');
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
