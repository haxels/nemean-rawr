<?php
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
 if (mail("havardax@hotmail.com", "The Gathering", "Ska vi farra på TG?", "from: Peder Vollan")) {
     echo "Jaaaaa";
 }
 else {
     echo "neeeeei";
 }

echo "Hei på deg!";
?>