<?php
    include 'dbutil.php';
    session_start();
    

    //Pre-Define Variables
    $Price = 1.50;
    $Profit = .1;
    $Address1 = $_SESSION['Address1'];
    $User_id = $_SESSION['user_id'];

    //Get Values From AJAX Call In fuelQuote
    $Gallons = $_REQUEST['Gallons'];
    $Month = $_REQUEST['Month'];

    // Variables We Set And Calculate
    $State = getState($db,$UserName);
    $Transportation = calculateTransportaion($State);
    $Season = calculateSeason($Month);
    $RequestFactor = calculateRequestFactor($Gallons);
    $History = calculateHistory($UserName,$db);
    $suggestedPrice = calculatePrice($Price,$Transportation,$History,$RequestFactor,$Profit,$Season);
    $Total = calculateTotal($suggestedPrice, $Gallons);
    $Values = array($suggestedPrice,$Total);   

    //Return Values Back To fuelQuote
     echo json_encode(array("a" => $suggestedPrice, "b" => $Total));   


     // Calculate What The Transportation Fee is Depending On Our State
     function calculateTransportaion($State)
     {
       if($State == 'TX')
           return 0.02;
       else
           return 0.0;
     }

     function calculateHistory($UserName, $db)
     {
        $sql = "SELECT User_id FROM information ";
        $result = mysqli_query($db,$sql);
    
        // If The User Has History 
        if (mysqli_num_rows($result) == 1)
            return .01;
        return 0.0;
     }

     // Calculate Rate Flucutation Depending On Season
     function calculateSeason($Month)
     {
        $szn = array(0,0.3,0.3,0.4,0.4,0.4,0.4,0.4,0.4,0.3,0.3,0.3,0.3);
        return $szn[$Month];
     }

     // Calculate The Request Factor Depending On Gallons Requested
     function calculateRequestFactor($Gallons)
     {
         if($Gallons > 1000)
            return .02;
         else
            return .03;
     }

     // Get The State The Customer Is From From The DB
     function getState($db,$UserName)
      {
         
         
          $sql = "SELECT * FROM information ";
          $result = mysqli_query($db,$sql);
          $row = mysqli_fetch_assoc($result);
          $value = $row["state"];
          return $value;
      }

     function calculatePrice($Price,$Transportation,$History,$RequestFactor,$Profit,$Season)
     {
         return ($Price + round(($Transportation - $History + $RequestFactor + $Profit + $Season) * $Price));
     }
     
     function calculateTotal($suggestedPrice,$Gallons)
     {
         return $suggestedPrice * $Gallons;
     }


?>