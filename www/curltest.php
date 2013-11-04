<?php

// Script to test if the CURL extension is installed on this server

// Define function to test
function _is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

// Ouput text to user based on test
if (_is_curl_installed()) {
  echo "cURL is <span style=\"color:blue\">installed</span> on this server";
} else {
  echo "cURL is NOT <span style=\"color:red\">installed</span> on this server";
}
?>

<?php
phpinfo();
?>
<embed src="http://www.sheepproductions.com/billy/billy.swf?autoplay=false&f0=https://soundcloud.com/boot-up-system/fatman-original-mix-free&t0=Boot Up System - Fatman&total=1" quality="high" wmode="transparent" width="200" height="10" name="billy" align="middle" type="application/x-shockwave-flash" />