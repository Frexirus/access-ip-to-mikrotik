<form action="/" method="post">
	LOGIN: <input type="text" name="login" />
	PASSWORD: <input type="password" name="password" />
	<input type="submit" value="LOG IN" name="log_in" />
</form>

<?php

/* CONFIGURATION */
$mikrotik_ip = '1.2.3.4';
$mikrotik_user = 'user';
$mikrotik_pass = 'password12345';
$web_user = 'user';
$web_pass = 'password12345';

if($_POST['login'] == $web_user && $_POST['password'] == $web_pass){

	if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP']; 
	}
	
	$ip = $_SERVER['REMOTE_ADDR'];

	require('routeros_api.class.php');

	$API = new RouterosAPI();

	#$API->debug = true; //ONLY FOR DEBUGGING

	if ($API->connect($mikrotik_ip, $mikrotik_user, $mikrotik_pass)) {

		$API->comm("/ip/firewall/address-list/add", array(
			"list"     => "ACCEPT_API",
			"address" => $ip,
			"timeout" => "01:00:00",
		));

		$API->disconnect();

		echo "ACCESS FOR IP: $ip - GRANTED";
	}

}
?>