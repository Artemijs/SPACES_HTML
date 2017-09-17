<?php
require_once("property_handler.php");

$ph = new Property_Handler;
echo $ph->get_image($_GET["name"], 1);

?>
