<?php

	include('auth_class.php');

	$domain = trim($_POST['domain']);
	$uname = trim($_POST['uname']);

	$auth = new Auth($domain,$uname);
	$result = $auth->authInfo();

	echo $result;