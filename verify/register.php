<?php 
    $error = NULL;

    if(isset($_POST['submit'])){
        $u = $_POST['u'];
        $p = $_POST['p'];
        $p2 = $_POST['p2'];
        $e = $_POST['e'];


        if(strlen($u) < 5){
            $error = "<p>your username must be at least 5 characters</p>";
        }else if($p2 != $p){
            $error = "<]>your password do not match</p>";
        }else{
            $mysqli = NEW MySQLi('localhost','root','','test');
        
            $u = $mysqli->real_escape_string($u);
            $p = $mysqli->real_escape_string($p);
            $p2 = $mysqli->real_escape_string($p2);
            $e = $mysqli->real_escape_string($e);

            $vkey = md5(time() .$u);

            $p = md5($p);
            $insert = $mysqli->query("INSERT INTO accounts(username,password,email,vkey) VALUES ('$u','$p','$e','$vkey')");

            if($insert){
                $to =$e;
                $subject = "Email Verification";
                $message = "Thank you $u for registering at Web Duck, to verify your email "."<a href='http://127.0.0.1/squirrel-webmail/verify/verify.php?vkey=$vkey'>Click Here</a>";
                $headers = "From: admin@itmail.com \r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset-utf-8" . "\r\n";
            
                mail($to,$subject,$message,$headers);
                header('location:thankyou.php');
            
            }else{
                echo $mysqli->error;

            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style.css">
    <title>Web Duck</title>
</head>
<body>
    <form action="" method="POST">
        <table border="0" align="center" cellpadding="5">
            <tr>
                <td align="right">Username: </td>
                <td><input type="text" name="u" required/></td>
            </tr>
            <tr>
                <td align="right">Password: </td>
                <td><input type="password" name="p" required/></td>
            </tr>
            <tr>
                <td align="right">Repeat Password: </td>
                <td><input type="password" name="p2" required/></td>
            </tr>
            <tr>
                <td align="right">Email Address: </td>
                <td><input type="email" name="e" required/></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="submit" value="Register" required/></td>
            </tr>
        </table>
    </form>
    <center>
    <?php 
    echo $error;
    ?>
    </center>
</body>
</html>