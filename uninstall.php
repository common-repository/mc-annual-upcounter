<?php

	 // EXIT IF UNINSTALL CONSTANT IS NOT DEFINED
	if (!defined('WP_UNINSTALL_PLUGIN')) exit;


	// DELETE OPTIONS

	delete_option( 'mc6397au_seconds' );
	delete_option( 'mc6397au_total' );
