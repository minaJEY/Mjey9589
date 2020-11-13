<?php
session_start();


$usrn= exec('grep usr /var/www/html/.secret | cut -d "=" -f2');

if( $_SESSION['login_user'] <> "un=$usrn")
{
	header("Location: login.php");
}
?>


<html>
<head>
	<meta name="theme-color" content="#09990F" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
	<title>Smart Home-Administrator</title>
	<body>
			


	
	<div id="menu">


<div class="topnav" id="myTopnav" style="z-index:100;">
  <a href="status.php"  >Status</a>
  <a href="configuration.php">Configuration</a>
  <a href="administrator.php" class="active">Administrator</a>
  
  <a id="lgo" href="logout.php">logout</a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

		
	</div>
<?php


if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{

	$oldpass=$_POST["oldpass"];
	$newpass=$_POST["newpass"];
	$confirm=$_POST["confirm"];
	$reb=$_POST["confitmhid"];
	
	if($reb=='ok')
	{
		$newpassave=$_POST["new_p"];

		echo shell_exec("sh passch.sh $newpassave");
		header("Location: logout.php");

$f_pp = fopen(".secret", "w") ;
$vinmerg = "usr=admin".PHP_EOL."passwd=".$newpassave;
fwrite($f_pp, $vinmerg);
fclose($f_pp);

		
	}
	else
	{
		$saveedpss= exec('grep passwd /var/www/html/.secret | cut -d "=" -f2');
		
		$password3=md5($oldpass);
		if($password3==$saveedpss)
		{
			if($newpass==$confirm)
			{
			
			$password2=md5($newpass);
			echo "do you want ghange administrator password?";
			echo '<form action="administrator.php" method="post"><input type="hidden" name="new_p" value="';
			echo $password2;
			echo '"/><input type="hidden" name="confitmhid" value="ok"/><div id="rebbtn"><input id="reba" style="display: inline-block;" type="submit" class="btn" value="Yes"><a id="reba" href="status.php" style="padding:0px;background-color:green; display: inline-block;" class="btn">No</a></div></form>';

			}
			else
			{
			echo "Password does not match the confirm password.";
			}
		}
		else
		{
			echo "faild old password";
		}


	}





}
else
{
	//$ipa= exec('grep ip_address /etc/dhcpcd.conf | cut -d "=" -f2 | cut -d "/" -f1');
	//$mask=exec('grep ip_address /etc/dhcpcd.conf | cut -d "=" -f2 | cut -d "/" -f2');
	//$gateway=exec('grep routers /etc/dhcpcd.conf | cut -d "=" -f2');
	//$dnsa=exec('grep domain_name_servers /etc/dhcpcd.conf | cut -d "=" -f2');
	//$hnamev= exec('grep 127.0.1.1 /etc/hosts | cut -d "	" -f2');




?>





	
	<div class="content">
	


<form action="/administrator.php" method="post">
	


  
  <p class="title">Admin Setting: </p>
  
  <div class="subcontent">
  <table>
  <tr class="trf">
	  <td class="tdf">
	  Old Password:
	  </td>
	  <td>

	  <input type="password"  value="" name="oldpass" value="<?php echo $oldpass ?>" required>
	  
	  </td>
  </tr>
  <tr >
	  <td class="tdf">
	  New Password:
	  </td>
	  <td>
	  <input type="password"  name="newpass" value="" required>
	  </td>
  </tr>
 
  <tr >
	  <td class="tdf">
	  Confirm:
	  </td>
	  <td>
	  <input type="password" name="confirm" value="" required>
	  </td>
  </tr>
  </table>
  
  
  
  </div>
  <br><br>
  <input type="submit" class="btn" value="Save">
</form> 
		
	</div>
	


<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>


<?php

}
?>


	</body>



</html>