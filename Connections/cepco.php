<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*$hostname_cepco = "localhost";
$database_cepco = "inforgan_SICD15";
$username_cepco = "root";
$password_cepco = "";
$cepco = mysql_pconnect($hostname_cepco, $username_cepco, $password_cepco) or trigger_error(mysql_error(),E_USER_ERROR); 
*/
$hostname_cepco = "localhost";
$database_cepco = "xk000044_tracert";
$username_cepco = "xk000044_tracert";
$password_cepco = "Qwerty123";
$cepco = mysql_connect($hostname_cepco, $username_cepco, $password_cepco) or trigger_error(mysql_error(),E_USER_ERROR); 
?>