<?php   
   header('Content-Type: text/html; charset=utf-8');
   $obBaseApp = new COM("hMailServer.Application", NULL, CP_UTF8);
   $obBaseApp->Connect();
      
   $obAccount = $obBaseApp->Authenticate("Administrator", "123456");
   
    if (!isset($obAccount)) {
		  echo "<b>Not authenticated or Administrator's password wrong</b>";
    } else {
		
	if(isset($_POST['submit'])){
        try {
           
           $obDomain = $obBaseApp->Domains->ItemByDBID(1); // domain id //error
          
           
             $domainname = $obDomain->Name;
               
              $obAccounts = $obDomain->Accounts();		  
              $obAccount = $obDomain->Accounts->Add();
                
              $obAccount->Address =  "{$_POST['email']}@" . $obDomain->Name;
              $obAccount->Password = "{$_POST['password']}";
              $obAccount->Active = 1;
                              
              $obAccount->MaxSize = 102;
              $obAccount->Save(); // save, finish.
       
            /* If we reaching this point, everything works as expected */
            echo "<script>
                if(confirm('Signup Success')){
                    location.replace('index.php');
                }else{
                    location.replace('index.php');
                }
            </script>";
       
       } 
       /* OK, if something went wrong, give us the exact error details */	
       catch(Exception $e) {
           echo "<h4>COM-ERROR: <br />".$e->getMessage()."</h4><br />";		
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
    <title>Document</title>
</head>
<body>

    <form method="post">
        <input type="text" name="email" placeholder="Enter Email"> @itmail.com <br>
        <input type="password" name="password" placeholder="Enter Password"> <br>
        already have an account? <a href="index.php">Click here</a><br>
        <input type="submit" name="submit" value="Signup">
    </form>
</body>
</html>