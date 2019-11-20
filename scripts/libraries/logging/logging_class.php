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

namespace Scripts\Libraries\Logging;

interface LoggingInterface {

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Logging::setLogFolder
	 * @param 		[ String ]	$folder	= Log folder to be specified in main directory
	 * @return 		[ Object ]
	 * @example 	Logging::setLogFolder( "logfiles" );
	 *
	 * Sets the log folder
	 *
	 */

	public function setLogFolder( string $folder );

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Logging::setErrorType
	 * @param 		[ Boolean ]	$type	= Error Type
	 * @return 		[ Object ]
	 * @example 	Logging::setErrorType( False );
	 *
	 * Sets the error type
	 *
	 */

	public function setErrorType( bool $type );

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Logging::checkLogSystem
	 * @param 		[ Boolean ]  $system 	= Variable required to start the log system bool
	 * @return 		[ Boolean ]
	 * @example 	Logging::checkLogSystem( True );
	 *
	 * Controls log system and criteria in system
	 *
	 */

	public function checkLogSystem( bool $system );

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Logging::write
	 * @param 		[ String ]	$logfile 	= Log file to be kept in log folder 
	 * @param 		[ Integer ]	$logtype 	= Error level
	 * @param 		[ String ]	$string 	= String data to be written to the log file
	 * @param 		[ Boolean ]	$onscreen 	= The data saved in the log file is also printed on the screen
	 * @return 		[ Boolean ]
	 * @example 	Logging::write( "logfile" , ERROR , "This is Logging First Message !" , True );
	 *
	 *	Write log message according to specified parameters
	 *
	 */

	public function write( string $logfile , int $logtype , string $string , bool $onscreen = False );

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method Logging::getErrors();
	 *
	 *	catch logging system errors
	 *
	 **/

	public function getErrors();

	/**
	 *
	 * @final 		True
	 * @access 		Public
	 * @method 		Interface method __destruct();
	 *
	 *	The log file opened to write to this section is being terminated
	 *
	 **/

	public function __destruct();

}

/**
*
* @const 	INFO = Sets a log line without the time and type label
*
*/

CONST INFO 		= 0;

/**
*
* @const 	ERROR = Sets a log line with an ERROR tag
*
*/

CONST ERROR 	= 1;

/**
*
* @const 	NOTICE = Sets a log line with an NOTICE tag
*
*/

CONST NOTICE 	= 2;

/**
*
* @const 	WARNING = Sets a log line with an WARNING tag
*
*/

CONST WARNING 	= 3;

/**
*
* @const 	PHPERROR = This is for const error handler , sets a log line with an PHPERROR tag
*
*/

CONST PHPERROR 	= 4;

final class Logging implements LoggingInterface {

	/**
	 *
	 * @access 	Private
	 * @property $logFolder	 = The Variable where the log folder is held
	 *
	 */

	private $logFolder		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $logFile	 = The variable in which the log file to be saved is held
	 *
	 */

	private $logFile		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $logType 	= The variable where the error levels are held
	 *
	 */

	private $logType		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $logLine 	= Generated log line
	 *
	 */

	private $logLine		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $logError 	= Error storage
	 *
	 */

	private $logError		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $errorType = Error Type
	 *
	 */

	private $errorType		= NULL;

	/**
	 *
	 * @access 	Private
	 * @property $resource 	= The resource value of opened file
	 *
	 */

	private $resource		= NULL;

	final public function setLogFolder( string $folder ) : object {

		$this->logFolder = trim( strtolower( $folder ) );

		return $this;

	}

	final public function setErrorType( bool $type ) : object {

		$this->errorType = $type;

		return $this;

	}

	final public function checkLogSystem( bool $system ) : bool {

		if ( is_bool( $system ) && $system != True ) {
			
			return False;

		}

		if ( is_null( $this->errorType ) || !is_bool( $this->errorType ) ) {
			
			trigger_error( "Please specify the error type or make sure you specify a boolean value" , E_USER_WARNING );
			return False;

		}

		if ( is_null( $this->logFolder ) || empty( $this->logFolder ) ) {
			
			if ( $this->errorType != False ) {

				trigger_error( "Enter a valid log folder name" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "folderName" ]	= "Enter a valid log folder name";

			}

			return False;

		}

		if ( !file_exists( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder ) || !is_dir( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder ) ) {
			
			if ( $this->errorType != False ) {
				
				trigger_error( "Please check if a log folder with the specified name could not be found" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "folderChmod" ] = "Please check if a log folder with the specified name could not be found";

			}

			return False;

		}

		if ( !is_readable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder ) || !is_writable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder ) ) {
			
			if ( $this->errorType != False ) {
				
				trigger_error( "Log folder is not readable or writeable please check chmod permissions" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "folderAccess" ] = "Log folder is not readable or writeable please check chmod permissions";

			}

			return False;

		}

		return True;

	}

	final public function write( string $logfile , int $logtype , string $string , bool $onscreen = False ) : bool {

		$this->logFile = trim( strtolower( $logfile ) );

		if ( empty( $this->logFile ) ) {

			if ( $this->errorType != False ) {
				
				trigger_error( "Enter a valid loging file name" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "fileName" ]  = "Enter a valid loging file name";

			}

			return False;

		}

		$this->logFile = $this->logFile."_logging.log";

		if ( !file_exists( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile ) || !is_file( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile ) ) {
			
			if ( !touch( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile ) ) {
				
				if ( $this->errorType != False ) {
				
					trigger_error( "The specified log file was not found and there was a problem re-creating '{$this->logFile}'" , E_USER_WARNING );

				}

				if ( $this->errorType != True ) {
				
					$this->logError[ "createFile" ]  = "The specified log file was not found and there was a problem re-creating '{$this->logFile}'";

				}

				return False;

			}

		}

		if ( !is_readable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile ) || !is_writable( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile ) ) {
			
			if ( $this->errorType != False ) {
				
				trigger_error( "Log file is not readable or writeable please check chmod permissions '{$this->logFile}'" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "fileChmod" ]  = "Log file is not readable or writeable please check chmod permissions '{$this->logFile}'";

			}

			return False;

		}

		$this->logType = array( INFO => "Info" , ERROR => "Error" , NOTICE => "Notice" , WARNING => "Warning" , PHPERROR => "Php-Error" );
		$this->logLine = "[".date( "d-m-y H:i:s" )."] - ".$this->logType[ $logtype ]." : ".ucfirst( $string ).PHP_EOL;

		if ( is_resource( $this->resource = fopen( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile , "a" ) ) != True ) {
			
			if ( $this->errorType != False ) {
				
				trigger_error( "There was a problem opening the log file and it failed to open '{$this->logFile}'" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "source" ] = "There was a problem opening the log file and it failed to open '{$this->logFile}'";

			}

			return False;

		}

		$getLine = file( ROOT_PATH.DIRECTORY_SEPARATOR.$this->logFolder.DIRECTORY_SEPARATOR.$this->logFile , FILE_BINARY );

		if ( isset( $getLine ) && array_shift( $getLine ){ 0 } != chr( 61 ) ) {
			
			$response	 = str_repeat( chr( 61 ) , 80 ).PHP_EOL;
			$response	.= str_pad( " Log system initialized " , 80 ,chr( 61 ) , STR_PAD_BOTH ).PHP_EOL;
			$response	.= str_pad( gmdate( " d-m-y H:i:s " ) , 80 , chr( 61 ) , STR_PAD_BOTH ).PHP_EOL;
			$response	.= str_repeat( chr( 61 ) , 80 ).PHP_EOL;
			$response	.= PHP_EOL;
			$response	.= "# Success - Checking log folder".PHP_EOL;
			$response	.= "# Success - Checking log file".PHP_EOL;
			$response	.= "# Success - Checking chmod of log file".PHP_EOL;
			$response	.= PHP_EOL;
			$response	.= str_repeat( chr( 61 ) , 80 ).PHP_EOL;
			$response	.= str_pad( " Log system Started " , 80 , chr( 61 ) , STR_PAD_BOTH ).PHP_EOL;
			$response	.= str_pad( " https://github.com/Sp3ciaL2X " , 80 , chr( 61 ) , STR_PAD_BOTH ).PHP_EOL;
			$response	.= str_repeat( chr( 61 ) , 80 ).PHP_EOL;
			$response	.= PHP_EOL;

			if ( fwrite( $this->resource , $response ) != True ) {
				
				if ( $this->errorType != False ) {
				
					trigger_error( "There was a problem processing start data in the log file" , E_USER_WARNING );

				}

				if ( $this->errorType != True ) {
				
					$this->logError[ "response" ] = "There was a problem processing start data in the log file";

				}

				return False;

			}

		}

		if ( fwrite( $this->resource , $this->logLine ) != True ) {
				
			if ( $this->errorType != False ) {
				
				trigger_error( "There was a problem processing data to the log file {$this->logFile}" , E_USER_WARNING );

			}

			if ( $this->errorType != True ) {
				
				$this->logError[ "write" ] = "There was a problem processing data to the log file {$this->logFile}";

			}

			return False;

		}

		if ( $onscreen != False ) echo $this->logLine;

		return True;

	}

	final public function getErrors() : array {

		if ( $this->errorType != True ) {
			
			return ( array ) $this->logError;

		}

		return array();

	}

	final public function __destruct() {

		if ( is_resource( $this->resource ) ) {
			
			fclose( $this->resource );

		}

	}

}

?>