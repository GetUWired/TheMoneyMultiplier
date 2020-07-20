<?php

require_once 'conn.php';


if (isset($_POST['id']) && isset($_POST['fileurl'])) {

  // look up the contact in infusionsoft

  $cid = $_POST['id'];

  // upload the file to the filebox if they are found

  // get the file content from the url

  if ($cid) {

    // $url = explode("/", $_POST['fileurl']);

    // echo "url: <br/>";

    // print_r($url);

    // $count = count($url) - 1;

    // echo "<br/>count: " . $count . "<br/>";

    $jobtitle = "Developer";

    $conData = array('JobTitle' => $jobtitle);

    $conID = $app->updateCon($cid, $conData);

    $fileName = "Mapping Expense PDF.pdf";

    $file = base64_encode(file_get_contents($_POST['fileurl']));

    echo "file: " . $file;

    $upload = $app->uploadFile($fileName, $file, $cid);

  }

}else {
	echo "stuff isn't set right";
}
