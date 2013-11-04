<?php

// Moduleurl
$mUrl = $_GET['m'];

?>
<ul>
    <li><a href="?m=<?php echo $mUrl; ?>&act=add">New</a></li>
    <li><a href="?m=<?php echo $mUrl; ?>">List</a></li>
    <li><a href="?m=<?php echo $mUrl; ?>&act=settings">Settings</a></li>
</ul>