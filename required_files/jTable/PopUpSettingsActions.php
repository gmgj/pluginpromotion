<?php

try
{
require_once '../../coupon_db_config_inc.php';


$con = mysql_connect($server, $username, $password);
if (!$con) {

    gjerror_log("Connect Error: " .$server. " username: " . $username." db: ".$database);
    echo json_encode($result);
    exit(1);
}
	mysql_select_db($database, $con);


	//Open database connection
//	$con = mysql_connect("localhost","root","");
//	mysql_select_db("test", $con);

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get records from database
		$result = mysql_query("SELECT * FROM popupsetting",$con);
		if (!$result) {
		    gjerror_log ('list Invalid query: ' . mysql_error());
		}

		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
		    $rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		//Insert record into database
		$result = mysql_query("INSERT INTO popupsetting(value, type) VALUES('" . $_POST["value"] . "','" . $_POST["type"] . "');");
		if (!$result) {
		    gjerror_log ('create Invalid query: ' . mysql_error());
		}

		//Get last inserted record (to return to jTable)
		$result = mysql_query("SELECT * FROM popupsetting WHERE id = LAST_INSERT_ID();");
		$row = mysql_fetch_array($result);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = mysql_query("UPDATE popupsetting SET value = '" . $_POST["value"] . "', type = '" . $_POST["type"] . "' WHERE id = " . $_POST["id"] . ";");

		if (!$result) {
		    gjerror_log ('Update Invalid query: ' . mysql_error());
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysql_query("DELETE FROM popupsetting WHERE id = " . $_POST["id"] . ";");
		if (!$result) {
		    gjerror_log ('delete Invalid query: ' . mysql_error());
		}
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	//Close database connection
	mysql_close($con);

}
catch(Exception $ex)
{
    //Return error messtype
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Messtype'] = $ex->getMesstype();
	print json_encode($jTableResult);
}

?>