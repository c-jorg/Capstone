<?php
include 'Project.php';
include 'Funder.php';
include 'Project_Manager.php';
include 'Client.php';
include 'Entity.php';

$project_code = $_GET['project_code'];
$project = new Project($project_code);
$project->openConnection();
$project->getProject($project_code);
$project->closeConnection();
if (strcmp($project->title, $_GET['title'])) { $project->title = $_GET['title']; }
if (strcmp($project->description, $_GET['description'])) { $project->description = $_GET['description']; }
if (strcmp($project->stage, $_GET['stage'])) { $project->stage = $_GET['stage']; }
if (strcmp($project->type, $_GET['type'])) { $project->type = $_GET['type']; }
if (strcmp($project->start_date, $_GET['start_date'])) { $project->start_date = $_GET['start_date']; }
if (strcmp($project->end_date, $_GET['end_date'])) { $project->end_date = $_GET['end_date']; }
$project->openConnection();
$project->updateProject();
$project->closeConnection();

if (str_contains($_GET['project_manager'], "|")) {
    $managerId = Project_Manager::managerId($project);
    $extract = explode("|", $_GET['project_manager']);
    $newManagerId = intval(trim($extract[0]));
    $manager;
    if ($managerId !== 0) {
        $manager = new Project_Manager(new Entity($managerId), $project);
        $newManager = new Entity($newManagerId);
        $manager->updateManager($newManager, $project);
    } else {
        $manager = new Project_Manager(new Entity($newManagerId), $project);
        $manager->entity->openConnection();
        $manager->entity->getEntity($managerId);
        $manager->entity->closeConnection();
        $manager->openConnection();
        $manager->insertManager();
        $manager->closeConnection();
    }
}

$numOfFunders = Funder::getNumOfFunders($project);
$funderId = Funder::getFunderIds($project);

$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    if(str_contains($_GET["funder{$i}"], "|")) {
        $extract = explode("|", $_GET["funder{$i}"]);
        $newfunderId = intval(trim($extract[0]));
    }
    $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
    $funder[$i]->entity->openConnection();
    $funder[$i]->entity->getEntity($funderId[$i]);
    $funder[$i]->entity->openConnection();
}
$clientId = Client::clientId($project);
$numOfClients = count($clientId);
$client = [];
for ($i = 0; $i < $numOfClients; $i++) {
    $client[$i] = new Client(new Entity($clientId[$i]), $project);
    $client[$i]->entity->openConnection();
    $client[$i]->entity->getEntity($clientId[$i]);
    $client[$i]->entity->closeConnection();
}


?>