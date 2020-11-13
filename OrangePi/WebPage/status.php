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
 <style>
    

      #g2,#gb2, #gc2,#gd2,#ge2,#gf2,#gg2,#gh2,#gi2 {
        width:180px; height:140px;
        display: inline-block;
        margin: -20px 10px 25px;
	border-bottom: solid 1px black;
      }

     

    </style>

	<link rel="stylesheet" type="text/css" href="css.css">
	<meta http-equiv="refresh" content="10" >
	<title>Smart Home</title>
	<link rel="stylesheet" type="text/css" href="Style.css">
		<link rel="stylesheet" type="text/css" href="css.css">
<script src="java.js"></script>
<script src="justgage.js"></script>
<script src="raphael-2.1.4.min.js"></script>
	</head>
	<body>
<?php 



function get_server_memory_usage(){

    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;

    return $memory_usage;
}
function get_server_cpu_usage(){

    $load = sys_getloadavg();
    return $load[0];

}
 

##read value from file
$array = explode("\n", file_get_contents('/usr/local/bin/Vin'));
$array2 = explode("\n", file_get_contents('/usr/local/bin/Vout'));
$array3 = explode("\n", file_get_contents('/usr/local/bin/current'));
$array4 = explode("\n", file_get_contents('/usr/local/bin/temperature'));
$array5 = explode("\n", file_get_contents('/usr/local/bin/Battery'));
$array6 = explode("\n", file_get_contents('/usr/local/bin/humidityot'));
$array7 = explode("\n", file_get_contents('/usr/local/bin/temperatureot'));
$array8 = get_server_cpu_usage();
$array9 = get_server_memory_usage();
$array10 = explode("\n", file_get_contents('/usr/local/bin/gas'));
$hnamev= exec('grep 127.0.1.1 /etc/hosts | cut -d "	" -f2');

$vin=$array[0];
$vout=$array2[0];
$current=$array3[0];
$temperature=$array4[0];
$Battery=$array5[0];
$humidityot=$array6[0];
$temperatureot=$array7[0];
$gas=$array10[0];
$cpuu=$array8;
$memory=$array9;
if ($cpuu==0)
{
 $cpuu=1;
}
if($Battery>100)
{
$Battery==100;
}
?>
	
		
	
	<div id="menu">



<div class="topnav" id="myTopnav">
  <a href="status.php" class="active" >Status</a>
  <a href="configuration.php">Configuration</a>
  <a href="administrator.php" >Administrator</a>
 
  <a id="lgo" href="logout.php">logout</a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>


		
	</div>
	
	<div class="content">
	

<center>


<form  name="formName">


<ul class="box" id="ulbox">

<li>

<input type="hidden" name="p1" value="<?php echo $current; ?>"/>
<input type="hidden" name="p2"  value="<?php echo $Battery; ?>"/>
<input type="hidden" name="p3" value="<?php echo $vin; ?>"/>
<input type="hidden" name="p4"  value="<?php echo $vout; ?>"/>
<input type="hidden" name="p5" value="<?php echo $temperature; ?>"/>
<input type="hidden" name="p6" value="<?php echo $humidityot; ?>"/>
<input type="hidden" name="p7" value="<?php echo $temperatureot; ?>"/>
<input type="hidden" name="p8" value="<?php echo $cpuu; ?>"/>
<input type="hidden" name="p9" value="<?php echo $memory; ?>"/>
<div class="box-center">
<div>

<span><?php echo $hnamev ?> bedroom</span>

<hr/>
</div>
</br>

<?php
$arrayq = file('/usr/local/bin/motion');
//$selfrun = file('/usr/local/bin/selfrun');
$aaq= substr($arrayq[0],0,2) ;

if("No"== $aaq)
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: red;border-radius: 5px;color:#fff;text-align: center">No Movement Detected</div>';
}
else
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: green;border-radius: 5px;color:#fff;text-align: center">Movement Detected</div>';
}
?> 	
</br>

<h3>Turn On The Lamp:</h3>
<form method="post">

    <input type="submit" value="GO" name="GO">
   </form>
 </body>
</html>

<?php
	if(isset($_POST['GO']))
	{
		shell_exec("python /var/www/html/ledon.py");
		echo"success";
	}
?>

</div>

</li>


     
</ul>

<ul class="box" id="ulbox">

<li>

<div class="box-center">

<div>
	<span>living room</span>
	<hr/>
</div>


<div class="borna"> 
<div class="fl" >Humidity:
	<div id="gf2" class="gauge" ></div>
</div>

<div class="fl" >Temperature:
	<div id="gg2" class="gauge" ></div>
</div>

<div class="fl" >CPU Usage:
	<div id="gh2" class="gauge" ></div>
</div>

<div class="fl" >RAM Usage:
	<div id="gi2" class="gauge" ></div>
</div>

</div>

<?php
$arrayr = file('/usr/local/bin/fan');
$aar= substr($arrayr[0],0,3) ;

if("off"== $aar)
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: red;border-radius: 5px;color:#fff;text-align: center">Fan OFF</div>';
}
else
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: green;border-radius: 5px;color:#fff;text-align: center">Fan ON</div>';
}	

?>
</br>

<?php
$arrays = file('/usr/local/bin/door');
$aas= substr($arrays[0],0,1) ;

if("c"== $aas)
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: red;border-radius: 5px;color:#fff;text-align: center">Door Close</div>';
}
else
{
echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: green;border-radius: 5px;color:#fff;text-align: center">Door Open</div>';
}
?> 	
</br>



<div class="Text-val" >
</div>

</div>

</li>

</ul>

<ul class="box" id="ulbox">

<li>

<div class="box-center">

<div>
	<span>kitchen</span>
	<hr/>
</div>


<div class="borna"> 
</br>
<h3>GAS Sensor Output:</h3>
<div><input type="text" name="gas" value=<?php echo $gas;?>></br></div>
</br>



</div>




<div class="Text-val" >
</div>

</div>

</li>

</ul>



</form>
</center>
<?php
	//echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: #efbc0a;border-radius: 5px;color:#fff;text-align: center;">UPS input voltage warning</div><br/>';
	//echo '<div style="height:40px;padding-top: 10px;font-size: 20px;font-weight: bold;background-color: red;border-radius: 5px;color:#fff;text-align: center;">! UPS Load warning !</div>';




?>
	
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
