<?php

include("../connect/connect.php");

$sql = "SELECT * FROM product p , count c where p.ID_Count=c.ID_Count AND p.ID_Product = '".$_GET["id"]."'";

$query = mysql_query($sql);
while ($objResult = mysql_fetch_array($query)) 
{
    echo ($objResult[9]);
}

