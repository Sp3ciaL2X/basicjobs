<h2>BasicJobs</h2>

  * <b>Autoloader</b>
  * <b>Language System<b/>
  * <b>Logging System<b/>
  * <b>Registry System<b/>
  
  Basic Jobs repository contains specified script files
  
  <h3>- Autoloader</h3>
    Treats namespace as a file directory and automatically loads class files  on the page
    
    * If you want to use the namespace you created, replace the specified line with your own values
    
      74: $namespace = "Scripts".DIRECTORY_SEPARATOR;
   ----------------------------------------------------------------------------------------------------------------------  
  <h3>- Language System</h3>
    Used to add multiple language files to your script and dynamically modify its content
    
    *'setLanguageType' is currently only available in two values: php and json , will include language
    files in you script according to the value specified here
    
      Ex: language->setLanguageFolder( "languages" )->setLanguage( "english" )->setLanguageType( "php" )->check();
      
      Ex: language->load( "index" );
      
      Directory : languages/english/index_lang.php
      
      *When running in php type,remember to create the '$language' variable when specifying lines in the 
      language file
      
      index_lang.php in -> $language[ "index" ][ "welcome" ] = "Welcome Back <USERNAME>"; like this.
      
   ----------------------------------------------------------------------------------------------------------------------
      
  <h3>- Logging System</h3>
    Useful for keeping lines that are created within the script or created by you in a '.log' file
    
      *Automatically creates the file you specify and stores the specified lines in that file
      *İt is up to you whether to print this line on the screen
      
      Ex: logging->setLogFolder( "logging" )->setErrorType( False )->checkLogSystem( True );
      
      setLogFolder = Folder to store log files
      
      setErrorType = If value is "False" errors in the script are stored as an array "getErrors()" is used to 
                     access these errors,if the value is "True", it will trigger an error with a trigger_error
                     
      checkLogSystem = If "True" is specified, the log system is active, otherwise it is disabled
      
      * Creating a line in the log system is simple
      
      
     Ex: logging->write( filename:"script" , error:WARNING , line:"This is error" , onscreen:"True" );
     
     
     filename = ".log" file name to create a previously created or new one
     
     error    = ERROR - NOTICE - WARNING - INFO - PHPERROR one of the constants
     
     line     = Error line
     
     onscreen = If "True" is specified, the line is displayed on the screen
     
   ----------------------------------------------------------------------------------------------------------------------
     
  <h3>- Registry System</h3>
    Works in the logic of library,stores a variable, a class, or anything in a 'registry' object and these 
    values are accessible from anywhere
    
    Ex: $registry = Scripts\Registrt\Registry::return(); /* 'return' is static function */
    
    Ex: $registry->logging = new Scripts\Libraries\Logging\Logging;
    
    Ex: $registry->logging->write( "test" , ERROR , "test line" , false );
        
        
        
    $registry->setProperty( $property , $value ); /* Create new property for registry class */
    
    $registry->removeProperty( $property ); /* Remove from registry class in property */
    
    $registry->getAllProperties();/* Show all properties in registry class */
    
    $registry->registered( $property ); /* Checks the existence of the specified property, 'True' if property exists
                                            otherwise it returns 'false'*/
