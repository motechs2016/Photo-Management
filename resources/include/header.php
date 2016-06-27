<!DOCTYPE html>
<?php include '/../dbconfig.php';
session_start();

if(!isset($_SESSION["user_id"])) { header('Location: ../index.php');}
?>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    </head>
    <body>
