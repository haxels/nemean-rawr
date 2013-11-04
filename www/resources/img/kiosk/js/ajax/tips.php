<?php

define('INCLUDE_CHECK',1);
require "../connect.php";

if(!$_POST['img']) die("Produktet finnes ikke!");

$img=mysql_real_escape_string(end(explode('/',$_POST['img'])));

$row=mysql_fetch_assoc(mysql_query("SELECT * FROM internet_shop WHERE img='".$img."'"));

if(!$row) die("Produktet finnes ikke!");

echo '<strong>'.$row['name'].'</strong>

<p class="descr">'.$row['description'].'</p>

<strong>Pris: '.$row['price'].' Kr</strong>
<small>Dra det ned i bestillingen for å kjøpe </small>';
?>
