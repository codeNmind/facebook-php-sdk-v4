<?php
session_start();

require __DIR__ . '/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRedirectLoginHelper;

$facebook = FacebookSession::setDefaultApplication('APP_ID','APP_SECRET');

$helper = new FacebookCanvasLoginHelper();

try {
	$session = $helper->getSession();
} catch (FacebookRequestException $ex) {
	echo $ex->getMessage();
} catch (\Exception $ex) {
	echo $ex->getMessage();
}

if (isset($session)) {
	try {
		// get basic info about logged in user
		$request1 = new FacebookRequest($session, 'GET', '/me');
		$response1 = $request1->execute();
		$me = $response1->getGraphObject();
		$id = $me->getProperty('name');
		echo $id;
	} catch(FacebookRequestException $e) {
		echo $e->getMessage();
	}
} else {
	$helper = new FacebookRedirectLoginHelper('https://apps.facebook.com/APP_NAMESPACE/');
	$auth_url = $helper->getLoginUrl();
	echo "<script>window.top.location.href='".$auth_url."'</script>";
}
