

<?php

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
	$agentReportId = 25;
	// identify the user who created the Agent Report in Infusionsoft
	$userId = 2373;
	// pull the saved search from Infusionsoft (an array)
	$allAgentReporting = $app->savedSearchAllFields($agentReportId, $userId, 0);

	foreach ($allAgentReporting as $key => $value) {


		// pull values from the saved search (an array)
		$ISid = $value['Id'];
		$firstName = $value['ContactName.firstName'];
		$lastName = $value['ContactName.lastName'];
		$policyAmt = $value['Custom_PolicyAmount'];
		$policyCo = $value['Custom_Company0'];


		$commentsWithSingleQuote = $value['ContactNotes'];
		$commentWithSub = str_replace("'", "_", $commentsWithSingleQuote);
		if ($commentWithSub == "") {
			$comments = "no extra information";			
		} else {
			$comments = $commentWithSub;
		}

		$applicationDateTime = $value['Custom_ApplicationDate1'];
		$appDate = explode("T", $applicationDateTime);
		$applicationDate = $appDate[0];

		$subDateTime = $value['Custom_SubmittedtoInsCoDate'];
		$subDate = explode("T", $subDateTime);
		$submitToInsCo = $subDate[0];

		$examDateTime = $value['Custom_Exam1Date'];
		$examDateTrim = explode("T", $examDateTime);
		$examDate = $examDateTrim[0];


		$insuranceApprovedDateTime = $value['Custom_InsuranceApprovedDate'];
		$insAppDateTrim = explode("T", $insuranceApprovedDateTime);
		$insuranceApprovedDate = $insAppDateTrim[0];


		$issuedDateTime = $value['Custom_IssuedDate'];
		$issuedDateTrim = explode("T", $issuedDateTime);
		$issuedDate = $issuedDateTrim[0];


		$paymentFormSignedDateTime = $value['Custom_PaymentFormSigned1'];
		$pymtDateTrim = explode("T", $paymentFormSignedDateTime);
		$paymentFormSignedDate = $pymtDateTrim[0];

		$inforceDateTime = $value['Custom_InforceDate'];
		$inforceDateTrim = explode("T", $inforceDateTime);
		$inforceDate = $inforceDateTrim[0];

		$mappingDateTime = $value['Custom_EnrolledinMappingDate'];
		$mapDateTrim = explode("T", $mappingDateTime);
		$mappingDate = $mapDateTrim[0];


		$loanRequestApprovedDateTime = $value['Custom_ApprovedLoanRequestDate17'];
		$loanDateTrim = explode("T", $loanRequestApprovedDateTime);
		$loanRequestApprovedDate = $loanDateTrim[0];


		//Commission Owners need to be pulled out of the string and inserted into the table, 
		//Don't need the percentage
		$owner1 = $value['Custom_ComissionOwner12'];
		$explodeOwner1 = explode("|", $owner1);
		$commissionOwner1 = $explodeOwner1[0];

		// echo "one " .$commissionOwner1 . "<br/>";


		$owner2 = $value['Custom_ComissionOwner2'];
		$explodeOwner2 = explode("|", $owner2);
		$commissionOwner2 = $explodeOwner2[0];

		$owner3 = $value['Custom_ComissionOwner3'];
		$explodeOwner3 = explode("|", $owner3);
		$commissionOwner3 = $explodeOwner3[0];

		$owner4 = $value['Custom_ComissionOwner4'];
		$explodeOwner4 = explode("|", $owner4);
		$commissionOwner4 = $explodeOwner4[0];

		$owner5 = $value['Custom_ComissionOwner5'];
		$explodeOwner5 = explode("|", $owner5);
		$commissionOwner5 = $explodeOwner5[0];

		$owner6 = $value['Custom_ComissionOwner6'];
		$explodeOwner6 = explode("|", $owner6);
		$commissionOwner6 = $explodeOwner6[0];

		$owner7 = $value['Custom_ComissionOwner7'];
		$explodeOwner7 = explode("|", $owner7);
		$commissionOwner7 = $explodeOwner7[0];

		$owner8 = $value['Custom_ComissionOwner81'];
		$explodeOwner8 = explode("|", $owner8);
		$commissionOwner8 = $explodeOwner8[0];

		$owner9 = $value['Custom_ComissionOwner9'];
		$explodeOwner9 = explode("|", $owner9);
		$commissionOwner9 = $explodeOwner9[0];

		$owner10 = $value['Custom_ComissionOwner10'];
		$explodeOwner10 = explode("|", $owner10);
		$commissionOwner10 = $explodeOwner10[0];



		// Insert each line into table AgentReport

			$sql = "INSERT INTO AgentReport (Id, FirstName, LastName, PolicyAmt, PolicyCompany, Comments, ApplicationDate, SubmitInsuranceCo, ExamDate, InsuranceApprovedDate, IssuedDate, PaymentFormSignedDate, InforceDate, MappingDate, LoanRequestDate, CommissionOwner1, CommissionOwner2, CommissionOwner3, CommissionOwner4, CommissionOwner5, CommissionOwner6, CommissionOwner7, CommissionOwner8, CommissionOwner9, CommissionOwner10) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if(!($stmt2 = $conn->prepare($sql))) {
				echo "insert fail: " . $conn->errno . " error " . $conn->error;
			}

			if(!$stmt2->bind_param("ississsssssssssssssssssss", $ISid, $firstName, $lastName, $policyAmt, $policyCo, $comments, $applicationDate, $submitToInsCo, $examDate, $insuranceApprovedDate, $issuedDate, $paymentFormSignedDate, $inforceDate, $mappingDate, $loanRequestApprovedDate, $commissionOwner1, $commissionOwner2, $commissionOwner3, $commissionOwner4, $commissionOwner5, $commissionOwner6,$commissionOwner7, $commissionOwner8, $commissionOwner9, $commissionOwner10)) {

				echo "bind params failed (" . $stmt2->errno . " ) " . $stmt2->error;
			}

			$stmt2->execute();

			echo "success new records" . "<br/>";

	}

	$stmt2->close();
	//close the connection
	$conn->close();

?>
