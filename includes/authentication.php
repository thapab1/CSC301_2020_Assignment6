<?php
class Authentication 
{
	public $database_file;
	public $banned_file;
	public $userid_field;
	public $signin_URL;
	public $signout_URL;
	public function __construct($database_file, $banned_file, $userid_field, $signin_URL, $signout_URL) {
		$this->database_file = $database_file;
		$this->banned_file = $banned_file;
		$this->userid_field = $userid_field;
		$this->signin_URL = $signin_URL;
		$this->signout_URL = $signout_URL;
	}

	function is_logged(){
		return isset($_SESSION[$this->userid_field]);
	}

	function signout(){
		if(!isset($_SESSION[$this->userid_field])) header('location: index.php');
		session_start();
		$_SESSION=[];
		session_destroy();
		header('location: '.$this->signin_URL);
	}

	function signin(){
		if(count($_POST)>0){ // when user submits form:
			if (empty($_POST["email"])) {
				return "Email is required";
			} else {
				$_POST['email']=htmlspecialchars($_POST['email']); // sanitize email
				// removes space and other predefined characters from both sides of email
				$_POST['email']=trim($_POST['email']);
				// check if email is valid
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					return 'The email you entered is not valid';
				}
				$_POST['email']=strtolower($_POST['email']);
			}
			
			if (empty($_POST["password"])) {
				return "Password is required";
			} else {
				$_POST['password']=htmlspecialchars($_POST['password']); // sanitize password
				// check if password is valid and check if password meets requirements
				// I do not trim password, because in some cases, 
				// users intentionally use space at the beginning or the end of their password
				if(strlen($_POST['password'])<8){
					return 'The password must be at least 8 characters';
				}
			}

			// if the database does not exist, we create it!!
			if(!file_exists($this->database_file)){
				$h=fopen($this->database_file,'w+');
				fwrite($h,'');
				fclose($h);
			}
			
			// check if email is signed up
			$h=fopen($this->database_file,'r');
			while(!feof($h)){
				$line=preg_replace('/\n/','',fgets($h));
				if(strstr($line,$_POST['email'])){
					$line=explode(';',$line);
					if(!password_verify($_POST['password'],$line[1])){
						fclose($h);
						return 'The password you entered does not match the stored password';
					}
					// passwords match!
					// start a session
					$_SESSION[$this->userid_field]=$_POST['email'];
					fclose($h);
					return '';
					
				}
			}
			fclose($h);
			return 'The email you entered is not associated with any user account. Please <a href="signup.php">Sign up</a>';
		}
	}


	function signup(){
		if(count($_POST)>0){ // when user submits form:
			if (empty($_POST["email"])) {
				return "Email is required";
			} else {
				$_POST['email']=htmlspecialchars($_POST['email']); // sanitize email
				// removes space and other predefined characters from both sides of email
				$_POST['email']=trim($_POST['email']);
				// check if email is valid
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
					return 'The email you entered is not valid';
				}
				$_POST['email']=strtolower($_POST['email']);
			}
			
			if (empty($_POST["password"])) {
				return "Password is required";
			} else {
				$_POST['password']=htmlspecialchars($_POST['password']); // sanitize password
				// check if password is valid and check if password meets requirements
				// I do not trim password, because in some cases, 
				// users intentionally use space at the beginning or the end of their password
				if(strlen($_POST['password'])<8){
					return 'The password must be at least 8 characters';
				}
			}

			if (empty($_POST["name"])) {
				return "First name and last name are required";
			} else {
				$_POST['name']=htmlspecialchars($_POST['name']); // sanitize name
				// removes space and other predefined characters from both sides of name
				$_POST['name']=trim($_POST['name']);
				// check if password meets requirements
				if(strlen($_POST['name'])<2){
					return 'The first name and last name must be at least 2 characters';
				}
			}
			// if the database does not exist, we create it!!
			if(!file_exists($this->database_file)){
				$h=fopen($this->database_file,'w+');
				fwrite($h,'');
				fclose($h);
			}
			// check if email is already there
			$h=fopen($this->database_file,'r');
			while(!feof($h)){
				$line=fgets($h);
				if(strstr($line,$_POST['email'])) return 'The email is already registered.';
			}
			fclose($h);

			// if the banned exists
			if(file_exists($this->banned_file)){
				// check if email is in the banned list
				$h=fopen($this->banned_file,'r');
				while(!feof($h)){
					$line=fgets($h);
					if(strstr($line,$_POST['email'])) return 'The email is banned.';
				}
			}
			
			fclose($h);
			
			// encrypt password
			$_POST['password']=password_hash($_POST['password'], PASSWORD_DEFAULT);
			
			//append the data to a file
			$h=fopen($this->database_file,'a+');
			fwrite($h,implode(';',[$_POST['email'],$_POST['password']])."\n");
			fclose($h);
			
			// welcome the user with a warm and cheerful message.
			echo 'You successfully registered your account. Now you can <a href="signin.php">Sign in</a> or Come back to our <a href="../index.php">Home Page</a>';
			
			return '';
		}
	}
}

$auth = new Authentication('../data/database.csv', 'banned.csv', 'user/email', 'signin.php','signout.php');


?>