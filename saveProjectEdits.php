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

$project_code = str_replace(array("'", '"'), "", $_GET['project_code']);
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
if ($newManagerId !== 0) {
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
}
$funderId = Funder::getFunderIds($project);
$numOfFunders = (int) filter_var($_GET['numOfFunders'], FILTER_SANITIZE_NUMBER_INT);
$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    $j = $i + 1;
    $newfunderId = (int) filter_var($_GET["funder{$j}"], FILTER_SANITIZE_NUMBER_INT);
    if (!empty($newfunderId) && $newfunderId !== 0) {
        if (!in_array($newfunderId, $funderId)) {
            if ($i < count($funderId)) {
                $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
                $funder[$i]->entity->getEntity($funderId[$i]);
                $funder[$i]->updateFunder(new Entity($newfunderId), $project, $_GET["funding_amt{$j}"], $_GET["date_given{$j}"], $_GET["funder_end_date{$j}"]);
            } else {
                $funder[$i] = new Funder(new Entity($newfunderId), $project);
                $funder[$i]->entity->getEntity($newfunderId);
                $funder[$i]->funding_amt = $_GET["funding_amt{$j}"] === "''" ? 'NULL' : $_GET["funding_amt{$j}"];
                $funder[$i]->date_given = $_GET["date_given{$j}"] === "''" ? 'NULL' : $_GET["date_given{$j}"];
                $funder[$i]->funder_end_date = $_GET["funder_end_date{$j}"] === "''" ? 'NULL' : $_GET["funder_end_date{$j}"];
                $funder[$i]->insertFunder();
            }
        }
    } else if ($newfunderId === 0 && $i < count($funderId)) {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->entity->getEntity($funderId[$i]);
        $funder[$i]->updateFunder(new Entity($funderId[$i]), $project,
                $_GET["funding_amt{$j}"] === "''" ? 'NULL' : $_GET["funding_amt{$j}"],
                $_GET["date_given{$j}"] === "''" ? 'NULL' : $_GET["date_given{$j}"],
                $_GET["funder_end_date{$j}"] === "''" ? 'NULL' : $_GET["funder_end_date{$j}"]
        );
    } else {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->deleteFunder();
    }
}

$clientId = Client::clientId($project);
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
                $client[$i]->updateClient($newClient, $project);
            } else {
                $client[$i] = new Client(new Entity($newclientId), $project);
                $client[$i]->insertClient();
            }
        }
    } else if ($newclientId === 0 && $i < count($clientId)) {
        // do nothing
    } else {
        $client[$i] = new Client(new Entity($clientId[$i]), $project);
        $client[$i]->deleteClient();
    }
}
echo "HERE END OF CLIENT";
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