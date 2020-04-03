<?php
   include 'dbutil.php';
   session_start(); //initialize session variables
   if(!isset($_SESSION['user']))$_SESSION['user']=""; //if user is undefined set it to default (blank)
   if($_SESSION["user"]!="")header('Location: index.php'); //if user is logged in redirect to calculator
   if($_SERVER['REQUEST_METHOD']=='POST'){ //if this is a post call
       $error=false;
       if($_POST['username']==""){ //check if they entered a username
           $error=true;
           echo("<p class='error'>error: enter a username</p>");
       }
       if($_POST['password']==""){ //check if they entered a password
           $error=true;
           echo("<p class='error'>error: enter a password</p>");
       }
       if($conn->connect_error)die("Connection failed: ".$conn->connect_error);
       $sql="SELECT username FROM users";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       while($row=$result->fetch_assoc()){
           if($_POST['username']==$row["username"]){ //check if they entered a username already taken
               $error=true;
               echo("<p class='error'>error: that username is taken</p>");
           }
       }
       if($error==false){ //if valid register input
            $_SESSION["user"]=$_POST['username']; //set session user index to the new user
            $sql="INSERT INTO users (password, username)
            VALUES ('".$_POST['password']."','".$_POST['username']."')";
            $conn->query($sql);
            $conn->close();
            header('Location: profileManagement.php'); //redirect to profile management
       }
   }
?>

<title>Register</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div class="ui-container ui-small">
		<center>
			<form action="register.php" method="post">
				<input required class="ui-textfield" type="text" name="username" placeholder="Username"><br>
				<input required class="ui-textfield" type="password" name="password" placeholder="Password"><br>
				<input class="ui-button" type="submit" value="Register">
			</form>
			<a href="login.php">Login</a>
		</center>
	</div>
</body>