<?php

use Classes\{Project, Funder, Entity, Project_Manager, Activity, Client, Principal_Researcher, Researcher, Contractor};

spl_autoload_register(function ($class) { include str_replace('\\', '/', $class) . ".php"; });

$project_code = $_GET['project_code'];

$project = new Project($project_code);

$project->title = $_GET['title'];
$project->description = $_GET['description'];
$project->stage = $_GET['stage'];
$project->type = $_GET['type'];
$project->start_date = $_GET['start_date'] ? "'" . $_GET['start_date'] . "'" : "null";
$project->end_date = $_GET['end_date'] ? "'" . $_GET['end_date'] . "'" : "null";
$project->createxx();
if(!empty($_GET['managerId'])) { 
    $manager = new Project_Manager($_GET['managerId'],$project_code);
    $manager->insert();
}

if(!empty($_GET['entity_id0'])) { 
    $funder = [];
    $numOfFunders = $_GET['numFunders'];
    for($i = 0; $i < $numOfFunders; $i++) {    
        $funder[$i] = new Funder($_GET["entity_id{$i}"], $project_code);
        
        $funder[$i]->funding_amt = $_GET["funding_amt{$i}"];
        $funder[$i]->date_given = $_GET["date_given{$i}"] ? "'" . $_GET['date_given{$i}'] . "'" : "null";
        $funder[$i]->funder_end_date = $_GET["frequency{$i}"];
        echo $funder[$i];
        $funder[$i]->insert();
    }
}
?>
