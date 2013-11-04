<?
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once 'fb-sdk/facebook.php';
//include 'plugins/fb-sdk/facebook_functions.php';

 $config = array();
 $config['appId'] = '182876171902264';
 $config['secret'] = '18b22670c3f903670fb2a4d518726fe4';

  $facebook = new Facebook($config);
  $user_id = 660605355; //$facebook->getUser();
  
  
  $access_token = $config['appId'].'|'.$config['secret'];

echo "<a href='http://nemean.no/facebook/ntest.php?action=burgernotification'>Send notification</a>";


if(isset($_GET['action']) == 'burgernotification') {
		$facebook->api('/'. $user_id .'/notifications/', 'post',  array(
		'access_token' => $access_token,
		'href' => 'http://nemean.no/facebook/facebook-app.php?action=opennotification&burgerid=1', 
		'template' => 'Burger #XXX er ferdig. Hentes i kiosken!',
	//	'ref' => 'Notification sent '.$dNow->format("Y-m-d G:i:s") //this is for Facebook's insight
	));
}
	
 ?>
