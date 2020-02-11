<?php

require_once 'conn.php';

if (isset($_POST['id']) && isset($_POST['fileurl'])) {

  // look up the contact in infusionsoft

  $cid = $_POST['id'];

  // upload the file to the filebox if they are found

  // get the file content from the url

  if ($cid) {

    $url = explode("/", $_POST['fileurl']);

    $count = count($url) - 1;

    $fileName = $url[$count];

    $file = base64_encode(file_get_contents($_POST['fileurl']));

    $upload = $app->uploadFile($fileName, $file, $cid);

  }

}

if (isset($_POST['id'])) {

  $cid = $_POST['id'];

  $email3 = $_POST['insuredemail'];

  $newowner = $_POST['newowner'];

  if ($newowner == 'Jo Sundermeyer') {
    $ownerId = 147;
    $appSpecialist = 'Jo Sundermeyer';
  } elseif ($newowner == 'Hannah Kesler') {
    $ownerId = 149;
    $appSpecialist = 'Hannah Kesler';
  } elseif ($newowner == 'Sara Taylor') {
    $ownerId = 5591;
    $appSpecialist = 'Sara Taylor';
  } elseif ($newowner == 'Round Robin') {

    $random = rand(1,3);
    
    if ($random == 1) {
      $ownerId = 147;
      $appSpecialist = 'Jo Sundermeyer';
    }

    if ($random == 2) {
      $ownerId = 149;
      $appSpecialist = 'Hannah Kesler';
    }

    if ($random == 3) {
      $ownerId = 5591;
      $appSpecialist = 'Sara Taylor';
    }
  }


    // add the Contact->New Process tag
    $tagId = 2237;
    $result = $app->grpAssign($cid, $tagId);

    //Build a new email address based on the insured contact id number that is unique for this policy
    $newEmail = $_POST['policy'] . "@themoneymultiplier.com";
    //pull the old email
    $oldEmail = $_POST['email'];
    //update the email field and the Insured Body Email field
    $conData = array('_InsuredBodyEmail' => $oldEmail, 'Email' => $newEmail, 'EmailAddress3' => $email3, 'OwnerID' => $ownerId, '_Owner1' => $appSpecialist);

    $conID = $app->updateCon($cid, $conData);


}
