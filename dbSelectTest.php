<?php


include "DB_Functions.php";

error_reporting(E_ALL);

ini_set("display_errors", 1);

$DbFunctions = new DB_Functions;

$queryResult = $DbFunctions->exec_qry("SELECT * FROM testpancoat");

//echo $queryResult;


while($row=mysqli_fetch_array($queryResult)){
	
	echo $row["pancoat_id"];
	echo $row["name"]; 
}




?>
