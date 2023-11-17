<?php
include ("classes/conn.php");
$DB = new Database;
$requestid = $_POST['requestid']; 
$accepted = $_POST['accepted'];
if($accepted == 1){
    $query = "update requests set accepted = '1' where requestid = '$requestid'";
    $DB->save($query);
}
?>