<?php
require_once('includes/functions.php');
require_once('includes/json.php');
displayPageHeader('Add Room for Renting');

if(count($_POST) > 0){
    $content = Json.readJSON('data/data.json');
    array_push($content, $_POST); // Add to the front of the array
    Json.writeJSON('data/data.json',$content);
    echo 'Your room is added successfully to our listing. 
    Click <a href="index.php"> here </a> to go back to homepage';
} else {
    include('includes/create_template.php');
}

displayPageFooter(); ?>