<?php

/**
 * Instantiates all other scripts needed
 */
class Kirki_Scripts_Registry {

	public function __construct() {

		$dependencies = new Kirki_Scripts_Customizer_Default_Scripts();
		$postmessage  = new Kirki_Scripts_Customizer_PostMessage();
		$tooltips     = new Kirki_Scripts_Customizer_Tooltips();
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$stepper      = new Kirki_Scripts_Customizer_Stepper();

	}

	public static function prepare( $script ) {
		return '<script>jQuery(document).ready(function($) { "use strict"; ' . $script . '});</script>';
	}

}
