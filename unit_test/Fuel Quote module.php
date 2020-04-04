<?php
   include 'dbutil.php';
   session_start(); //initialize session variables
   if(!isset($_SESSION['user']))$_SESSION['user']=""; //if user is undefined set it to default (blank)
   if($_SESSION["user"]=="")header('Location: login.php'); //if user index is default (blank) redirect to login
?>
<title>History</title>
<link rel="stylesheet"type="text/css"href="style.css">
<body>
	<div class="ui-container ui-big">
		<center>
			<table class="ui-table">
			  <tr>
				<th>Gallons Requested</th>
				<th>Delivery Address</th> 
				<th>Delivery Date</th>
				<th>Suggest Price</th>
				<th>Total Amount Due</th>
			  </tr>
			      <?php
    			       $userid=null;
                       $sql="SELECT user_id,username FROM users";
                       $result=$conn->query($sql);
                       if($result->num_rows>0)
                       while($row=$result->fetch_assoc()){
                           if($_SESSION["user"]==$row["username"]){
                               $userid=$row["user_id"];
                           }
                       }
                       $sql="SELECT user_id,gallons,address,deliverydate,suggestedprice,price FROM fueldata";
                       $result=$conn->query($sql);
                       if($result->num_rows>0)
                       while($row=$result->fetch_assoc()){
                           if($userid==$row["user_id"]){
			            echo("<tr>");
			            echo("<td>".$row["gallons"]."</td>"); //display gallons requested
			            echo("<td>".$row["address"]."</td>"); //display user address (when db is implemented)
			            echo("<td>".$row["deliverydate"]."</td>"); //display delivery date
			            echo("<td>$".$row["suggestedprice"]."</td>"); //display suggested price
			            echo("<td>$".$row["price"]."</td>"); //display total amount due
                        echo("</tr>");
                           }
                       }
                       $conn->close();
			      
			      ?>
   
			
			</table>
			<a href="index.php">Calculator</a>
			<a href="logouthandler.php">Logout</a>
		</center>
	</div>
</body>