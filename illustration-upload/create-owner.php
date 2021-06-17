<?php
require_once 'conn.php';
$mappingSpecialists = [
    "Jonah Dew" => 27,
    "Andrew Chesnutt" => 12167,
    "Jerome Marquardt" => 13105,
    "Terri Kesler" => 1
];

function getMappingSpecialists($name){
    global $mappingSpecialists;
    if(!isset($mappingSpecialists[$name])){
        $name = array_rand($mappingSpecialists);
    }

    return $mappingSpecialists[$name];
}

function isLinked($links, $contactId){
    $linked = false;
    if(isset($links) && is_array($links) && !empty($links)){
        foreach ($links as $link){
            if(isset($link["Contact.Id"]) && $link["Contact.Id"] == $contactId){
                $linked = true;
                break;
            }
        }
    }
    return $linked;
}

if(isset($_REQUEST["contactId"]) && is_numeric($_REQUEST["contactId"])){
    $conId = $_REQUEST["contactId"];
    $returnFields = [
        "_OwnerNamePolicy1",
        "_Policy1OwnerLastName",
        "_InsuranceOwnerEmail",
        "_InsuranceOwnerPhoneNumber",
        "_OwnerofPolicyTimezone",
        "_Company0",
        "_PolicyAmount",
        "_PremiumAmtmode1",
        "_InsuredBodyFirstName",
        "_InsuredBodyLastName",
        "_InsuredBodyEmail",
        "_DateofBirth",
        "_StateOfResidence",
        "_Gender",
        "Email",
        "Id",
        "_MappingSpecialist1",
        "_CurrentPolicyNumberOfOldPolicy",
    ];
    $conDat = $app->loadCon($conId, $returnFields);


    if(isset($conDat["_InsuranceOwnerEmail"])){
        $query = ["Email" => $conDat["_InsuranceOwnerEmail"]];
        $ownerFields = ["Email", "Id", "_Amountofopenpolicies"];
        $owner = $app->dsQuery("Contact", 10, 0, $query, $ownerFields);
        if(isset($owner[0]) && isset($owner[0]["Id"])){
            $ownerId = $owner[0]["Id"];

        } else {
            //create a new contact
			$mappingSpecialistID = (isset($conDat["_MappingSpecialist1"])) ? getMappingSpecialists($conDat["_MappingSpecialist1"]) : getMappingSpecialists("Round Robin");
            $ownerData = [
                "FirstName" => (isset($conDat["_OwnerNamePolicy1"]))? $conDat["_OwnerNamePolicy1"] : "",
                "LastName" => (isset($conDat["_Policy1OwnerLastName"]))? $conDat["_Policy1OwnerLastName"] : "",
                "Email" => (isset($conDat["_InsuranceOwnerEmail"]))? $conDat["_InsuranceOwnerEmail"] : "",
                "State" => (isset($conDat["_StateOfResidence"]))? $conDat["_StateOfResidence"] : "",
                "Phone1" => (isset($conDat["_InsuranceOwnerPhoneNumber"]))? $conDat["_InsuranceOwnerPhoneNumber"] : "",
                "_Company0" => (isset($conDat["_Company0"]))? $conDat["_Company0"] : "",
                "_CurrentPolicyNumberOfOldPolicy" => (isset($conDat["_CurrentPolicyNumberOfOldPolicy"]))? $conDat["_CurrentPolicyNumberOfOldPolicy"] : "",
                "ContactType" => "Owner of Policy",
                "OwnerID" => $mappingSpecialistID
            ];
            $ownerId = $app->addCon($ownerData);

            $app->optIn($conDat["_InsuranceOwnerEmail"], "Opted in via API");

        }

        $app->updateCon($ownerId, ["_ContactID" => $ownerId]);

        if(isset($ownerId) && is_numeric($ownerId)){


            // $returnFields2 = array("OwnerID");
            // $condat2 = $app->loadCon($ownerId, $returnFields2);
            // $updateOwner =  array("_MappingSpecialist1" => $returnFields2);
            // $updatedOwner = $app->updateCon($ownerId, $updateOwner);

            $links = $app->listLinkedContacts($ownerId);
            if(!isLinked($links, $conId)){
                if(!isset($owner[0]["_Amountofopenpolicies"])){
                    $policies = 1;
                } else {
                    $policies = intval($owner[0]["_Amountofopenpolicies"])+1;
                }
                $app->updateCon($ownerId, ["_Amountofopenpolicies" => $policies]);
                $success = $app->linkContacts($conId, $ownerId, 1);
                ob_start();?>

                Company: <?php echo $conDat["_Company0"]; echo chr(10);?>
                Insured Body: <?php echo $conDat["_InsuredBodyFirstName"];?> <?php echo $conDat["_InsuredBodyLastName"]; echo chr(10);?>
                Policy Amount: <?php echo $conDat["_PolicyAmount"]; echo chr(10);?>
                Premium Frequency: <?php echo $conDat["_PremiumAmtmode1"]; echo chr(10);?>
                
                <?php
                $description = ob_get_clean();
                $noteFields = [
                    "ActionDescription" => "Policy: ".$conDat["_Company0"]." | $".$conDat["_PolicyAmount"],
                    "CreationNotes" => $description,
                    "ContactId" => $ownerId,
                    "ObjectType" => "Note",
                    "IsAppointment" => 0,
                ];
                $value = $app->dsAdd("ContactAction", $noteFields);
            }

            if(!isset($conDat["_MappingSpecialist1"])) {

                
                $mapSpecialistName = array_search($mappingSpecialistID, $mappingSpecialists);
                $data = array("_MappingSpecialist1" => $mapSpecialistName);

                $updatedMapSpecialist = $app->updateCon($conId, $data);
            }

        }
        $app->grpAssign($ownerId, 5401); //applies Contact -> Owner Process
        $app->grpAssign($ownerId, 5397); //applies Mapping -> Mapping Started
        $app->grpAssign($ownerId, 5923);  //applies Inforce -> Send Inforce Email     

    }
    $result = $app->grpAssign($conId, 5395); // applies Mapping -> Owner Created
}