<?php
require_once("property_handler.php");
$ph = new Property_Handler;
$ph->get_user_property($_GET["name"]);
?>
