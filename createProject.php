<?php

require_once './Project.php';
$project_code = $_GET['project_code'];

$project = new Project($project_code);
echo "HERE 1";
$project->openConnection();
echo "here btwn";
$project->title = $_GET['title'];
$project->description = $_GET['description'];
$project->stage = $_GET['stage'];
$project->type = $_GET['type'];
$project->start_date = $_GET['start_date'] ? "'" . $_GET['start_date'] . "'" : "null";
$project->end_date = $_GET['end_date'] ? "'" . $_GET['end_date'] . "'" : "null";
echo "HERE 2";
$project->createProject();
$project->closeConnection();
if(!empty($_GET['managerId'])) { 
    require_once './Project_Manager.php';
    echo "AFTER REQUIREMENT: " . $_GET['managerId'] . " " . $project_code;
    $manager = new Project_Manager($_GET['managerId'],$project_code);
    $manager->openConnection();
    echo "AFTER declaring manager";
    $manager->insertManager();
    echo "AFTER INSERTING manager";
    $manager->closeConnection();
}

if(!empty($_GET['entity_id0'])) {
    require_once './Funder.php'; 
    $funder = [];
    $numOfFunders = $_GET['numFunders'];
    for($i = 0; $i < $numOfFunders; $i++) {    
        $funder[$i] = new Funder($_GET["entity_id{$i}"], $project_code);
        
        $funder[$i]->funding_amt = $_GET["funding_amt{$i}"];
        $funder[$i]->date_given = $_GET["date_given{$i}"] ? "'" . $_GET['date_given{$i}'] . "'" : "null";
        $funder[$i]->frequency = $_GET["frequency{$i}"];
        echo $funder[$i];
        $funder[$i]->openConnection();
        $funder[$i]->insertFunder();
        $funder[$i]->closeConnection();
    }
}
?>
