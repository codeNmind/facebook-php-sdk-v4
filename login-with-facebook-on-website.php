<?php
session_start(); 

// adding all required classes
require __DIR__ . '/autoload.php';

// importing required namespaces
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\Entities\AccessToken;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRedirectLoginHelper;

$facebook = FacebookSession::setDefaultApplication('APP_ID','APP_SECRET');
$helper = new FacebookRedirectLoginHelper('REDIRECT_URI');
try {
	if (isset($_SESSION['access_token'])) {
        // Check if an access token has already been set
        $session = new FacebookSession($_SESSION['access_token']);
    } else {
        // Get access token from the code parameter in the URL
        $session = $helper->getSessionFromRedirect();
    }
	
	} catch (FacebookRequestException $ex) {
		echo $ex->getMessage();
	} catch (\Exception $ex) {
	echo $ex->getMessage();
}

if (isset($session)) {
	try {
		$_SESSION['access_token'] = $session->getToken();
		// get basic info about logged in user
		$request1 = new FacebookRequest($session, 'GET', '/me');
		$response1 = $request1->execute();
		$me = $response1->getGraphObject();
		$name = $me->getProperty('name');
		echo $name;
	} catch(FacebookRequestException $e) {
		echo $e->getMessage();
	}
} else {
	$helper = new FacebookRedirectLoginHelper('http://www.sohaibilyas.com/cyp/');
	$auth_url = $helper->getLoginUrl();
	echo '<a href="'.$auth_url.'">Login with Facebook</a>';
	//echo "<script>window.top.location.href='".$auth_url."'</script>";
}
