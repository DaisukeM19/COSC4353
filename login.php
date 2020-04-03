<?php
   include 'dbutil.php';
   session_start(); //initialize session variables
   if(!isset($_SESSION['user']))$_SESSION['user']=""; //if user is undefined set it to default (blank)
   if($_SESSION["user"]!="")header('Location: index.php'); //if already logged in redirect to calculator
   if($_SERVER['REQUEST_METHOD']=='POST'){ //check if this is a post call
       if($conn->connect_error)die("Connection failed: ".$conn->connect_error);
       $sql="SELECT username,password FROM users";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       while($row=$result->fetch_assoc()){
           if($_POST['username']==$row["username"]){
               if($_POST['password']==$row["password"]){
                    $_SESSION["user"]=$_POST['username']; //set the session user index to the username
                    header('Location: index.php'); //redirect to calculator
               }
           }
       }
       echo("<p class='error'>Invalid login</p>"); //otherwise show error message
   }
?>
<title>Login</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div class="ui-container ui-small">
		<center>
			<form action="login.php" method="post">
				<input required class="ui-textfield" type="text" name="username" placeholder="Username"><br>
				<input required class="ui-textfield" type="password" name="password" placeholder="Password"><br>
				<input class="ui-button" type="submit" value="Login">
			</form>
			<a href="register.php">Register</a>
			
		</center>
	</div>
</body>