<?php

namespace WCM\AstroFields\Examples\SettingsSection;

/**
 * Plugin Name: (WCM) AstroFields Settings Section Example
 * Description: Settings section example plugin
 */

// Composer autoloader
require_once __DIR__."/vendor/autoload.php";


use WCM\AstroFields\Core\Mediators\Entity;
use WCM\AstroFields\Core\Commands\ViewCmd;

use WCM\AstroFields\Settings\Commands\SettingsSection;
use WCM\AstroFields\Settings\Commands\DeleteOption;
use WCM\AstroFields\Settings\Commands\SanitizeString;
use WCM\AstroFields\Settings\Receivers\OptionValue;
use WCM\AstroFields\Settings\Templates\SectionTmpl;
use WCM\AstroFields\Standards\Templates\InputFieldTmpl;


add_action( 'admin_init', function()
{
	if ( ! is_admin() )
		return;

	// Commands
	$input_view = new ViewCmd;
	$input_view
		->setProvider( new OptionValue )
		->setTemplate( new InputFieldTmpl );

	// Entity: Field
	$input_field = new Entity( 'wcm_settings_field', array(
		'general',
		'permalink',
	) );
	// Attach Commands to Field
	$input_field
		->attach( $input_view )
		->attach( new DeleteOption )
		->attach( new SanitizeString );

	// Command: Settings Section
	$section_cmd = new SettingsSection;
	$section_cmd
		->setTitle( 'Some Title' )
		->attach( $input_field, 0 )
		->setTemplate( new SectionTmpl );

	// Entity: Settings Section
	$section = new Entity( 'wcm_settings_section', array(
		'general',
		'permalink',
	) );
	$section->attach( $section_cmd );
} );