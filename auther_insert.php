<php include_once('include/functions.php')?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('include/connect.php');
    $name = validate_input($_POST['name']);
}