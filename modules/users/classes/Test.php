<?php
error_reporting(E_ALL);

require_once 'AuthyMapper.php';
echo "hei";
$auth = new AuthyMapper();


var_dump($auth->getByUserID(1));
?>
