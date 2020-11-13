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
	<title>Smart Home-Configuration</title>
	<body>
	
<?php


if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
{

$ipa=$_POST["IpAddress"];
$mask=$_POST["Subnet"];
$dnsa=$_POST["dns"];
$gateway=$_POST["Gateway"];
$reb=$_POST["confitm"];
$ipaa=$_POST["ipao"];
$hnamev=$_POST["hname"];

if($reb=='ok')
{
//header("Refresh: 10; URL=http://$ipaa");
//echo exec("python /var/www/html/reboot.py"); 
//system("(sleep 2 ; sudo /sbin/reboot ) > /dev/null 2>&1 & echo $!"); 
echo exec("python /var/www/html/reboot.py");
}
else
{

echo shell_exec("sh changeip.sh $ipa $gateway $dnsa $mask");
echo shell_exec("sh hnamech.sh $hnamev");
echo '<form action="/configuration.php" method="post"><input type="hidden" name="ipao" value="';
echo $ipa;
echo'"><input type="hidden" name="confitm" value="ok"><div id="rebbtn"><input id="reba" style="display: inline-block;" type="submit" class="btn" value="reboot"></div></form>';
//echo exec("python /var/www/html/reboot.py");
}





}
else
{
$ipa=exec('grep address /etc/network/interfaces | cut -d " " -f2');
$mask=exec('grep netmask /etc/network/interfaces | cut -d " " -f2');
$gateway=exec('grep gateway /etc/network/interfaces | cut -d " " -f2');
$dnsa=exec('grep dns-nameservers /etc/network/interfaces | cut -d " " -f2');


$filehname = fopen("/etc/hostname", "r");
$linehname = fgets($filehname );  
fclose($filehname );




$hnamev= $linehname ;

}
?>	


	
	<div id="menu">


<div class="topnav" id="myTopnav">
  <a href="status.php" >Status</a>
  <a href="configuration.php" class="active" >Configuration</a>
  <a href="administrator.php" >Administrator</a>
  
  <a id="lgo" href="logout.php">logout</a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

		
	</div>
	
	<div class="content">
	


<form action="/configuration.php" method="post">
	

	
  
  <p class="title">HostName Setting: </p>
  
  <div class="subcontent">
  <table>
  <tr class="trf">
	  <td class="tdf">
	  Host Name:
	  </td>
	  <td>
	  <input type="text" placeholder="Host Name" value="<?php echo $hnamev; ?>" name="hname" required>
	  
	  </td>
  </tr>
  
  </table>
  
  
  
  </div>
 
	

	
  
  <p class="title">Network Setting: </p>
  
  <div class="subcontent">
  <table>
  <tr class="trf">
	  <td class="tdf">
	  IP Address:
	  </td>
	  <td>
	  <input type="text" placeholder="192.168.1.10" 
pattern="(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}" 
value="<?php echo $ipa; ?>" name="IpAddress" required>
	  /
	  <input type="text" style="width:120px;" placeholder="255.255.255.0" name="Subnet" value="<?php echo $mask; ?>" required>
	  </td>
  </tr>
  <tr >
	  <td class="tdf">
	  Gateway:
	  </td>
	  <td>
	  <input type="text" placeholder="192.168.1.1"
pattern="(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}" 
 name="Gateway" value="<?php echo $gateway; ?>" required>
	  </td>
  </tr>
 
  <tr >
	  <td class="tdf">
	  DNS:
	  </td>
	  <td>
	  <input type="text" placeholder="8.8.8.8"
pattern="(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}" 
 name="dns" value="<?php echo $dnsa; ?>" required>
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





	</body>



</html>