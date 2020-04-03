<?php
   include 'dbutil.php';
   session_start(); //initialize session variables
   if(!isset($_SESSION['user']))$_SESSION['user']=""; //if user is undefined set it to default (blank)
   if($_SESSION["user"]=="")header('Location: login.php'); //if user index is default (blank) redirect to login
   $userid=null;
   $sql="SELECT user_id,username FROM users";
   $result=$conn->query($sql);
   if($result->num_rows>0)
   while($row=$result->fetch_assoc())if($_SESSION["user"]==$row["username"])$userid=$row["user_id"];
   $address="";
   $sql="SELECT address1 FROM users WHERE user_id=".$userid;
   $result=$conn->query($sql);
   if($result->num_rows>0)
   while($row=$result->fetch_assoc())$address=$row["address1"];
   if($_SERVER['REQUEST_METHOD']=='POST'){ //if this is a post call
        $gallons=$_POST["gal"];
        $suggestedprice=0;
	    $totalprice=0;
        $basePrice = 1.50; //baseprice is always constant

	    $historyFactor = 0; //initial
	    $historyCheck;  //determine if the user has history
	    if($historyCheck = 1) //if history, historyFacotry value
		    $historyFactor = 0.01; 

	    $gallonFactor = 0.03;   //initial 
	    $numOfGallons = 100; //retrieve number of gallons on input
	    if($numOfGallons > 1000) //if more than 1k, change gallonFactor
	        $gallonFactor = 0.02; 

	    $getLocation;        //retrieve state from db profile
	    $locationFactor = 0.04; //initial
	    if($getLocation == 'TX') //if tx
		    $locationFactor = 0.02;

	    $month; //get month from request date input
	    $fluc_factor = 0.04; //initial
	    if($month < 6 || $month > 8 ) //if not summer, set fluc .03
		    $fluc_factor = 0.03;


	    $margin = $basePrice *($locationFactor - $historyFactor + $gallonFactor + 0.1 + $fluc_factor); 
	    $price = $basePrice + $margin;  //suggested price per gallon, should output

	    $totalPrice = $price * $numOfGallons; //final amount due, should output

        $sql="INSERT INTO fueldata (user_id,gallons,address,deliverydate,suggestedprice,price)
        VALUES ('".$userid."','".$gallons."','".$address."','".$_POST["deliverydate"]."','".$price."','".$totalPrice."')";
        $conn->query($sql);
        $conn->close();
        header('Location: history.php');
   }
?>
<title>Fuel Quote</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div class="ui-container ui-big">
		<center>
			<form action="history.php" method="post">
				<input required class="ui-textfield" type="number" name="gal" min="1" max="999999999"placeholder="Gallons Requested">
				<p>Deliver to: <?php echo($address);?></p><br>
				<input required class="ui-textfield" type="date" name="deliverydate" placeholder="Address"><br><br>
				<input class="ui-button" type="submit" value="Submit">
			</form>
			<a href="history.php">History</a>
			<a href="logouthandler.php">Logout</a>
		</center>
	</div>
</body>