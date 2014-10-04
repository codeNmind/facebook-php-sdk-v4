<?php
session_start();
require_once( 'Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'Facebook/HttpClients/FacebookCurl.php' );
require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php' );
require_once( 'Facebook/Entities/AccessToken.php' );
require_once( 'Facebook/Entities/SignedRequest.php');
require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookSignedRequestFromInputHelper.php');
require_once( 'Facebook/FacebookCanvasLoginHelper.php');
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookOtherException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );
require_once( 'Facebook/GraphUser.php');
require_once( 'Facebook/GraphSessionInfo.php' );

use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;
use Facebook\FacebookSession;
use Facebook\FacebookSignedRequestFromInputHelper;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;

$facebook = FacebookSession::setDefaultApplication('APP-ID','APP-SECRET-KEY');
$helper = new FacebookCanvasLoginHelper();

try {
	$session = $helper->getSession();
} catch (FacebookRequestException $ex) {
	echo $ex->getMessage();
} catch (\Exception $ex) {
	echo $ex->getMessage();
}

if ($session) {
	try {
		// uploading image to user timeline using facebook php sdk v4
		$response = (new FacebookRequest(
			$session, 'POST', '/me/photos', array(
				'source' => new CURLFile('picture.jpg', 'image/jpg'), // photo must be uploaded on your web hosting
				'message' => 'User provided message'
				)
			)
		)->execute()->getGraphObject();
		if($response) {
			echo "Photo is uploaded...";
		}
		
	} catch(FacebookRequestException $e) {
		echo $e->getMessage();
	}
} else {
	$helper = new FacebookRedirectLoginHelper('https://apps.facebook.com/APP_NAMESPACE/');
	$auth_url = $helper->getLoginUrl(array('email', 'publish_actions'));
	echo "<script>window.top.location.href='".$auth_url."'</script>";
}
