<?php
require_once("db_connector.php");
//i need this to keep all the database credentials in one place
$db_handle = new DB_Connection;
//cant usee DB_Connection beecause it automatically tries to connect to a database
//so i use mysqli directly
$result = $connection = new mysqli($db_handle->DB_SERVERNAME, $db_handle->DB_USERNAME, $db_handle->DB_PASSWORD);
if($result->connect_error){
    error_log( "failed to connect in seetup db".$result->connect_error);
}
//check if db exists, create it if not
if( $connection->select_db($db_handle->DB_NAME) === false){
	echo "database does not exist, creating neew <br>";
	$connection->query("create database ".$db_handle->DB_NAME);
	$connection->select_db($db_handle->DB_NAME);
}
///create table property(id int(32) unsigned auto_increment primary key not null, user varchar(75), address varchar(150), type varchar(30), size int(32), availability varchar(25), rent_period varchar(30), situation varchar(200), a_electricity boolean not null default 0,)

//create the property table
$connection->query("CREATE TABLE IF NOT EXISTS property (".
"id int(32) unsigned auto_increment primary key not null,".
	" user varchar(75),".
	" address varchar(150),".
	" type varchar(30),".
	" size int(32),".
	" availability varchar(25),".
	" rent_period varchar(30),".
	" situation varchar(200),".
	" a_electricity boolean not null default 0,".
	" a_wifi boolean not null default 0,".
	" a_bathrooms boolean not null default 0,".
	" a_24_7_access boolean not null default 0,".
	" a_heating boolean not null default 0,".
	" a_furniture boolean not null default 0,".
	" a_sound_iso boolean not null default 0,".
	" a_pub_transport boolean not null default 0,".
	" a_parking boolean not null default 0,".
	" details varchar(250),".
	" contact_1 varchar(20),".
	" contact_2 varchar(50)".
	")"); 
if(!$connection->error){
    echo "created property table";
}
else{
    error_log( "=========== queryy failed ".$connection->error);
    error_log("".$command."");
}


?>
