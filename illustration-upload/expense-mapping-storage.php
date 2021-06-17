<?php

require_once 'conn.php';
ini_set('display_errors', '1');



if (isset($_POST['id']) && isset($_POST['fileurl'])) {

  // look up the contact in infusionsoft

  $cid = $_POST['id'];

  // error_log("Begin file upload for ".$cid." at ".date("m/d/Y H:i:s", 3, "upload_log.txt");

  // upload the file to the filebox if they are found

  // get the file content from the url

  if ($cid) {

    // $url = explode("/", $_POST['fileurl']);

    // echo "url: <br/>";

    // print_r($url);

    // $count = count($url) - 1;

    // echo "<br/>count: " . $count . "<br/>";

    $jobtitle = "Undetermined";

    $conData = array('JobTitle' => $jobtitle);

    $conID = $app->updateCon($cid, $conData);

    $fileName = "MappingExpensePDF.pdf";
	$fileurl = str_replace(["Download PDF", "(", ")"], "", $_POST["fileurl"]);
	$fileurl = trim($fileurl);

    $file = base64_encode(file_get_contents($_POST['fileurl']));

    echo "file: " . $file;

    $upload = $app->uploadFile($fileName, $file, $cid);

    echo "upload " . $upload;
// log other stuff to the same file
	// error_log("End file upload for ".$emailAddress.PHP_EOL.PHP_EOL, 3, "upload_log.txt"):
  }

}else {
  $cid = $_POST['id'];

  echo "Contact ID is: " .$cid . " ";

  // $url = $$_POST['fileurl'];

  // echo $url . " ";

  // $file = base64_encode(file_get_contents($url));
  // echo $file;

  //error_log("Begin file upload for ".$cid." at ".date("m/d/Y H:i:s", 3, "upload_log.txt");

	echo "An error occurred.";

	// log other stuff to the same file
//error_log("End file upload for ".$cid.PHP_EOL.PHP_EOL, 3, "upload_log.txt"):
}
