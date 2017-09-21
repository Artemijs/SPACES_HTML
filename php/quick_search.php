<?php
require_once("db_connector.php");
//geet * from db where type and size
$db = new DB_Connection;
$res = $db->execute("select id, address from property where type = '".
        $_GET["type"]."' and size = ".$_GET["size"]);
$array = array();
$s_addr = strtolower($_GET["address"]);
while($row = $res->fetch_assoc()){
    $addr = $row["address"];
    $addr = strtolower($addr);
    if(strpos($addr, $s_addr) !==false){
        //the search string is found inside address
        array_push($array, $row["id"]);
    } 
}

//now that you havee all the ids of eentries that havvee the string in address, query for it and send it backi
/*function getJSON($query_res){
    $array = array();
    while($row = $query_res->fetch_object()){
        array_push($array, $row);
    }
    //every code example ive seen closes the result, idk why but idc enough to question it
    return json_encode($array);

}*/
function get_data($id){
    $dbconn = new DB_Connection;
    $r = $dbconn->execute("select id, user, address, type from property where id = ".$id);
    return $r->fetch_object();
    
}
$found_data = array();
foreach($array as $id){
    array_push($found_data, get_data($id));
    
}
echo json_encode($found_data);

?>

