<?php
include ("classes/conn.php");
function create_requestid()
{
    $length = rand(8,8);
    $number = "";
    for ($i=0; $i < $length; $i++)
    {
        $new_rand = rand(0,9);
        $number = $number . $new_rand;
    }
    return $number;
}
$DB = new Database;
$userid = $_POST['userid']; 
$teacher = $_POST['teacherid']; 
$requestid = create_requestid();
$query = "insert into requests (userid,teacherid,requestid,accepted) values ('$userid','$teacher','$requestid','0')";
$DB->save($query);
?>