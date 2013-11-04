<style>
td{
border: 0px;
border-collapse: collapse;
}

table{

border-collapse: collapse;
border: solid 1px #e8e8e8;
width: 647px;
}

tr:nth-child(odd) {
  background-color: #e8e8e8;
  border: 0px;
}

tr:nth-child(even) {
  background-color: #fff;
  border: 0px;

}
</style>

<?php

$host="server.nemean.no"; // Host name 
$username="zebra"; // Mysql username 
$password="nemean12toft"; // Mysql password 
$db_name="nemean_kiosk"; // Database name 
$tbl_name="products"; // Table name 



// Connect to server and select database.
 mysql_connect("$host", "$username", "$password")or die("cannot connect server "); 
mysql_select_db("$db_name")or die("cannot select DB");

$sql="SELECT * FROM $tbl_name";
 $result=mysql_query($sql);

echo "<center><img src='img/header.png'><br />";
echo " <table border='1'> ";
while($rows=mysql_fetch_array($result)){
 
 echo "
 <tr>
 <td><b>". $rows['productName'] . "</b></td>
 <td style='text-align: right; padding-right: 10px; height: 30px;'>". $rows['sellPrice'] . ",-</td>
 </tr>";
 
 }
 echo "</table></center>";
?>
