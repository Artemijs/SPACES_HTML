<?php
require_once("property_handler.php");

$ph = new Property_Handler;
$ph->add_new_data($_POST);
/*foreach($_POST as $key => $value){
	echo $key." : ".$value . "  ";
}*/

?>
