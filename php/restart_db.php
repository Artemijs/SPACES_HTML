<?php
require_once("db_connector.php");
/*dont forget to delete the photos*/
$connection = new DB_Connection;
$connection->execute("drop database ".$connection->DB_NAME);
require_once("setup_db.php");

?>
