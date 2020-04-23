<?php
   include 'dbutil.php';
    session_start();
    // define variables and set to empty values
    global $Gallons,$Date,$Price,$Total,$Discount,$Transportation,$Competitor,$Minimum;

    //Pre-Define Variables
    $Address1 = $_SESSION['Address1'];
    $UserName = $_SESSION['username'];

    // Define Values After User Submits Form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Variables With User Input
        $Gallons = test_input($_POST["Gallons"]);
        //$Address1 = test_input($_POST["Delivery"]);
        $Date = test_input($_POST["DeliveryDate"]);
        $SuggestedPrice = test_input($_POST["SuggestedPrice"]);
        $Total = test_input($_POST["Total"]);

        postQuote($UserName,$Gallons,$Address1,$Date,$SuggestedPrice,$Total,$db);
      }
      
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      // Method To Insert The Fuel Quote Form With All The Attributes To The DB
      function postQuote($UserName,$Gallons,$Address1,$Date,$SuggestedPrice,$Total,$db)
      {
          $query = "INSERT INTO information (username, gallons,address,date,price,total) 
                      VALUES('$UserName', '$Gallons','$Address1','$Date','$SuggestedPrice','$Total')";
            mysqli_query($db, $query);
            
            mysqli_close($db);
            //header('location: fuelHistory.php');
      }

?> 
<title>Fuel Quote</title>
<link rel="stylesheet"type="text/css"href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<body>
	<div class="ui-container ui-big">
	<form method = "post" id="Quote" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<center>
			<form action="history.php" method="post">
				<input required class="ui-textfield" type="text" id="Gallons" name="Gallons" min="1" max="999999999"placeholder="Gallons Requested">
				<p>Deliver to: <?php echo($Address1);?></p><br>
				<input required class="ui-textfield" type="date"  id = "date" name="DeliveryDate" ><br><br>
				<input required class="ui-textfield" type="text"  id="SPrice" name="SuggestedPrice" readonly required placeholder="SuggestedPrice">
			  <input required class="ui-textfield" type="text"  id="TPrice" name="Total" required readonly placeholder="Total">
				</center>
				<center>
				<button  class ="ui-button" type="button" id="Price" class="registerbtn">Get Price</button> 
				<input class="ui-button" type="submit" value="Submit">
				</center>
			</form>
			<center>
			<a href="history.php">History</a>
			<a href="logouthandler.php">Logout</a>
			</center>
	</div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
          $("#Price").click(function(e){
            var Gal = $(Gallons).val();
            var Date = $(date).val();
            if(Gal !== '' && Date !== '')
            {
              var Month = Date.substring(5,7);
              if(Month.charAt(0) == '0')
              {
                Month = Month.substring(1);
              }
              $.ajax({
                  url: "PricingModule.php",
                  type: "post",
                  dataType: 'json',
                  data: {Gallons : Gal,
                         Month : Month },
                  success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                      $("#SPrice").val(response.a);
                      $("#TPrice").val(response.b);
                      console.log("Done!");
                  },
                  error: function()
                  {
                    console.log("Failed");
                  }

              });
            }    
          });
    });  

</script> 