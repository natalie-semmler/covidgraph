<?php 
  
// xml file path 
$path = "DataDashboard.xml"; 
  
// Read entire file into string 
$xmlfile = file_get_contents($path); 
  
// Convert xml string into an object 
$new = simplexml_load_string($xmlfile); 
  
// Convert into json 
$con = json_encode($new); 

// Convert into associative array 
$data_in = (json_decode($con,true)); 
$dates = $data_in['table1']['Detail_Collection']['Detail'];
$weeks = $data_in[]
//print_r ($dates);
$check = $data_in['table1']['Detail_Collection']['Detail'][0]['@attributes']['Textbox18'];
//print_r ($check);

// datapoints are numbers in order of descent in reference to each dataset needed
$dataPoints = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();
$dataPoints5 = array();
$dataPoints6 = array();
$dataPoints7 = array();

if ($check === "NaN"){
    $NaN=2;
}else {
    $NaN=0;
}
for ($x=$NaN; $x < count($dates); $x++){
    // employees / students tested
    $tested = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Students_Tested'];
    // dates, removing the first 3 characters
    $weeks = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Week'];
    $weekValue = substr($weeks, 3);
    // Number of positive employees
    $positive = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Positive'];
    // Number of reported offsite positive cases
    $positiveOff = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID_positive_reported__testing_done_elsewhere_3'];
    // how many employees have been hospitalized
    $hospitialized = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Employees_Positive_Hospitalized'];
     // how many employees have been hospitalized offiste
    $hospitializedOff = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID_positive_reported__testing_done_elsewhere__Hospitalized'];
    // number of patients tested
    $patsTested = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Patients_Tested'];
    // number of patients tested positive
    $patsPos= $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Patients_Positive'];

    // these arrays push the content into the respective data arrays
    array_push($dataPoints, array("y" =>  $tested, "label" => $weekValue ));
    array_push($dataPoints2, array("y" =>  $positive, "label" => $weekValue ));
    array_push($dataPoints3, array("y" =>  $positiveOff, "label" => $weekValue ));
    array_push($dataPoints4, array("y" =>  $hospitialized, "label" => $weekValue ));
    array_push($dataPoints5, array("y" =>  $hospitializedOff, "label" => $weekValue ));
    array_push($dataPoints6, array("y" =>  $patsTested, "label" => $weekValue ));
    array_push($dataPoints7, array("y" =>  $patsPos, "label" => $weekValue ));
}


// vv testing segment if needed to add in other sections, can be removed if felt not needed
 //$dataPoints7 = array();
//  for ($x=0; $x < count($dates); $x++){
//  	$patsPos= $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['ID__Patients_Positive'];
//  	$weeks = $data_in['table1']['Detail_Collection']['Detail'][$x]['@attributes']['Week'];
//  	$weekValue6 = substr($weeks, 3);
//  	array_push($dataPoints7, array("y" =>  $patsPos, "label" => $weekValue7 ));
//  }



?>