<?php
class DB_Connection{
    
    //variables for connecting to the database
    var $DB_SERVERNAME;
    var $DB_USERNAME;
    var $DB_PASSWORD;
    var $DB_NAME;
    var $m_connection;
    
    function __construct(){
        $this->DB_SERVERNAME= "localhost";
        $this->DB_USERNAME="root";
        $this->DB_PASSWORD = "root";
        $this->DB_NAME="creative_spaces";
    }

    function connect(){
    
        $result = $this->m_connection = new mysqli($this->DB_SERVERNAME, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_NAME);
        if($result->connect_error){
            error_log( "failed to connect".$result->connect_error);
        }else{
            error_log( "connected to "+$this->DB_USERNAME );
        }
    }
    
    function close_connection(){

        $this->m_connection->close();
        error_log( "closing connection ".$this->m_connection->error);
    }
    
    function execute($command){
        $this->connect(); 
        $res = $this->m_connection->query($command);
        if(!$this->m_connection->error){
            error_log($command);        
        }
        else{
            error_log( "|||||||||||||||||||||||||queryy failed ".$this->m_connection->error);
            error_log("||||||||||||||||||||||||||".$command."");
        }
        $this->close_connection();
        return $res;

    }
	function insert($command){
		$this->connect(); 
		$res = $this->m_connection->query($command);
		if(!$this->m_connection->error){
		    error_log($command);        
		}
		else{
		    error_log( "|||||||||||||||||||||||||queryy failed ".$this->m_connection->error);
		    error_log("||||||||||||||||||||||||||".$command."");
		}
		$id = $this->m_connection->insert_id;
		$this->close_connection();
		return $id;
	}
}
?>
