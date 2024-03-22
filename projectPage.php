<?php
include 'Project.php';
include 'Funder.php';
include 'Entity.php';
include 'Project_Manager.php';
include 'Activity.php';
include 'Client.php';

include 'Principal_Researcher.php';
include 'Researcher.php';
include 'Contractor.php';
// USE $_GET['project_code']; 
ob_start();
$project_code = $_GET['project_code'];
$project = new Project($project_code);
$project->openConnection();
$project->getProject($project_code);
$project->closeConnection();

$managerId = Project_Manager::managerId($project);
$manager;
if ($managerId !== 0) {
    $manager = new Project_Manager(new Entity($managerId), $project);
    $manager->entity->openConnection();
    $manager->entity->getEntity($managerId);
    $manager->entity->closeConnection();
}

$numOfFunders = Funder::getNumOfFunders($project);
$funderId = Funder::getFunderIds($project);

$funder = [];
for ($i = 0; $i < $numOfFunders; $i++) {
    $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
    $funder[$i]->entity->openConnection();
    $funder[$i]->entity->getEntity($funderId[$i]);
    $funder[$i]->entity->openConnection();
    $funder[$i]->openConnection();
    $funder[$i]->getFunderDetails();
    $funder[$i]->closeConnection();
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

$activityCodes = Activity::getActivityCodes($project_code);
$numOfActivities = count($activityCodes);
$activity = [];
$pResearcher = [];
$researcher = [];
$contractor = [];
for ($i = 0; $i < $numOfActivities; $i++) {
    $activity[$i] = new Activity($project, $activityCodes[$i]);
    $activity[$i]->openConnection();
    $activity[$i]->getActivity($activityCodes[$i]);
    $activity[$i]->closeConnection();
    $pResearcherId = Principal_Researcher::pResearcherId($activity[$i]);
    if ($pResearcherId !== 0) {
        $pResearcher[$i] = new Principal_Researcher(new Entity($managerId), $activity[$i]);
        $pResearcher[$i]->entity->openConnection();
        $pResearcher[$i]->entity->getEntity($pResearcherId);
        $pResearcher[$i]->entity->closeConnection();
    }
    $researcherId = Researcher::researcherId($activity[$i]);
    $numOfResearchers = count($researcherId);
    $researcher[$i] = [];
    for ($j = 0; $j < $numOfResearchers; $j++) {
        $researcher[$i][$j] = new Researcher(new Entity($researcherId[$j]), $activity[$i]);
        $researcher[$i][$j]->entity->openConnection();
        $researcher[$i][$j]->entity->getEntity($researcherId[$j]);
        $researcher[$i][$j]->entity->closeConnection();
    }
    $contractorId = Contractor::getContractorIds($activity[$i]);
    $numOfContractors = count($contractorId);
    $contractor[$i] = [];
    for ($j = 0; $j < $numOfContractors; $j++) {
        $contractor[$i][$j] = new Contractor(new Entity($contractorId[$j]), $activity[$i]);
        $contractor[$i][$j]->entity->openConnection();
        $contractor[$i][$j]->entity->getEntity($contractorId[$i]);
        $contractor[$i][$j]->entity->openConnection();
        $contractor[$i][$j]->openConnection();
        $contractor[$i][$j]->getContractorDetails();
        $contractor[$i][$j]->closeConnection();
    }
    ob_end_clean();
}
?> 
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="index.css">
        <script src='header.js'></script>
        <script src='projectPage.js'></script>
        <!--<script src='projectPosting.js'></script>-->
        <?php include './entityLookUp.php'; ?>
        <title>Project : <?= $project_code ?></title>
        <style>
            .tag {
                font-weight: bold;
            }
        </style>
        <script></script>
    </head>
    <body onload='displayHeader()'>
        <div class='header' id='header'></div>
        <br>
        <h1>Project : <?= $project_code ?></h1>
        <br>
        <fieldset>
            <legend align="right"><a id="editProject" onclick="editProject(<?= $project_code ?>, <?= $numOfFunders ?>, <?= $numOfClients ?>);loadEntities();return false;" href="#">Edit</a></legend>
            <br>
            <p><span class='tag'>Title: </span><span id="title"><?= $project->title ?></span></p><br>
            <p><span class='tag'>Stage: </span><span id="stage"><?= $project->stage ?></span></p><br>
            <p><span class='tag'>Description: </span><span id="description"><?= $project->description ?></span></p><br>
            <p><span class='tag'>Type: </span><span id="type"><?= $project->type ?></span></p><br>           
            <p><span class='tag'>Project Manager: </span><span id="manager"><?= $manager->entity->getName(); ?></span></p><br>           
            <p><span class='tag'>Start Date: </span><span id="start_date"><?= $project->start_date ?></span></p><br>
            <p><span class='tag'>End Date: </span><span id="end_date"><?= $project->end_date ?></span></p><br>
            <h3>Funders</h3>
            <?php
            for ($i = 0; $i < $numOfFunders; $i++) {
                $j = $i + 1;
                echo "<p><span class='tag'>{$j}: </span><span id='funder{$j}'>" . $funder[$i]->entity->getName() . "</span>&ensp;"
                . "<strong>Amount:</strong> $<span id='funding_amt{$j}'>" . $funder[$i]->funding_amt . "</span>&ensp;"
                . "<strong>Date Received:</strong> <span id='date_given{$j}'>" . $funder[$i]->date_given . "</span>&ensp;"
                . "<strong>Frequency:</strong> <span id='frequency{$j}'>" . $funder[$i]->frequency . "</span></p>";
            }
            $newFunder = $numOfFunders + 1;
            echo "<span id='addFunder{$newFunder}'></span>";
            echo "<br>";
            echo "<h3>Clients</h3>";
            for ($i = 1; $i <= $numOfClients; $i++) {
                echo "<p><span class='tag'>{$i}: </span><span id='client{$i}'>"
                . $client[$i - 1]->entity->getName() . "</span></p>";
            }
            ?>
            <br>
            <div id="saveEditProject"></div>
        </fieldset>
        <?php
        for ($j = 0; $j < $numOfActivities; $j++) {
            $k = $j + 1;
            ?>
            <br>
            <h2>Activity : <?= $activity[$j]->activity_code ?></h2>
            <br>
            <fieldset id='activity<?= $k ?>'>
                <legend align='right'><a id='editActivity<?= $k ?>' onclick='editActivity(<?= $k ?>,<?= $numOfClients ?>,<?= $numOfResearchers ?>,<?= $numOfStudents ?>,<?= $numOfContractors ?>);return false;' href='#'>Edit</a></legend>
                <br>
                <p><span class='tag'>Title: </span><span id='aTitle<?= $k ?>'><?= $activity[$j]->title ?></span></p>
                <br>
                <p><span class='tag'>Description: </span><span id='aDescription<?= $k ?>'><?= $activity[$j]->description ?></span></p>
                <br>
                <p><span class='tag'>Start date: </span><span id='aStartDate<?= $k ?>'><?= $activity[$j]->start_date ?></span></p>
                <br>
                <p><span class='tag'>End date: </span><span id='aEndDate<?= $k ?>'><?= $activity[$j]->end_date ?></span></p>
                <br>
                <?php
                if ($pResearcher[$j]->entity->getName()) {
                    ?>
                    <p><span class='tag'>Principal Researcher: </span><span id='pResearcher<?= $k ?>'><?= $pResearcher[$j]->entity->getName() ?></span></p>
                    <br>
                    <?php
                }
                echo "<h3>Researchers</h3>";
                for ($i = 1; $i <= count($researcher[$j]); $i++) {
                    echo "<p><span class='tag'>{$i}: </span><span id='researcher{$j}{$i}'>"
                    . $researcher[$j][$i - 1]->entity->getName() . "</span></p>";
                }
                echo "<br>";
                echo "<h3>Contractors</h3>";
                for ($i = 1; $i <= count($contractor[$j]); $i++) {
                    echo "<p><span class='tag'>{$i}: </span><span id='contractor{$j}{$i}'>" . $contractor[$j][$i - 1]->entity->getName() . "</span>"
                    . "&ensp;"
                    . "<span class='tag'>Payment: </span><span id='payment{$j}{$i}'>$" . $contractor[$j][$i - 1]->payment . "</span>"
                    . "&ensp;"
                    . "<span class='tag'>Pay date: </span><span id='payDate{$j}{$i}'>" . $contractor[$j][$i - 1]->date_payed . "</span></p>";
                }
                //$activityS .= "<br><div id='saveEditActivity{$k}'></div>";
                ?>
                <br>
            </fieldset>
            <?php
        }
        ?>
    </body>
</html>