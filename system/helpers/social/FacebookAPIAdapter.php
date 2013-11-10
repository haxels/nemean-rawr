<?php
/**
 * Created by PhpStorm.
 * User: rkalland
 * Date: 11/9/13
 * Time: 7:28 PM
 */

class FacebookAPIAdapter implements ISocial {

    private $fb;
    private $access_token;

    public function __construct(Facebook $fb, $accessToken, $appID, $appSecret)
    {
        $this->fb = $fb;
        $this->access_token = $accessToken;
    }

    public function get($url)
    {
        // TODO: Implement get() method.
    }

    public function sendNotification($userID, $url, $msg) {
        $config = ['access_token' => $this->access_token];
    }
}


if(isset($_GET['action']) == 'burgernotification') {
    $facebook->api('/'. $user_id .'/notifications/', 'post',  array(
            'access_token' => $access_token,
            'href' => 'http://nemean.no/facebook/facebook-app.php?action=opennotification&burgerid=1',
            'template' => 'Burger #XXX er ferdig. Hentes i kiosken!'));
	//	'ref' => 'Notification sent '.$dNow->format("Y-m-d G:i:s") //this is for Facebook's insight
}