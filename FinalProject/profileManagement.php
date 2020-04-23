<?php
   include 'dbutil.php';
   session_start(); //initialize session variables
   if(!isset($_SESSION['user']))$_SESSION['user']=""; //if user is undefined set it to default (blank)
   if($_SESSION["user"]=="")header('Location: login.php'); //if user is default (blank) redirect to login page
   $error=false;
   if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //if this is a post call
       if($_POST['name']==""||strlen($_POST['name'])>50){ //validate name
           $error=true;
           echo("<p class='error'>error: enter your name 0-50 characters</p>");
       }
       if($_POST['address1']==""||strlen($_POST['address1'])>100){ //validate address 1
           $error=true;
           echo("<p class='error'>error: enter your address 0-100 characters</p>");
       }
       if(strlen($_POST['address2'])>100){ //validate address 2
           $error=true;
           echo("<p class='error'>error: enter address 2 0-100 characters</p>");
       }
       if($_POST['city']==""||strlen($_POST['city'])>100){ //validate city
           $error=true;
           echo("<p class='error'>error: enter your city 0-100 characters</p>");
       }
       if($_POST['zipcode']==""||!is_numeric($_POST['zipcode'])||strlen($_POST['zipcode'])>9||strlen($_POST['zipcode'])<5){ //validate zip
           $error=true;
           echo("<p class='error'>error: enter zipcode 5-9 digits</p>");
       }
       if($_POST['state']=="State"){ //validate state
           $error=true;
           echo("<p class='error'>error: select a state</p>");
       }
       if($error==false){
       $userid=null;
       $sql="SELECT user_id,username FROM users";
       $result=$conn->query($sql);
       if($result->num_rows>0)
       while($row=$result->fetch_assoc()){
           if($_SESSION["user"]==$row["username"]){
               $userid=$row["user_id"];
           }
       }
            if($conn->connect_error)die("Connection failed: ".$conn->connect_error);
				//$_SESSION["user"]=$_POST['username']; //set session user index to the new user
				$sql="INSERT INTO information (user_id, first_name, address1, address2, city, state, zip)
				VALUES ('".$userid."', '".$_POST['name']."','".$_POST['address1']."', '".$_POST["address2"]."', '".$_POST["city"]."', '".$_POST["state"]."', '".$_POST["zipcode"]."')";
				$conn->query($sql);
				$conn->close();
				header('Location: index.php'); //redirect to profile management
       }
   }
?>
<title>Profile</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div class="ui-container ui-big">
		<center>
			<form action="profileManagement.php" method="post">
				<input required class="ui-textfield" type="text" name="name" placeholder="Name">
				<input required class="ui-textfield" type="text" name="address1" placeholder="Address 1"><br>
				<input class="ui-textfield" type="text" name="address2" placeholder="Address 2"><br>
				<input required class="ui-textfield" type="text" name="city" placeholder="City"><br>
				<select required class="ui-textfield"name="state">
					<option style="display:none;"selected>State</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District Of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select><br>
				<input required class="ui-textfield" type="number" name="zipcode" placeholder="Zipcode"><br>
				<input class="ui-button" type="submit" value="Submit">
			</form>
		</center>
	</div>
</body>