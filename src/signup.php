<?php
session_start();
require_once('../includes/functions.php');
require_once('../includes/authentication.php');
if($auth->is_logged('user/email')) header('location: ../index.php');

if(count($_POST)>0){ // when user submits form:
	$error=$auth->signup();
  if(isset($error{0})) echo $error;
} else {

  displayPageHeader("Create a new account");
    
  echo '<h1>Create a new account</h1>
  <form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post">
    <div class="form-group">
      <label>First and last name</label>
      <input type="text" class="form-control" name="name" required minlength="2" >
    </div>
    <div class="form-group">
      <label>Email address</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" name="password" required minlength="8" >
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>';

  displayPageFooter(); 
}
?>