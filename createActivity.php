<?php include 'loginchecker.php';?>

<?php

use Classes\{Project, Funder, Entity, Project_Manager, Activity, Client, Principal_Researcher, Researcher, Contractor};

spl_autoload_register(function ($class) { include str_replace('\\', '/', $class) . ".php"; });

function removeQuotes($value) {
    return trim($value,'\'"');
}
ob_start();
$project_code = removeQuotes($_GET['project_code']);
$project = new Project($project_code);

$activity_code = removeQuotes($_GET['activity_code']);
$activity = new Activity($project, $activity_code);

$activity->title = removeQuotes($_GET['title']);
$activity->description = removeQuotes($_GET['description']);
$activity->start_date = removeQuotes($_GET['start_date']) ? "'" . removeQuotes($_GET['start_date']) . "'" : "null";
$activity->end_date = removeQuotes($_GET['end_date']) ? "'" . removeQuotes($_GET['end_date']) . "'" : "null";
$activity->notes= removeQuotes($_GET['notes']);

$activity->create();

if(isset($_GET['principal_researcher'])) {
    $pResearcherId = (int) filter_var(removeQuotes($_GET['principal_researcher']), FILTER_SANITIZE_NUMBER_INT);
    $pResearcher = new Principal_Researcher(new Entity($pResearcherId),$activity);
    $pResearcher->insert();
}
$numOfResearchers = (int) filter_var($_GET['numOfResearchers'], FILTER_SANITIZE_NUMBER_INT);
if ($numOfResearchers > 0) {
    $researcher = [];
    for($i = 0; $i < $numOfResearchers; $i++) {
        $j = $i + 1;
        $researcher[$i] = new Researcher(new Entity(removeQuotes($_GET["researcher{$j}"])), $activity);
        $researcher[$i]->insert();
    }
}
$numOfContractors = (int) filter_var(removeQuotes($_GET['numOfContractors']), FILTER_SANITIZE_NUMBER_INT);
if ($numOfContractors > 0) {
    $contractor = [];
    for($i = 0; $i < $numOfFunders; $i++) {
        $j = $i + 1;
        $contractor[$i] = new Contractor(new Entity(removeQuotes($_GET["contractor{$j}"])), $activity);        
        $contractor[$i]->payment = removeQuotes($_GET["payment{$j}"]) ? removeQuotes($_GET["payment{$j}"]) : "null";
        $contractor[$i]->date_payed = removeQuotes($_GET["date_payed{$j}"]) ? "'" . removeQuotes($_GET["date_payed{$i}"]) . "'" : "null";
        $contractor[$i]->insert();
    }
}
ob_end_clean();
echo "Subproject Created";
?>
