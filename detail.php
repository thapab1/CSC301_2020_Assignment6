<?php
include('includes/functions.php');

$apartments = jsonToArray('data/data.json');

if(!isset($_GET['id'])){
	echo 'Please visit our <a href="index.php">Home Page</a>.';
	die();
}
if($_GET['id']<0 || $_GET['id']>count($apartments)-1){
	echo 'Something went wrong! Please come back to our <a href="index.php">Home Page</a>.';
	die();
} else {
    $id = $_GET['id'];
}

displayPageHeader("Room Detail");

displayDetail($apartments, $id);

displayPageFooter(); ?>