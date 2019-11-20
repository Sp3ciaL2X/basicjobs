<?php 

/**
 *
 * @author 		Sp3ciaL2X <Sp3ciaL2X@gmail.com>
 * @since 		2019
 * @license		We live in a free world
 * @copyright	By Sp3ciaL2X
 * @version 	1.0.0
 *
 **/

/**
 *
 * Path of the directory where the system is running
 *
 */


define( "ROOT_PATH" , dirname( __FILE__ ) );

/**
 *
 * Autoloader direct run
 *
 */

require_once "scripts/autoloader/autoloader.php";

new Scripts\Autoloader\Autoloader;

//--------------------------------------------------------
//-----------------------Examples-------------------------
//--------------------------------------------------------


$registy = Scripts\Registry\Registry::return();

$registy->logging = new Scripts\Libraries\Logging\Logging;
$registy->logging->setLogFolder( "logging" )->setErrorType( False )->checkLogSystem( True );
//$registy->logging->write( "test" , \Scripts\Libraries\Logging\ERROR , "Log system test" , True );

$registy->language = new Scripts\Libraries\Language\Language;
$registy->language->setLanguageFolder( "scripts".DIRECTORY_SEPARATOR."languages" )->setLanguage( "english" )->setLanguageType( "php" )->check();

$registy->language->load( "index" );

echo sprintf( $registy->language->index[ "welcome" ] , "Sp3ciaL2X" );

var_dump( $registy->registered( "language" ) )

?>