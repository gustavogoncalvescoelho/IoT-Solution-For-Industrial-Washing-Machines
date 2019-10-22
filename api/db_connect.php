<?php
class DB_CONNECT {
    
    // Constructor
    function __construct(){
        // Trying to connect to the database
        $this->connect();
    }
    
    // Destructor
    function __destruct(){
        // Closing the connection to the database
        $this->close();
    }
    
    // Function to connect to the database
    function connect(){
        
        // Importing dbconfig.php file which contains database credentials
        $filepath = realpath (dirname(__FILE__));
        
        require_once($filepath."/dbconfig.php");
        
        // Connecting to mysql (phpmyadmin) database
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
        
        // Selecting database
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());
        
        // Returning connection cursor
        return $con;
    }
    
    // Function to close the database
    function close(){
        // Closing database connection
        mysql_close();
    }
    
}
?>