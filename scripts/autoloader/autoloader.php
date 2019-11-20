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

namespace Scripts\Autoloader;

interface AutoLoaderInterface {

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface Method Autoloader::__construct
	 * @param 		[ Void ]
	 * @return 		[ Boolean ]
	 * @example		Autoloader::__construct()
	 *
	 */

	public function __construct();

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface Method Autoloader::registerClass
	 * @param 		[ Void ]
	 * @return 		[ Boolean ]
	 * @example 	Autoloader::registerClass();
	 *
	 */

	public function registerClass();

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface Method Autoloader::registerClass
	 * @param 		[ String ]	$class = Class Name
	 * @return 		[ Boolean ]
	 * @example 	Autoloader::loaderClass();
	 *
	 */
		
	public function classLoader( string $class );

}

final class Autoloader implements AutoLoaderInterface {

	final public function __construct() {

		$this->registerClass();

	}

	final public function registerClass() : bool {

		return spl_autoload_register( [ $this , "classLoader" ] );

	}

	final public function classLoader( string $class ) : bool {

		$namespace = "Scripts".DIRECTORY_SEPARATOR;

		if ( strncmp( $class , $namespace , strlen( $namespace ) ) != 0 ) {
			
			return False;

		}

		$class = dirname( __DIR__ ).DIRECTORY_SEPARATOR.substr( $class , strlen( $namespace ) )."_class.php";

		if ( !file_exists( $class ) || !is_file( $class ) ) {
			
			trigger_error( "Specified class directory not found '".basename( $class )."'" , E_USER_WARNING );
			return False;

		}

		if ( !is_readable( $class ) ) {
			
			trigger_error( "Specified class could not be read, please check chmod permissions '".basename( $class )."'" , E_USER_WARNING );
			return False;

		}

		require_once $class;

		return True;

	}

}


?>