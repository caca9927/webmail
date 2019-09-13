<?php 
 if(isset($_GET['vkey'])){
     $vkey = $_GET['vkey'];

     $mysqli = NEW MySQLi('localhost','root','','test');

     $resultSet = $mysqli->query("SELECT verified,vkey FROM accounts WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");

     if($resultSet->num_rows == 1){
        $update = $mysqli->query("UPDATE ACCOUNTS SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        
        if($update){
            $name = $mysqli->query("SELECT username FROM accounts WHERE vkey = '$vkey'");
            $result = $name->fetch_assoc();
            echo "<p style='text-align:center;font-size:40px;font-weight:bold;'>"."Congratualations! ".$result['username'].", Your account has been verified.";
        }else{
            echo $mysqli->error;
        }
    
    }else{
        $name = $mysqli->query("SELECT username FROM accounts WHERE vkey = '$vkey'");
        $result = $name->fetch_assoc();
         echo "<p style='color:red;text-align:center;font-size:40px;font-weight:bold;'>". $result['username'].", account is invalid or already verified!";
    }
 
    }else{
     die("Something went wrong");
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Style.css">
    <title>Verification</title>
</head>
<body>
<br>
<img src="image/03.png" style="width:250px;height:250px;" alt="">
</body>
</html>