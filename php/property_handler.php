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
			" contact_1 ,".
			" contact_2) VALUES ";

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
			"'".$post["contact_1"]."',".
			"'".$post["contact_2"]."'".
			" ) ";

	
		$command = "".$this->c_add_new_data . $data;
		echo $this->m_connection->insert($command). $post["user"];
			}
	function save_image($post){
		//create table for the property if not exists
		//that will hold thee photo b64 strings
        echo "creating ".$post["name"]."\n";
		$this->m_connection->execute("".
		"CREATE TABLE IF NOT EXISTS ".$post["name"].
		"(id int(32) unsigned auto_increment primary key not null,".
		"data TEXT)");
		//add new photo to db
		$this->m_connection->execute("".
		"INSERT INTO ".$post["name"].
		"(data)".	
		" VALUES('".$post["data"]."')");
	}
    function get_user_property($user){
        return $this->m_connection->execute("SELECT * FROM ".$this->PROPERTY_TABLE." WHERE user = '".$user."'");
    }
}
?>
