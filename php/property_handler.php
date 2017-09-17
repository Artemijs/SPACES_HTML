<?php
/*
	this file manages the property table, retrieving and storing new propertiees in 
	mysql and creating/deleting photos
*/
require_once("db_connector.php");
require_once("image_handler.php");
class Property_Handler{
	
	var $m_connection;	
	var $PROPERTY_TABLE;
	var $c_add_new_data;
	function __construct(){
		$this->m_connection = new DB_Connection;
		$this->PROPERTY_TABLE = "property";	
		$this->c_add_new_data="INSERT INTO ".
			$this->PROPERTY_TABLE.
			" ( user ,".
			" address ,".
			" type ,".
			" size ,".
			" availability ,".
			" rent_period ,".
			" situation ,".
			" a_electricity ,".
			" a_wifi ,".
			" a_bathrooms ,".
			" a_24_7_access ,".
			" a_heating ,".
			" a_furniture ,".
			" a_sound_iso ,".
			" a_pub_transport ,".
			" a_parking ,".
			" details ,".
			" contact_name ,".
			" contact_email ,".
			" contact_number) VALUES ";

	}
	function add_new_data($post){
		$data ="(". 
			"'".$post["user"]."',".
			"'".$post["address"]."',".
			"'".$post["type"]."',".
			$post["size"].",".
			"'".$post["availability"]."',".
			"'".$post["rent_period"]."',".
			"'".$post["situation"]."',".
			$post["a_electricity"].",".
			$post["a_wifi"].",".
			$post["a_bathrooms"].",".
			$post["a_24_7_access"].",".
			$post["a_heating"].",".
			$post["a_furniture"].",".
			$post["a_sound_iso"].",".
			$post["a_pub_transport"].",".
			$post["a_parking"].",".
			"'".$post["details"]."',".
			"'".$post["contact_name"]."',".
			"'".$post["contact_email"]."',".
			"'".$post["contact_number"]."'".
			" ) ";

	
		$command = "".$this->c_add_new_data . $data;
		echo $this->m_connection->insert($command). $post["user"];
			}
    function get_image($tname, $id){
        $result = $this->m_connection->execute("SELECT * FROM ".$tname." WHERE id = ".$id);
        $array = array();
        while($row = $result->fetch_object()){
            array_push($array, $row);
        }
        //every code example ive seen closes the result, idk why but idc enough to question it
        $result->close();
        array_push($array, array("name"=>$tname));
        return json_encode($array);

    }
	function save_image($post){
		//create table for the property if not exists
		//that will hold thee photo b64 strings
        echo "creating ".$post["name"]."\n";
		$this->m_connection->execute("".
		"CREATE TABLE IF NOT EXISTS ".$post["name"].
		"(id int(32) unsigned auto_increment primary key not null,".
		"data MEDIUMTEXT)");
		//add new photo to db
		$this->m_connection->execute("".
		"INSERT INTO ".$post["name"].
		"(data)".	
		" VALUES('".$post["data"]."')");
	}
    function get_user_property($user){
        $result = $this->m_connection->execute("SELECT * FROM ".$this->PROPERTY_TABLE." WHERE user = '".$user."'");
        $array = array();
        while($row = $result->fetch_object()){
            array_push($array, $row);
        }
        //every code example ive seen closes the result, idk why but idc enough to question it
        $result->close();
        return json_encode($array);
    }
}
?>
