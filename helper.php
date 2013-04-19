<?php

class Helper {
		
	public static function setCheckboxes( $name )
	{
		if( isset( $_POST ) ) {
			$selected = $_POST;
			foreach( $selected as $key => $value ) {
				$selectedElems[] = $key."_".$value; 
			}
		}
		if( in_array( $name, $selectedElems ) ) {
			echo "checked";
			return;
		} else {
			return "";
		}
	}
}
