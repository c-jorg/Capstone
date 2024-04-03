<?php

use Classes\{
    Project,
    Funder,
    Entity,
    Project_Manager,
    Client,
};

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . ".php";
});
function removeQuotes($value) {
    return trim($value,'\'"');
}
$project_code = removeQuotes($_GET['project_code']);
//echo str_replace(array("'", '"'), "", $_GET['project_code']);
$project = new Project($project_code);
$project->load($project_code);
if (strcmp($project->title, $_GET['title'])) {
    $project->title = removeQuotes($_GET['title']);
}
if (strcmp($project->description, $_GET['description'])) { 
    $project->description = removeQuotes($_GET['description']);
}
if (strcmp($project->stage, $_GET['stage'])) {
    $project->stage = removeQuotes($_GET['stage']);
}
if (strcmp($project->status, $_GET['status'])) {
    $project->status = removeQuotes($_GET['status']);
}
if (strcmp($project->type, $_GET['type'])) {
    $project->type = removeQuotes($_GET['type']);
}
if (strcmp($project->start_date, $_GET['start_date'])) {
    $project->start_date = $_GET['start_date'];
}
if (strcmp($project->end_date, $_GET['end_date'])) {
    $project->end_date = $_GET['end_date'];
}
$project->update(); 
$managerId = Project_Manager::getId($project);
$newManagerId = (int) filter_var($_GET['project_manager'], FILTER_SANITIZE_NUMBER_INT);
if ($newManagerId !== 0) {
    if ($managerId !== $newManagerId) {
        if ($managerId !== $newManagerId) {
            $manager;
            if (!empty($managerId)) {
                $manager = new Project_Manager(new Entity($managerId), $project);
                $newManager = new Entity($newManagerId);
                $manager->update($newManager, $project);
            } else {
                $manager = new Project_Manager(new Entity($newManagerId), $project);
                $manager->insert();
            }
        }
    } else if ($_GET['project_manager'] === "''") {
        $managerId = Project_Manager::getId($project);
        $manager;
        if ($managerId !== 0) {
            $manager = new Project_Manager(new Entity($managerId), $project);
            $manager->delete();
        }
    }
}
$funderId = Funder::getIds($project);
$numOfFunders = (int) filter_var($_GET['numOfFunders'], FILTER_SANITIZE_NUMBER_INT);
$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    $j = $i + 1;
    $newfunderId = (int) filter_var($_GET["funder{$j}"], FILTER_SANITIZE_NUMBER_INT);
    if (!empty($newfunderId) && $newfunderId !== 0) {
        if (!in_array($newfunderId, $funderId)) {
            if ($i < count($funderId)) {
                $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
                $funder[$i]->entity->load($funderId[$i]);
                $funder[$i]->update(new Entity($newfunderId), $project, $_GET["funding_amt{$j}"], $_GET["date_given{$j}"], $_GET["funder_end_date{$j}"]);
            } else {
                $funder[$i] = new Funder(new Entity($newfunderId), $project);
                $funder[$i]->entity->load($newfunderId);
                $funder[$i]->funding_amt = $_GET["funding_amt{$j}"] === "''" ? 'NULL' : $_GET["funding_amt{$j}"];
                $funder[$i]->date_given = $_GET["date_given{$j}"] === "''" ? 'NULL' : $_GET["date_given{$j}"];
                $funder[$i]->funder_end_date = $_GET["funder_end_date{$j}"] === "''" ? 'NULL' : $_GET["funder_end_date{$j}"];
                $funder[$i]->insert();
            }
        }
    } else if ($newfunderId === 0 && $i < count($funderId)) {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->entity->load($funderId[$i]);
        $funder[$i]->update(new Entity($funderId[$i]), $project,
                $_GET["funding_amt{$j}"] === "''" ? 'NULL' : $_GET["funding_amt{$j}"],
                $_GET["date_given{$j}"] === "''" ? 'NULL' : $_GET["date_given{$j}"],
                $_GET["funder_end_date{$j}"] === "''" ? 'NULL' : $_GET["funder_end_date{$j}"]
        );
    } else {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->delete();
    }
}
for ($i = $numOfFunders; $i < count($funderId); $i++) {
    $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
    $funder[$i]->delete();
}
$clientId = Client::getIds($project);
$numOfClients = (int) filter_var($_GET['numOfClients'], FILTER_SANITIZE_NUMBER_INT);
$client = [];
for ($i = 0; $i < $numOfClients; $i++) {
    $j = $i + 1;
    $newclientId = (int) filter_var($_GET["client{$j}"], FILTER_SANITIZE_NUMBER_INT);
    if (!empty($newclientId) && $newclientId !== 0) {
        if (!in_array($newclientId, $clientId)) {
            if ($i < count($clientId)) {
                $client[$i] = new Client(new Entity($clientId[$i]), $project);
                $newClient = new Entity($newclientId);
                $client[$i]->update($newClient, $project);
            } else {
                $client[$i] = new Client(new Entity($newclientId), $project);
                $client[$i]->insert();
            }
        }
    } else if ($newclientId === 0 && $i < count($clientId)) {
        // do nothing
    } else {
        $client[$i] = new Client(new Entity($clientId[$i]), $project);
        $client[$i]->delete();
    }
}
for ($i = $numOfClients; $i < count($clientId); $i++) {
    $client[$i] = new Client(new Entity($clientId[$i]), $project);
    $client[$i]->delete();
}
echo "HERE END OF CLIENT";

?>