<?php
require_once('includes/functions.php');
require_once('includes/json.php');

$apartments = jsonToArray('data/data.json');

displayPageHeader('Edit Room Info');

if(count($_POST) > 0){
    Json.modifyJSON('data/data.json',$_POST,$_GET[id]);
    echo "Room is edited successfully. Come back to our <a href='index.php'>Home Page</a>.";
} else {
    if(!isset($_GET['id'])){
        echo 'Please visit our <a href="index.php">Home Page</a>.';
        die();
    }
    if($_GET['id']<0 || $_GET['id']>count($apartments)-1){
        echo 'Something went wrong! Please come back to our <a href="index.php">Home Page</a>.';
        die();
    }
        
    $id = $_GET['id'];
    include('includes/edit_template.php');
}
displayPageFooter(); ?>