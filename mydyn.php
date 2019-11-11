<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 'ON');


/*
 * MYSQL
 */
$mysql_user     = "mydyn";
$mysql_password = "titSSpw4mydyn";
$mysql_database = "ddns";
$mysql_host     = "localhost";
$mysql_table    = "userdomains";

$dyndns_domain  = "mydyn.heinreuter.de";
$dyndns_domain2  = "cloud.heinreuter.de";

$updatescript   = "/dyndns/updateip.sh";
$updatescript2   = "/dyndns/updateip2.sh";

/*
 * INPUT VARIABLES
 */
echo 'bla     -------------------------------------------------';
$domain = null;
$domain2 = "private";
if (array_key_exists("domain",$_REQUEST)) $domain = $_REQUEST["domain"];
else                                      die("nohost");

$ip = "";
if (array_key_exists("ip",$_REQUEST)) $ip = $_REQUEST["ip"];
else                                  $ip = $_SERVER["REMOTE_ADDR"];


echo ">>>>>>>>>>>>>>>" . $ip;


$username = "";
if (array_key_exists("PHP_AUTH_USER",$_SERVER)) $username =
$_SERVER["PHP_AUTH_USER"];
elseif (array_key_exists("username",$_REQUEST)) $username =
$_REQUEST["username"];
else                                            die("badauth");

$password = "";
if (array_key_exists("PHP_AUTH_PW",$_SERVER))   $password =
$_SERVER["PHP_AUTH_PW"];
elseif (array_key_exists("password",$_REQUEST)) $password =
$_REQUEST["password"];
else                                            die("badauth");

if (substr($domain, strlen($domain)-21, 21) == "." . $dyndns_domain) {
  $domain = substr($domain, 0, strlen($domain)-21);
}

/*
 * VALIDATE INPUT VARIABLES
 */
if ($ip != "RESET") {
  $match = preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip);
  if ($match == false or $match == 0) die("ip error");
}

$match = preg_match("/^[a-z.-_]+$/", $domain);
if ($match == false or $match == 0) die("notfqdn");

$match = preg_match("/^[a-z.-_]+$/", $username);
if ($match == false or $match == 0) die("badauth");


//$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password) or die ("911");
//echo $link;
$link = new mysqli($mysql_host,$mysql_user,$mysql_password, $mysql_database) or die("911");

//mysqli_select_db($mysql_database)                               or die ("911");


//$username = mysqli_real_escape_string($username);
//$domain   = mysqli_real_escape_string($domain);
//$password = mysqli_real_escape_string($password);
//$ip       = mysqli_real_escape_string($ip);

$md5hash = md5($password);
echo "[" . $md5hash . "]";

echo "Username=" . $username;

$query = "
  SELECT * FROM ".$mysql_table."
  WHERE username = \"".$username."\"
    AND domain = \"".$domain."\"
    AND password = \"".$md5hash."\"";



echo "==============>" . $query . ">>>>>>>>>>>";
//echo "xxxx";
//print_r($link);



$result = $link->query($query) or die("911");

print_r($result);

//echo "Result=" . $result;

echo "===========";

//$num = mysqli_numrows($result);


$num = $result->num_rows;

echo "===========";

if ($num != 1) die("badauth");

$query = "UPDATE ".$mysql_table." SET lastupdate = NOW(), ip = \"".$ip."\"
WHERE domain = \"".$domain."\" ;";






$query2 = "UPDATE ".$mysql_table." SET lastupdate = NOW(), ip = \"".$ip."\"
WHERE domain = \"".$domain2."\" ;";


echo "QUERY" . $query;
echo "QUERY2" . $query2;

$link->query($query) or die("911");
$link->query($query2) or die("911");

mysqli_close($link);

//exec($updatescript." mysql") or die("911exec");
//exec($updatescript2." mysql") or die("911exec");

echo "start";

exec($updatescript." mysql");
exec($updatescript2." mysql");

echo "good " . $ip . " " . $domain. "." .$dyndns_domain;
?>
