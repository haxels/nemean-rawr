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
  $user_id = 660605355;//$facebook->getUser();
  
  $params = array(
  'scope' => 'read_stream,publish_stream,publish_actions,email,manage_notifications,user_birthday',
  //redirect_uri => $url
  );
  $access_token = $config['appId'].'|'.$config['secret'];
?>
<html>
  <head></head>
  <body>

  <?php
    if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        echo "Name: " . $user_profile['name'] 	.	"<br />";
		echo "Email: ". $user_profile['email']	.	"<br />";
		echo "DOB:	" . $user_profile['birthday'].	"<br />";
		echo "<img src='https://graph.facebook.com/$user_id/picture' /> <br /><br />";
		echo "<a href='http://nemean.no/facebook/facebook-app.php?action=burgernotification'>Send notification</a>";

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl($params); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
	  
/*	$post = $facebook->api('/'. $user_id .'/notifications/', 'post',  array(
		'access_token' => $access_token,
		'href' => 'http://nemean.no/facebook-app.php?', 
		'template' => 'Burger #XXX er ferdig. Hentes i kiosken!',
//		'ref' => 'Notification sent '.$dNow->format("Y-m-d G:i:s") //this is for Facebook's insight
)); */
		


	  if(isset($_GET['action']) == 'burgernotification') {
		$facebook->api('/'. $user_id .'/notifications/', 'post',  array(
		'access_token' => $access_token,
		'href' => 'http://nemean.no/facebook/facebook-app.php?action=opennotification&burgerid=1', 
		'template' => 'Burger #XXX er ferdig. Hentes i kiosken!',
	//	'ref' => 'Notification sent '.$dNow->format("Y-m-d G:i:s") //this is for Facebook's insight
	));
	
		
		
	  }
    } else {
		
      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl($params);
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }

  ?>

  </body>
</html>