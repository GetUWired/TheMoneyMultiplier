

<?php
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'conn.php';

//$app was set in conn.php

	$servername = "localhost";
	$username = "tmmwpu2";
	$password = "DrffeA5s6q&fYu1s";
	$database = "admin_tmmwp2";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	echo "Connected successfully" . "<br/>";

	// because we are pulling a fresh report each time, we need to delete all of the rows from the table initially
	$deleteRows = "DELETE FROM AgentReport";
	// prepare
	$stmt = $conn->prepare($deleteRows);
	$stmt->execute();
	$stmt->close();

	// identify the id of the Agent Report in Infusionsoft
	// $agentReportId = 25;
	 //$agentReportId = 23;
	$agentReportId = 123;
	// echo $agentReportId;
	// identify the user who created the Agent Report in Infusionsoft
	$userId = 1;
	// pull the saved search from Infusionsoft (an array)
// echo $userId;
$page = 0;
$allResults = [];

$allAgentReporting = $app->savedSearchAllFields($agentReportId, $userId, $page);
	
$returnFields = ["ContactNotes"];
$index = 0;
foreach($allAgentReporting as $contact){
	if($index >= 100 && $index <= 500){
		
		echo "<pre>";
		var_dump($contact);
		$con = $app->loadCon($contact["Id"], $returnFields);
		var_dump($con);
		echo "</pre>";
	}
	$index++;
}


