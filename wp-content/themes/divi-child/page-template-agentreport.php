<?php 

/*
Template Name: Agent Reporting
*/

get_header();
?>
<style>
	body {
		width: 100%;
		margin: 0 auto;
		background-color: #ffffff !important;
		color: #000000;
	}

	div#et-main-area {
		width: 90%;
		margin: 20px auto;
	}

	#main .container {
		width: 100%;
	}

	h2 {
		margin: 20px 0;
		font-style: bold;
	}

	input[type="password"] {
		width: 350px;
		padding: 10px 5px !important;
		vertical-align: middle;
		margin-right: 10px;
	}

	input[type="submit"] {
		width: 200px;
		border: 1px solid #64bc46;
		padding: 7px 5px;
		margin: 10px 0;
		color: #fff;
		background: #64bc46;
		font-weight: bold;
		font-size: 16px;
		cursor: pointer;
		vertical-align: middle;
	}

	input[type="button"] {
		cursor: pointer;
	}

	.scroll {
		text-align: right;
	}

	.table-wrapper {
		white-space: nowrap;
		overflow-x: auto;
	}

	table {
		font-family: 'Lato', sans-serif;
		border-collapse: collapse;
		color: #000000;
		display: inline-block;
		margin-bottom: 50px;
		min-width: 100%;
		table-layout: fixed;
	}

	/*ADD TO THE TABLE SCROLL */

	
	table thead {
		display: block;
		border-collapse: collapse;
	}

	table thead > tr {
		display: block;
		border-collapse: collapse;
		padding: 0 !important;
	}

	tbody {
		display: block;
		max-height:450px;
		width:100%;
		overflow-x: hidden;
	}

	table th,
	table td {
		border: 1px solid #000000;
		white-space: normal;
	}

	table tr th {
		background-color: #cccccc;
	}

	table tr:nth-child(odd) {
		background-color: #cccccc;
	}

</style>


<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1); 

?>

<div id="main">


<?php 
	global $post;
	$page = $post->ID;
	$is_page_builder_used = et_pb_is_pagebuilder_used( $page );

	//if the agent is in url, pull that number; otherwise, get the page id of the wordpress page
	if (isset($_GET['agent'])) {
		$agentnum = $_GET['agent'];
	} else {
		$agentnum = get_queried_object_id(); 
	}

if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

<?php 



//if the form is being filled out and submitted, run the 'if' statement
//if the form has not been submitted yet, run the 'else' statement
if (isset($_POST['agentpw'])) {

	process_form();

} else {

	echo '<div class="form-wrapper">
		<h3>Fill in your password below.</h3>
		<form method="POST" id="pwform">
			<input name="agentpw" type="password">
			<input type="hidden" name="agentnum" value="' . $agentnum . '">
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>';
}

?>


</div>


<script type="text/javascript">
	//remove the password form once the form has been submitted
	jQuery(document).ready(function() {
		jQuery("#pwform").on("submit", function() {
			jQuery("div.form-wrapper").css("display", "none");
		});
	});
</script>

<?php 
		//this function processes the form, checking that the page id and the password for that page matches
		// if it does not match, redirect to a different page. on that page, a button will take you back to the previous page
		// to retry the password
		function process_form() {
			$num = $_POST['agentnum'];
			$agentpw = $_POST['agentpw'];

		     if (($num == "9019" && $agentpw == 'TMMBKesler') || ($num == "9027" && $agentpw == 'TMMCNaugle') || ($num == "9029" && $agentpw == 'TMMJNelson') || ($num == "9031" && $agentpw == 'TMMJZieg') || ($num == "9131" && $agentpw == 'TMMTKesler') || ($num == "9275" && $agentpw == 'TMMMAndrews') || ($num == "9276" && $agentpw == 'TMMMRobarge')){
		     	create_report();
		     } else {
		     	$url = "https://themoneymultiplier.com/password-denied/";
		     	header('Location: '. $url);
		     }
		}

		//for reports
		function formatDate( $date ) {
			if ($date != "") {
				$trimDate = trim($date);
				$yr = substr($trimDate, 0, 4);
				$m = substr($trimDate, 4, 2);
				$day = substr($trimDate, 6, 2);

				$updateDate = $m . "/" . $day . "/" . $yr;
				return $updateDate;
			} else {
				return "";
			}
			

		}

		//creates the report on the page for that particular agent, once the password is submitted correctly
		function create_report() {

			global $post;
			$page = $post->ID;
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

			//creates heading for the page
			switch ($page) {
				case 9019:
					echo '<h2>Brent Kesler - Agent Report</h2>';
					break;
				
				case 9027:
					echo '<h2>Chris Naugle - Agent Report</h2>';
					break;

				case 9029:
					echo '<h2>Josh Nelson - Agent Report</h2>';
					break;

				case 9031:
					echo '<h2>Josh Zieglowski - Agent Report</h2>';
					break;
				
				case 9275:
					echo '<h2>Monica Andrews - Agent Report</h2>';
					break;
				
				case 9276:
					echo '<h2>Marian Robarge - Agent Report</h2>';
					break;

				default:
					echo '<h2>Terri Kesler - All Agent Reporting</h2>';
					break;
			}

	    	echo '<p style="margin: 15px 0 5px;"><input style="padding: 10px; font-size: 16px; font-weight: bold;color: #ffffff; background-color: #64bc46;border: 1px solid #64bc46;" type="button" value="Print Report" id="btPrint" onclick="createPrintTable()" /></p>';
	    	echo '<p style="font-size:12px;">*For best results, change your layout to landscape when saving as a PDF or printing the report.</p>';

								// <th><div style="width: 55px; white-space: normal;">Row</div></th>			
			//creates the column headers
			echo '<p class="scroll">scroll &nbsp; &rarr;</p>
				<div class="table-wrapper" id="print-table">
					<table>
						<thead>
							<tr>
							    <th><div style="width: 35px; white-space: normal;">Row</div></th>	
								<th><div style="width: 55px; white-space: normal;">ID</div></th>
								<th><div style="width: 120px; white-space: normal;">Name</div></th>
								<th><div style="width: 115px; white-space: normal;">Policy Company</div></th>
								<th><div style="width: 100px; white-space: normal;">Policy Amount</div></th>
								<th><div style="width: 380px; white-space: normal;">Comments</div></th>
								<th><div style="width: 85px; white-space: normal;">Application Date</div></th>
								<th><div style="width: 85px; white-space: normal;">Submit to Insurance Company</div></th>
								<th><div style="width: 85px; white-space: normal;">Exam Date</div></th>
								<th><div style="width: 85px; white-space: normal;">Insurance Approved Date</div></th>
								<th><div style="width: 85px; white-space: normal;">Issued Date</div></th>
								<th><div style="width: 85px; white-space: normal;">Payment Form Signed Date</div></th>
								<th><div style="width: 85px; white-space: normal;">Inforce Date</div></th>
							</tr>
						</thead>
						<tbody class="real">
			';

			//pulls the data from the AgentReport table in the database
			if(is_page(9019) || is_page(9027) || is_page(9029) || is_page(9031) || is_page(9275) || is_page(9276)) {
				$sql = 'SELECT * FROM AgentReport ORDER BY PolicyAmt DESC';
			} elseif (is_page(9131)) {
				$sql = 'SELECT * FROM AgentReport ORDER BY ApplicationDate ASC';
			} else {
				$sql = 'SELECT * FROM AgentReport';
			}



			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$tableInfo = $stmt->get_result();

			//creates the rows in the report from the data in the table
			if ($tableInfo->num_rows > 0) {
			    // output data of each row	
			    $rowNum = 1;		    
			    while($row = $tableInfo->fetch_assoc()) {

			    	//determining whether inforce date field is empty or filled; leave off the report if it is filled
			    	if ($row['InforceDate'] == '') {
			    		
			    		$inforce = true;
			    	} else {
			    		// $inforce = true;
			    		$inforce = false;
			    	}

			    	//creating rows
			    	$include_row = '

			        	<tr>
				            <td><div style="width: 35px; white-space: normal;">' . $rowNum .'</div></td>	
			        		<td><div style="width: 55px; white-space: normal;">' . $row['Id'] .'</div></td>
			        		<td><div style="width: 120px; white-space: normal;">' . $row['FirstName'] . ' '. $row['LastName'] . '</div></td>
			        		<td><div style="width: 115px; white-space: normal;">' . $row['PolicyCompany'] .'</div></td>
			        		<td><div style="width: 100px; white-space: normal;">$' . $row['PolicyAmt'] .'</div></td>
			        		<td><div style="width: 380px; white-space: normal;">' . $row['Comments'] .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['ApplicationDate']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['SubmitInsuranceCo']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['ExamDate']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['InsuranceApprovedDate']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['IssuedDate']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['PaymentFormSignedDate']) .'</div></td>
			        		<td><div style="width: 85px; white-space: normal;">' . formatDate($row['InforceDate']) .'</div></td>
		        		</tr>
			        ';


			        //put trims around each value in the array
			        $commissionArr = array(trim($row['CommissionOwner1']), trim($row['CommissionOwner2']), trim($row['CommissionOwner3']), trim($row['CommissionOwner4']), trim($row['CommissionOwner5']), trim($row['CommissionOwner6']), trim($row['CommissionOwner7']), trim($row['CommissionOwner8']), trim($row['CommissionOwner9']), trim($row['CommissionOwner10'])); 

			        //checks to see if agents' names are in the array
			        $bk = in_array('Brent Kesler', $commissionArr);
			        $ck = in_array('Chris Naugle', $commissionArr);
			        $jn = in_array('Josh Nelson', $commissionArr);
			        $jn2 = in_array('Joshua Nelson', $commissionArr);
			        $jz = in_array('Josh Zieglowski', $commissionArr);
			        $jz2 = in_array('Joshua Zieglowski', $commissionArr);
			        $ma = in_array('Monica Andrews', $commissionArr);
			        $mr = in_array('Marian Robarge', $commissionArr);

			        //Brent Kesler - page 9019
			        //Chris Naugle - page 9027
			        //Josh Nelson - page 9029
			        //Josh Zieglowski - page 9031
			        //Terri Kesler - page 9131
			        //Monica Andrews - page 9275
			        //Marian Robarge - page 9276

			        // put if statement there so if it's more than one person's name
			        if ($inforce == true) {

						if (is_page(9019) && ($bk == true)) {
				        	echo $include_row;
					        $rowNum++;  
				        } elseif (is_page(9027) && ($ck == true)) {
							echo $include_row;
					        $rowNum++;  

				        } elseif (is_page(9275) && ($ma == true)) {
							echo $include_row;
					        $rowNum++;  
				        } elseif (is_page(9276) && ($mr == true)) {
							echo $include_row;
					        $rowNum++;  
				        } elseif ((is_page(9029) && ($jn == true)) || (is_page(9029) && ($jn2 == true))) {
				        	echo $include_row;
					        $rowNum++;  
				        } elseif ((is_page(9031) && ($jz == true)) || (is_page(9031) && ($jz2 == true))) {
				        	echo $include_row;
					        $rowNum++;  
				        } elseif (is_page(9131)) {
				        	echo $include_row;
					        $rowNum++;  
				        } else {
				        	continue;
				    
				        }
				    }
			      // $rowNum++;  
			       
			    }


			} else {
			    echo "0 results";
			}
			//close the connection
			$conn->close();
		}
		?>

		<script type="text/javascript">
			
			function createPrintTable() {

				var today = new Date();
				var month;

				switch(today.getMonth()) {
					case 0:
						month = 'January';
						break;
					case 1:
						month = 'February';
						break;						
					case 2:
						month = 'March';
						break;
					case 3:
						month = 'April';
						break;
					case 4:
						month = 'May';
						break;
					case 5:
						month = 'June';
						break;
					case 6:
						month = 'July';
						break;
					case 7:
						month = 'August';
						break;		
					case 8:
						month = 'September';
						break;
					case 9:
						month = 'October';
						break;					
					case 10:
						month = 'November';
						break;		
					case 11:
						month = 'December';
						break;													
					}

				var date =  month + " " + today.getDate() + ', ' + today.getFullYear();

				var sTable = document.getElementById('print-table').innerHTML;

		        var style = "<style>";
		        // style = style + "table {width: 100%;font: 17px Calibri;}";
		        // style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
		        // style = style + "padding: 2px 3px;text-align: center;}";

		        style = style + "table {font-family: 'Lato', sans-serif;border-collapse: collapse;";
		        style = style + "color: #000000;display: inline-block;margin-bottom: 50px;min-width: 100%;table-layout: fixed;}";
		        style = style + "table thead {display: block;border-collapse: collapse;}";
		        style = style + "table thead > tr {display: block;border-collapse: collapse;padding: 0 !important;}";
		        style = style + "tbody {display: block;width:100%;}";
		        style = style + "table th, table td {border: 1px solid #000000;white-space: normal;}";
		        style = style + "table tr th {background-color: #cccccc;}";
		        style = style + "table tr:nth-child(odd) {background-color: #cccccc;}";
		        style = style + "</style>";

		        // CREATE A WINDOW OBJECT.
		        var win = window.open('', '', 'height=700,width=1300');

		        win.document.write('<html><head>');
		        win.document.write('<title>Agent Report</title>');   // <title> FOR PDF HEADER.
		        win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
		        win.document.write('</head>');
		        win.document.write('<body>');
		        win.document.write("<p style='font-weight: bold; font-family: sans-serif; font-size: 15px;'>" + date + "</p>");
		        win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
		        win.document.write('</body></html>');
		        win.document.close();
		        win.print();
			}		
		</script>




			</tbody>
		</table>
	</div>	<!-- .table-wrapper -->

<?php if ( ! $is_page_builder_used ) : ?>

		</div> <!-- #left-area -->

		<!-- <?php //get_sidebar(); ?> -->
	</div> <!-- #content-area -->
</div> <!-- .container -->

<?php endif; ?>
</div>

<?php



?>


<?php
get_footer();
