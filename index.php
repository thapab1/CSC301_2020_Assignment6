<?php
session_start();
include('includes/functions.php');
include('includes/authentication.php');

$apartments = jsonToArray('data/data.json');

displayPageHeader('RoomsForRent');
?>

<div class="row">
    <div class="col-md-8">
        <a class="btn btn-primary btn-lg" href="src/signin.php" role="button">Sign In</a>
        <a class="btn btn-primary btn-lg" href="src/signup.php" role="button">Sign Up</a>
        <?php
            if($auth->is_logged())
                echo '<a class="btn btn-primary btn-lg" href="src/signout.php" role="button">Sign Out</a>';
        ?>
    </div>
    <div class="col-md-4">
        <!-- Button to add a room for renting -->
        <a class="btn btn-primary btn-lg" href="create.php" role="button">Add Your Room For Renting</a>
    </div>
</div>
<br><br>

<!-- Show list of rooms available -->
<h3>Rooms Available Now:</h3>
<ul class="list-group">
    
    <?php
    $count = count($apartments);
    for($i=0; $i<$count; ++$i){
        displayList($apartments, $i);
    }
    ?>            
</ul>

<?php displayPageFooter(); ?>
