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

namespace Scripts\Libraries\Language;

interface LangaugeInterface {

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::setLanguageFolder
	 * @param 	[ String ] $folder 	= Language folder
	 * @return 	[ Object ]
	 * @example Language::setLanguageFolder( "languages" )
	 * 
	 * Assigns the language folder to use for the system
	 *
	 */

	public function setLanguageFolder( string $folder );

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::setLanguage
	 * @param 	[ String ] $language 	= Language name
	 * @return 	[ Object ]
	 * @example Language::setLanguage( "languages" )
	 * 
	 * Language to use for the system
	 *
	 */

	public function setLanguage( string $language );

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::setLanguageType
	 * @param 	[ String ] $type 	= Language file type
	 * @return 	[ Object ]
	 * @example Language::setLanguageType( "json" )
	 * 
	 * Type of language file to open, only 'default' and 'json'
	 *
	 */

	public function setLanguageType( string $type );

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::check
	 * @return 	[ Boolean ]
	 * @example Language::check( )
	 * 
	 * Checks the values ​​provided for system operation
	 *
	 */

	public function check();

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::load
	 * @param 	[ String ] $file 	= Language file
	 * @return 	[ Boolean ]
	 * @example Language::load( "index" )
	 * 
	 * Name of the language file to open without extension
	 *
	 */

	public function load ( string $file );

	/**
	 *
	 * @final 	True
	 * @access 	Public
	 * @method 	Interface method Language::getExtension
	 * @param 	[ String ] $type 	= Language type
	 * @return 	[ Boolean ]
	 * @example Language::getExtension( "json" )
	 * 
	 * Returns an file extension for the specified type
	 *
	 */

	public function getExtension( string $type );

}

final class Language implements LangaugeInterface {

	/**
	 *
	 * @access 		Private
	 * @property 	$language = String language name
	 *
	 */

	private $language 		= NULL;

	/**
	 *
	 * @access 		Private
	 * @property 	$languageFolder = String language folder name
	 *
	 */

	private $languageFolder	= NULL;

	/**
	 *
	 * @access 		Private
	 * @property 	$languageFile = String language file name
	 *
	 */

	private $languageFile	= NULL;

	/**
	 *
	 * @access 		Private
	 * @property 	$languagePath = Path value
	 *
	 */

	private $languagePath	= NULL;

	/**
	 *
	 * @access 		Private
	 * @property 	$languageType = String langauge type
	 *
	 */

	private $languageType	= NULL;

	/**
	 *
	 * @access 		Private
	 * @property 	$registry = Registry Objcet
	 *
	 */

	private $registry 		= NULL;
	
	final public function setLanguageFolder( string $folder ) : object {

		$this->languageFolder = strtolower( trim( $folder ) );

		return $this;
		
	}

	final public function setLanguage( string $language ) : object {

		$this->language  = strtolower( trim( $language ) );

		return $this;

	}

	final public function setLanguageType( string $type ) : object {

		$this->languageType = strtolower( trim( $type ) );

		return $this;

	}

	final public function check() : bool {

		$this->registry = \Scripts\Registry\Registry::return();

		if ( is_null( $this->languageFolder ) || empty( $this->languageFolder ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Please do not leave blank enter a valid language dir" , True );
			return False;

		}

		if ( !file_exists( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder ) || !is_dir( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "No specified language dir found '{$this->languageFolder}'" , True );
			return False;

		}

		if ( !is_readable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder ) || !is_writable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Language dir is not readable or writeable please check chmod permissions '{$this->langfolder}'" , True );
			return False;

		}

		if ( is_null( $this->language ) || empty( $this->language ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Do not leave blank enter a valid language" , True );
			return False;

		}

		if ( !file_exists( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder.DIRECTORY_SEPARATOR.$this->language ) || !is_dir( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder.DIRECTORY_SEPARATOR.$this->language ) ) {
			 
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Could not find a folder for the specified language '{$this->language}'" , True );
			return False;

		}

		if ( !is_readable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder.DIRECTORY_SEPARATOR.$this->language ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "The folder that belongs to the specified language is not readable , check chmod '{$this->language}'" , True );
			return False;

		}

		if ( is_null( $this->languageType ) || empty( $this->languageType ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Please enter a valid type for the language to be read" , True );
			return False;

		}

		/*if ( $this->languageType != "default" || $this->languageType != "json" ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Currently available types only 'default' and 'json' please check the type you specify" , True );
			return False;

		}*/

		return True;

	}

	final public function load ( string $file ) : bool {

		$this->languageFile = trim( $file );

		if ( is_null( $this->languageFile ) || empty( $this->languageFile ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Enter a valid language file '{$this->languageFile}'" , True );
			return False;

		}

		$this->languagePath = ROOT_PATH.DIRECTORY_SEPARATOR.$this->languageFolder.DIRECTORY_SEPARATOR.$this->language.DIRECTORY_SEPARATOR.$this->languageFile."_lang".$this->getExtension( $this->languageType );

		if ( !file_exists( $this->languagePath ) || !is_file( $this->languagePath ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Could not find the specified '{$this->languageFile}' language file" , True );
			return False;

		}

		if ( !is_readable( $this->languagePath ) ) {
			
			$this->registry->logging->write( "language" , \Scripts\Libraries\Logging\ERROR , "Please check '{$this->languageFile}' file read chmod permissions" , True );
			return False;

		}

		if ( $this->languageType == "php" ) {
			
			require_once $this->languagePath;

		}

		if ( $this->languageType == "json" ) {
			
			$language = json_decode( file_get_contents( $this->languagePath , FILE_BINARY ) , True );

		}

		if ( isset( $language ) && is_array( $language ) ) {
			
			foreach ( $language as $key => $value ) {
				
				$value = preg_replace( "~<([A-Z]+)>~" , "%s" , $value );
				$this->$key = $value;

			}

			return True;

		}

		return False;

	}

	final public function getExtension( string $type ) : string {

		switch ( $type ) {

			case "json" :
				
				$extension = ".json";
				break;

			case "php" :

				$extension = ".php";
				break;
			
			default :
				
				$extension = ( string ) "";
				break;

		}

		return $extension;

	}

}

?>