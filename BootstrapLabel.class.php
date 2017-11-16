<?php
namespace ui;

class BootstrapLabel{
    const LABEL_DANGER = 'label-danger';
    const LABEL_DEFAULT = 'label-default';
    const LABEL_INFO = 'label-info';
    const LABEL_PRIMARY = 'label-primary';
    const LABEL_SUCCESS = 'label-success';
    const LABEL_WARNING = 'label-warning';

    const VALID_TYPES = array(
        self::LABEL_DANGER,
        self::LABEL_DEFAULT,
        self::LABEL_INFO,
        self::LABEL_PRIMARY,
        self::LABEL_SUCCESS,
        self::LABEL_WARNING,
    );

    public static function isValidType($labelType){
        return in_array($labelType, self::VALID_TYPES);
    }

	public static function view($labelText, $labelType = self::LABEL_DEFAULT) {
        if( !self::isValidType($labelType) ){
            $labelType = self::LABEL_DEFAULT;
        }

		$str = "<span class='label $labelType'>$labelText</span>";
		
		return $str;
	}
}
