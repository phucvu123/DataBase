<?php include('old/addMedia/connectDB.php') ?>
<?php 
 $conn = connect();
 if($conn->connect_error){
   echo "cant connect";

   exit();
 }
 $type = mysqli_real_escape_string($conn,$_REQUEST["t"]);
      $data = json_decode(stripslashes($_REQUEST['data']),true); 
   $member_id =  (int)mysqli_real_escape_string($conn,$data[0]["value"]);
   $room_num =  (int)mysqli_real_escape_string($conn,$data[1]["value"]);
   $floor =  (int)mysqli_real_escape_string($conn,$data[2]["value"]);
 if($type =="room"){
   //var_dump($data);
 $sqlh = "CALL room_reserve($member_id,$room_num,$floor);";
 $resulth = $conn->query($sqlh)  ;
 if(!$resulth)  echo "Error: " . $sqlh . "<br>". $conn->error;
 else echo "successfully reserved room";
     
 }else{
        echo"something went wrong ";
    
 }
?>