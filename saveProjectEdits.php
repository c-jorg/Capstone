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
    return trim($value, '\'"');
}

ob_start();
$option = array("options" => "removeQuotes");
$project_code = filter_input(INPUT_GET, 'project_code', FILTER_CALLBACK, $option);
//echo str_replace(array("'", '"'), "", $_GET['project_code']);
$project = new Project($project_code);
$project->load($project_code);

$title = filter_input(INPUT_GET, 'title', FILTER_CALLBACK, $option);
if (strcmp($project->title, $title)) {
    $project->title = $title;
}

$description = filter_input(INPUT_GET, 'description', FILTER_CALLBACK, $option);
if (strcmp($project->description, $description)) {
    $project->description = $description;
}

$stage = filter_input(INPUT_GET, 'stage', FILTER_CALLBACK, $option);
if (strcmp($project->stage, $stage)) {
    $project->stage = $stage;
}

$status = filter_input(INPUT_GET, 'status', FILTER_CALLBACK, $option);
if (strcmp($project->status, $status)) {
    $project->status = $status;
}

$type = filter_input(INPUT_GET, 'type', FILTER_CALLBACK, $option);
if (strcmp($project->type, $type)) {
    $project->type = $type;
}

$start_date = filter_input(INPUT_GET, 'start_date');
if (strcmp($project->start_date, $start_date)) {
    $project->start_date = $start_date;
}

$end_date = filter_input(INPUT_GET, 'end_date');
if (strcmp($project->end_date, $end_date)) {
    $project->end_date = $end_date;
}
$project->update();

$managerId = Project_Manager::getId($project);
$newManagerId = filter_input(INPUT_GET, 'project_manager', FILTER_CALLBACK, $option);
if (is_numeric($newManagerId)) {
    if ($managerId !== $newManagerId) {
        $manager;
        if (empty($managerId)) {
            $manager = new Project_Manager(new Entity($newManagerId), $project);
            $manager->insert();
        } else {
            $manager = new Project_Manager(new Entity($managerId), $project);
            $newManager = new Entity($newManagerId);
            $manager->update($newManager, $project);
        }
    }
} else if (empty($newManagerId)) {
    $managerId = Project_Manager::getId($project);
    $manager;
    if ($managerId !== 0) {
        $manager = new Project_Manager(new Entity($managerId), $project);
        $manager->delete();
    }
}
$funderId = Funder::getIds($project);
$numOfFunders = (int) filter_input(INPUT_GET, 'numOfFunders', FILTER_SANITIZE_NUMBER_INT);
$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    $j = $i + 1;
    $newfunderId = filter_input(INPUT_GET, "funder{$j}", FILTER_CALLBACK, $option);
    if (is_numeric($newfunderId)) {
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
    } else if (!empty($newfunderId) && $i < count($funderId)) {
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
$numOfClients = (int) filter_input(INPUT_GET, 'numOfClients', FILTER_SANITIZE_NUMBER_INT);
$client = [];
for ($i = 0; $i < $numOfClients; $i++) {
    $j = $i + 1;
    $newclientId = filter_input(INPUT_GET, "client{$j}", FILTER_CALLBACK, $option);
    if (is_numeric($newclientId)) {
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
    } else if (empty($newclientId)) {
        $client[$i] = new Client(new Entity($clientId[$i]), $project);
        $client[$i]->delete();
    }
}
for ($i = $numOfClients; $i < count($clientId); $i++) {
    $client[$i] = new Client(new Entity($clientId[$i]), $project);
    $client[$i]->delete();
}
ob_end_clean();
echo "Edits Saved";
?>