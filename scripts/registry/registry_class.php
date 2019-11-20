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

namespace Scripts\Registry;

interface registryInterface {

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface Method Registry::registered
	 * @param 		[ String ]	$property 	= Property name
	 * @return 		[ Boolean ]
	 * @example		Registry::registered( "logging" );
	 *
	 * Checks if a property is available
	 *
	 */

	public function registered( string $property );

	/**
	 *
	 * @final 		True
	 * @access 	 	Public
	 * @method 		Interface Method Registry::setProperty
	 * @param 		[ String ]	$property 	= Property name
	 * @param 		[ Mixed ]	$value 		= Property value
	 * @return 		[ Boolean ]
	 * @example		Registry::setProperty( "version" , "1.0.0" );
	 *
	 * For registry class sets a property that is not present in the external
	 *
	 */

	public function setProperty( string $property , $value );

	/**
	 *
	 * @final 		True
	 * @access 	 	Public
	 * @method 		Interface Method Registry::removeProperty
	 * @param 		[ String ]	$property 	= Property to be deleted
	 * @return 		[ Boolean ]
	 * @example		Registry::removeProperty( "logging" );
	 *
	 * Delete the specified property
	 *
	 */


	public function removeProperty( string $property );

	/**
	 *
	 * @final 		True
	 * @access 	 	Public
	 * @method 		Interface Method Registry::getAllProperties
	 * @param 		[ Void ]
	 * @return 		[ Array ]
	 * @example		Registry::getAllProperties( void );
	 *
	 * All properties in the registry class
	 *
	 */


	public function getAllProperties();

	/**
	 *
	 * @final 		True
	 * @access 	 	Public
	 * @static 		True
	 * @method 		Interface Method Registry::return
	 * @param 		[ Void ]
	 * @return 		[ Object ]
	 * @example 	Registry::return();
	 *
	 * Returns class of registry
	 *
	 */

	public static function return();

	/**
	 *
	 * @final 		True
	 * @access 	Public
	 * @method 		Interface Method Registry::__set -Magic Method-
	 * @param 		[ String ]	$property 	= Property name
	 * @param 		[ Object ]	$value 		= Property value
	 * @return 		[ Boolean ]
	 * @example		Registry::__set( -Magic Method- );
	 *
	 * For registry class sets a property that is not present in the external
	 *
	 */

	public function __set( string $name , object $value );

	/**
	 *
	 * @final 		True
	 * @access 	 	Public
	 * @method 		Interface Method Registry::__get Referenced
	 * @param 		[ String ]	$property 	= Property name
	 * @return 		[ Array ]
	 * @example		Registry::__get(  );
	 *
	 * Returns the specified property in the registry class
	 *
	 */

	public function &__get( string $name );

}

final class Registry implements registryInterface {

	/**
	 *
	 * @access 	 	Public
	 * @static 		True
	 * @property 	[ Array ]	$storage 	= Properties array
	 *
	 * Properties array
	 *
	 */

	private $storage 			= NULL;

	/**
	 *
	 * @access 	 	Public
	 * @static 		True
	 * @property 	[ Object ]	$instance 		= Registry object
	 *
	 * Property with registry class
	 *
	 */

	private static $instance 	= NULL;

	final public function registered( string $property ) : bool {

		if ( array_key_exists( strtolower( $property ) , ( array ) $this->storage ) != True ) {
			
			return False;

		}

		return True;

	}

	final public function setProperty( string $property , $value ) : bool {

		if ( $this->registered( $property ) ) {
			
			if ( $this->registered( "logging" ) != False ) {
				
				$this->storage[ "logging" ]->write( "registry" , \Scripts\Libraries\Logging\WARNING , "Property ".strtolower( $property )." already exists" , True );

			}

			return False;

		}

		$this->storage[ strtolower( $property ) ] = $value;
		return True;

	}

	final public function removeProperty( string $property ) : bool {

		if ( $this->registered( $property ) != True ) {
			
			if ( $this->registered( "logging" ) != False ) {
				
				$this->storage[ "logging" ]->write( "registry" , \Scripts\Libraries\Logging\WARNING , "Deletion could not be applied because no such '".strtolower( $property )."' property exists" , True );

			}

			return False;

		}

		unset( $this->storage[ strtolower( $property ) ] );
		return True;

	}

	final public function getAllProperties() : array {

		return ( array ) $this->storage;

	}

	final public static function return() : object {

		if ( is_null(  static::$instance ) || !is_object( static::$instance ) ) {
			
			 static::$instance = new self;

		}

		return static::$instance;

	}

	final public function __set( string $name , object $value ) : bool {

		if ( isset( $value ) && is_object( $value ) != True ) {
			
			if ( $this->registered( "logging" ) != False ) {
				
				$this->storage[ "logging" ]->write( "registry" , \Scripts\Libraries\Logging\WARNING , "Only objects can be added to the registry class '".strtolower( $name )."'" , True );

			}

			return False;

		}

		if ( $this->registered( $name ) != False ) {
			
			if ( $this->registered( "logging" ) != False ) {
				
				$this->storage[ "logging" ]->write( "registry" , \Scripts\Libraries\Logging\WARNING , "Property ".strtolower( $name )." already exists" , True );

			}

			return False;

		}

		$this->storage[ strtolower( $name ) ] = $value;
		return True;

	}

	final public function &__get( string $name ) {

		if ( $this->registered( $name ) != True ) {
			
			if ( $this->registered( "logging" ) != False ) {
				
				$this->storage[ "logging" ]->write( "registry" , \Scripts\Libraries\Logging\WARNING , "Property ".strtolower( $name )." doesn't exists" , True );

			}

			return False;

		}

		return $this->storage[ strtolower( $name ) ];

	}

}

?>