<?php

session_start();

if(isset ($_SESSION['alnajat_userid']))
{
    $_SESSION['alnajat_userid'] = NULL;
    $_COOKIE['alnajat_userid'] = NULL;
    unset($_SESSION['alnajat_userid']);
    unset($_COOKIE['alnajat_userid']);
    setcookie('alnajat_userid', '', -1, '/');
}


header("Location: index.php");
die;