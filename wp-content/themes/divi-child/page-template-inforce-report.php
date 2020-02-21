<?php 

/*
Template Name: New Inforce Monthly Report
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
		font-size: 13px;
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

	table tr:nth-child(even) {
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
	if (isset($_GET['monthly'])) {
		$pagenum = $_GET['monthly'];
	} else {
		$pagenum = get_queried_object_id(); 
	}

	// monthly = 9314

if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

<?php 



//if the form is being filled out and submitted, run the 'if' statement
//if the form has not been submitted yet, run the 'else' statement
if (isset($_POST['monthlypw'])) {

	process_form_inforce_report();

} else {

	echo '<div class="form-wrapper">
		<h3>Fill in your password below.</h3>
		<form method="POST" id="pwform">
			<input name="monthlypw" type="password">
			<input type="hidden" name="pagenum" value="' . $pagenum . '">
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
		function process_form_inforce_report() {
			$num = $_POST['pagenum'];
			$monthlypw = $_POST['monthlypw'];

		     if ($num == "9314" && $monthlypw == 'NIPMR1230'){
		     	create_inforce_report();
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


		
		function create_inforce_report() {
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
		
			echo '<h2>Inforce Policies - Monthly Report</h2>';
			//button to print table
			echo '<p style="margin: 15px 0 5px;"><input style="padding: 10px; font-size: 16px; font-weight: bold;color: #ffffff; background-color: #64bc46;border: 1px solid #64bc46;cursor:pointer;" type="button" value="Print Report" id="btPrint" onclick="createPrintTable()" /></p>';
	    	echo '<p style="font-size:12px;">*For best results, change your layout to landscape when saving as a PDF or printing the report.</p>';
			//creates the column headers
			echo '<p class="scroll">scroll &nbsp; &rarr;</p>
				<div class="table-wrapper" id="print-table">
					<table>
						<thead>
							<tr>
								<th><div style="width: 55px; white-space: normal;">ID</div></th>
								<th><div style="width: 150px; white-space: normal;">Insured Name</div></th>
								<th><div style="width: 65px; white-space: normal;">Policy Amount</div></th>
								<th><div style="width: 85px; white-space: normal;">Inforce Date</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 1 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 2 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 3 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 4 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 5 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 6 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 7 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 8 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 9 - Percentage</div></th>
								<th><div class="commission" style="width: 150px; white-space: normal;">Commission Owner 10 - Percentage</div></th>
							</tr>
						</thead>
						<tbody class="real">
			';	

		
			$sql = 'SELECT * FROM NewInforceMonthlyReport';

			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$inforceReportInfo = $stmt->get_result();				

			//creates the rows in the report from the data in the table
			if ($inforceReportInfo->num_rows > 0) {
			    // output data of each row			    
			    while($row = $inforceReportInfo->fetch_assoc()) {

					//creating rows
			    	$include_row = '

			    		<tr>
							<td><div style="width: 55px; white-space: normal;">' . $row['Id'] . '</div></td>
							<td><div style="width: 150px; white-space: normal;">' . $row['InsuredFirstName'] . ' ' . $row['InsuredLastName'] . '</div></td>
							<td><div style="width: 65px; white-space: normal;">$' . $row['PolicyAmt'] .'</div></td>
							<td><div style="width: 85px; white-space: normal;">' . formatDate($row['InforceDate']) . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner1'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner2'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner3'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner4'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner5'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner6'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner7'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner8'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner9'] . '</div></td>
							<td><div class="commission" style="width: 150px; white-space: normal;">' . $row['CommissionOwner10'] . '</div></td>
						</tr>
					';

					echo $include_row;

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

		        style = style + "table {font-family: 'Lato', sans-serif;border-collapse: collapse; font-size: 14px;";
		        style = style + "color: #000000;display: inline-block;margin-bottom: 50px;min-width: 100%;table-layout: fixed;}";
		        style = style + "table thead {display: block;border-collapse: collapse;}";
		        style = style + "table thead > tr {display: block;border-collapse: collapse;padding: 0 !important;}";
		        style = style + "tbody {display: block;width:100%;}";
		        style = style + "table th, table td {border: 1px solid #000000;white-space: normal;padding: 10px 4px;}";
		        style = style + "table tr th {background-color: #cccccc;}";
		        style = style + "table tr:nth-child(odd) {background-color: #cccccc;}";
		        style = style + "table thead tr th div.commission {width: 100px !important;}";
		        style = style + "table tbody tr td div.commission {width: 100px !important;}";		        
		        style = style + "</style>";

		        // CREATE A WINDOW OBJECT.
		        var win = window.open('', '', 'height=700,width=1300');

		        win.document.write('<html><head>');
		        win.document.write('<title>Inforce Report</title>');   // <title> FOR PDF HEADER.
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