<?php
namespace ui;

class BootstrapIcon
{
	public static function view( $icon, $isAssistive = false, $assistiveTxt = "" ) {
		$str = "<span class='glyphicon glyphicon-$icon' aria-hidden='true'></span>";
		
		if($isAssistive) {
			$str .= "<span class='sr-only'>$assistiveTxt</span>";
		}
		
		return $str;
	}
}
