<?php

use Classes\{Project, Funder, Entity, Project_Manager, Client};

spl_autoload_register(function ($class) { include str_replace('\\', '/', $class) . ".php"; });

function removeQuotes($value) {
    return trim($value,'\'"');
}
ob_start();
$project_code = removeQuotes($_GET['project_code']);
$project = new Project($project_code);
$project->title = removeQuotes($_GET['title']);
$project->description = removeQuotes($_GET['description']);
$project->stage = removeQuotes($_GET['stage']);
$project->type = removeQuotes($_GET['type']);
$project->start_date = removeQuotes($_GET['start_date']) ? "'" . removeQuotes($_GET['start_date']) . "'" : "null";
$project->end_date = removeQuotes($_GET['end_date']) ? "'" . removeQuotes($_GET['end_date']) . "'" : "null";
$project->status = removeQuotes($_GET['status']);
$project->create();
if(isset($_GET['project_manager'])) {
    $managerId = (int) filter_var(removeQuotes($_GET['project_manager']), FILTER_SANITIZE_NUMBER_INT);
    $manager = new Project_Manager(new Entity($managerId),$project);
    $manager->insert();
}
$numOfFunders = (int) filter_var(removeQuotes($_GET['numOfFunders']), FILTER_SANITIZE_NUMBER_INT);
if ($numOfFunders > 0) {
    $funder = [];
    for($i = 0; $i < $numOfFunders; $i++) {
        $j = $i + 1;
        $funder[$i] = new Funder(new Entity(removeQuotes($_GET["funder{$j}"])), $project);        
        $funder[$i]->funding_amt = removeQuotes($_GET["funding_amt{$j}"]) ? removeQuotes($_GET["funding_amt{$j}"]) : "null";
        $funder[$i]->date_given = removeQuotes($_GET["date_given{$j}"]) ? "'" . removeQuotes($_GET["date_given{$i}"]) . "'" : "null";
        $funder[$i]->funder_end_date = removeQuotes($_GET["funder_end_date{$j}"]) ? "'" . removeQuotes($_GET["funder_end_date{$i}"]) . "'" : "null";
        $funder[$i]->insert();
    }
}
$numOfClients = (int) filter_var($_GET['numOfClients'], FILTER_SANITIZE_NUMBER_INT);
if ($numOfClients > 0) {
    $client = [];
    for($i = 0; $i < $numOfClients; $i++) {
        $j = $i + 1;
        $client[$i] = new Client(new Entity(removeQuotes($_GET["client{$j}"])), $project);
        $client[$i]->insert();
    }
}
ob_end_clean();
echo "Project Created";
?>
