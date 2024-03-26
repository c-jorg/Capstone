<?php

use Classes\{
    Project,
    Funder,
    Entity,
    Project_Manager,
    Activity,
    Client,
    Principal_Researcher,
    Researcher,
    Contractor
};

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . ".php";
});

$project_code = $_GET['project_code'];
$project = new Project($project_code);
$project->getProject($project_code);
if (strcmp($project->title, $_GET['title'])) {
    $project->title = $_GET['title'];
}
if (strcmp($project->description, $_GET['description'])) {
    $project->description = $_GET['description'];
}
if (strcmp($project->stage, $_GET['stage'])) {
    $project->stage = $_GET['stage'];
}
if (strcmp($project->type, $_GET['type'])) {
    $project->type = $_GET['type'];
}
if (strcmp($project->start_date, $_GET['start_date'])) {
    $project->start_date = $_GET['start_date'];
}
if (strcmp($project->end_date, $_GET['end_date'])) {
    $project->end_date = $_GET['end_date'];
}
$project->updateProject();

$managerId = Project_Manager::managerId($project);
$newManagerId = (int) filter_var($_GET['project_manager'], FILTER_SANITIZE_NUMBER_INT);
if ($managerId !== $newManagerId) {
    if ($managerId !== $newManagerId) {
        $manager;
        if (!empty($managerId)) {
            $manager = new Project_Manager(new Entity($managerId), $project);
            $newManager = new Entity($newManagerId);
            $manager->updateManager($newManager, $project);
        } else {
            $manager = new Project_Manager(new Entity($newManagerId), $project);
            $manager->insertManager();
        }
    }
} else if ($_GET['project_manager'] === "''") {
    $managerId = Project_Manager::managerId($project);
    $manager;
    if ($managerId !== 0) {
        $manager = new Project_Manager(new Entity($managerId), $project);
        $manager->deleteManager();
    }
}

$numOfFunders = Funder::getNumOfFunders($project);
$funderId = Funder::getFunderIds($project);

$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    $newfunderId = (int) filter_var($_GET["funder{$i}"], FILTER_SANITIZE_NUMBER_INT);
    if ($newfunderId !== "''") {
        if ($funderId[$i] !== $newfunderId) {
            $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
            $funder[$i]->entity->getEntity($funderId[$i]);
        }
    } else {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->deleteFunder($funderId[$i]);
    }
}
$clientId = Client::clientId($project);
$numOfClients = count($clientId);
$client = [];
for ($i = 0; $i < $numOfClients; $i++) {
    if (str_contains($_GET["client{$i}"], "|")) {
        $extract = explode("|", $_GET["client{$i}"]);
        $newClientId = intval(trim($extract[0]));
        if (clientId[$i] !== $newClientId) {
            if ($clientId !== 0) {
                $client[$i] = new Client(new Entity($clientId[$i]), $project);
                $newClient = new Entity($newClientId);
                $client[$i]->updateClient($newClient, $project);
            } else {
                $client[$i] = new Client(new Entity($newClientId), $project);
                $client[$i]->insertManager();
            }
        }
    } else if (!$_GET["client{$i}"]) {
        if ($clientId[$i] !== 0) {
            $client[$i] = new Client(new Entity($clientId[$i]), $project);
            $client[$i]->deleteClient();
        }
    }
}
//if (str_contains($_GET['project_manager'], "|")) {
//    $managerId = Project_Manager::managerId($project);
//    $extract = explode("|", $_GET['project_manager']);
//    $newManagerId = intval(trim($extract[0]));
//    if ($managerId !== $newManagerId) {
//        $manager;
//        if ($managerId !== 0) {
//            $manager = new Project_Manager(new Entity($managerId), $project);
//            $newManager = new Entity($newManagerId);
//            $manager->updateManager($newManager, $project);
//        } else {
//            $manager = new Project_Manager(new Entity($newManagerId), $project);
//            $manager->insertManager();
//        }
//    }
//}
?>