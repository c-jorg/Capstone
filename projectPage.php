<?php include 'loginchecker.php';?>

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

if (isset($_GET['project_code'])) {

    ob_start();
    $project_code = str_replace(array("'", '"'), "", $_GET['project_code']);
    $project = new Project($project_code);
    $project->load($project_code);

    $managerId = Project_Manager::getId($project);
    $manager;
    if ($managerId !== 0) {
        $manager = new Project_Manager(new Entity($managerId), $project);
        $manager->entity->load($managerId);
    }

    $numOfFunders = Funder::getNumOfFunders($project);
    $funderId = Funder::getIds($project);

    $funder = [];
    for ($i = 0; $i < $numOfFunders; $i++) {
        $funder[$i] = new Funder(new Entity($funderId[$i]), $project);
        $funder[$i]->entity->load($funderId[$i]);
        $funder[$i]->load();
    }
    $clientId = Client::getIds($project);
    $numOfClients = count($clientId);
    $client = [];
    for ($i = 0; $i < $numOfClients; $i++) {
        $client[$i] = new Client(new Entity($clientId[$i]), $project);
        $client[$i]->entity->load($clientId[$i]);
    }

    $activityCodes = Activity::getCodes($project_code);
    $numOfActivities = count($activityCodes);
    $activity = [];
    $pResearcher = [];
    $researcher = [];
    $contractor = [];
    $setParamString = "";
    for ($i = 0; $i < $numOfActivities; $i++) {
        $activity[$i] = new Activity($project, $activityCodes[$i]);
        $activity[$i]->load($activityCodes[$i]);
        $pResearcherId = Principal_Researcher::getIds($activity[$i]);
        if ($pResearcherId !== 0) {
            $pResearcher[$i] = new Principal_Researcher(new Entity($managerId), $activity[$i]);
            $pResearcher[$i]->entity->load($pResearcherId);
        }
        $researcherId = Researcher::getIds($activity[$i]);
        $numOfResearchers = count($researcherId);
        $researcher[$i] = [];
        for ($j = 0; $j < $numOfResearchers; $j++) {
            $researcher[$i][$j] = new Researcher(new Entity($researcherId[$j]), $activity[$i]);
            $researcher[$i][$j]->entity->load($researcherId[$j]);
        }
        $contractorId = Contractor::getIds($activity[$i]);
        $numOfContractors = count($contractorId);
        $contractor[$i] = [];
        for ($j = 0; $j < $numOfContractors; $j++) {
            $contractor[$i][$j] = new Contractor(new Entity($contractorId[$j]), $activity[$i]);
            $contractor[$i][$j]->entity->load($contractorId[$i]);
            $contractor[$i][$j]->load();
        }
        $setParamString .= "setActivityParam(" . $i . "," . $numOfResearchers . "," . $numOfContractors . ");";
    }
    ob_end_clean();
    $onloadString = "setProjectParam($numOfFunders,$numOfClients);setNumOfActivities($numOfActivities);$setParamString";
    ?> 
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="index.css">
            <script src='header.js'></script>
            <script src='jquery-3.7.1.min.js'></script>
            <script src='projectPage.js'></script>
            <title>Project : <?= $project_code ?></title>
            <style>
                .tag {       
                    font-weight: bold;
                }
                .status {
                    text-align: center;
                    font-weight: bold;
                    vertical-align: middle;
                    min-width: 50px;
                    padding: 0.5rem;
                    border: 1px solid black;
                    display: inline-block;
                }
            </style>
            <script></script>
        </head>
        <body onload="displayHeader();onloadFunctions('<?= $onloadString ?>')">
            <div class='header' id='header'></div>
            <br>
            <h1>Project : <?= $project_code ?></h1>
            <br>
            <fieldset>
                <legend align="right" ><a class="editLink" id="editProject"  onclick="editProject('<?= $project_code ?>');loadEntities();return false;" href="#">Edit</a></legend>
                <br>
                <p><span class='tag'>Title: </span><span id="title"><?= $project->title ?></span></p>
                <br>
                <p><span class='tag'>Stage: </span><span id="stage"><?= $project->stage ?></span></p>
                <br>
                <p><span class='tag'>Status: </span><span class="status" id="status" style="background-color: <?= $project->status ?>;"><?= $project->status ?></span></p>
                <br>
                <p><span class='tag'>Description: </span><span id="description"><?= $project->description ?></span></p>
                <br>
                <p><span class='tag'>Type: </span><span id="type"><?= $project->type ?></span></p>
                <br>           
                <p><span class='tag'>Project Manager: </span><span id="manager"><?= $manager->entity->getName(); ?></span></p>
                <br>           
                <p><span class='tag'>Start Date: </span><span id="start_date"><?= $project->start_date ?></span></p>
                <br>
                <p><span class='tag'>End Date: </span><span id="end_date"><?= $project->end_date ?></span></p><br>
                <h3>Funders</h3>
                <div class='Funders'>
                    <?php
                    for ($i = 0; $i < $numOfFunders; $i++) {
                        $j = $i + 1;
                        echo "<p id='addFunder{$j}'>"
                        . "<span class='tag'>{$j}: </span><span id='funder{$j}'>" . $funder[$i]->entity->getName() . "</span>&ensp;"
                        . "<strong>Amount:</strong> $<span id='funding_amt{$j}'>" . $funder[$i]->funding_amt . "</span>&ensp;"
                        . "<strong>Date Received:</strong> <span id='date_given{$j}'>" . $funder[$i]->date_given . "</span>&ensp;"
                        . "<strong>End Date:</strong> <span id='funder_end_date{$j}'>" . $funder[$i]->funder_end_date . "</span>&ensp;"
                        . "</p>";
                    }
                    ?>
                    <span id='addFunderLink'></span>

                </div>
                <br>

                <h3>Clients</h3>
                <div class='Clients'>
                    <?php
                    for ($i = 1; $i <= $numOfClients; $i++) {
                        echo "<p id='addClient{$i}'>"
                        . "<span class='tag'>{$i}: </span>"
                        . "<span id='Client{$i}'>" . $client[$i - 1]->entity->getName() . "</span>&ensp;"
                        . "</p>";
                    }
                    ?>
                    <span id='addClientLink'></span>
                </div>
                <br>
                <div id="saveEditProject"></div>
            </fieldset>
            <?php
            for ($j = $numOfActivities - 1; $j >= 0; $j--) {
                $k = $j + 1;

                echo "<br><h2>Subproject : " . $activityCodes[$j] . "</h2><br>";
                echo "<fieldset>";
                echo "<legend align='right'><a class='editLink' id='editActivity$k' onclick='editActivity($k," . $project_code . "," . $activityCodes[$j] . ");return false;' href='#'>Edit</a></legend> ";
                echo "<br>
                      <p><span class='tag'>Title: </span><span id='aTitle$k'>" . $activity[$j]->title . "</span></p><br>
                      <p><span class='tag'>Description: </span><span id='aDescription$k'>" . $activity[$j]->description . "</span></p><br>
                      <p><span class='tag'>Start date: </span><span id='a_start_date$k'>" . $activity[$j]->start_date . "</span></p><br>
                      <p><span class='tag'>End date: </span><span id='a_end_date$k'>" . $activity[$j]->end_date . "</span></p><br>
                    <p><span class='tag'>Principal Researcher: </span><span id='pResearcher$k'>" . $pResearcher[$j]->entity->getName() . "</span></p><br>";
                ?>
                <h3>Researchers</h3>
                <div class="Researchers">
                    <?php
                    for ($i = 1; $i <= count($researcher[$j]); $i++) {
                        echo "<p id='addResearcher{$k}{$i}'>"
                        . "<span class='tag'>{$i}: </span>"
                        . "<span id='researcher{$k}{$i}'>" . $researcher[$j][$i - 1]->entity->getName() . "</span>"
                        . "</p>";
                    }

                    echo "<span id='addResearcherA{$k}Link'></span>";
                    ?>
                </div>
                <br>
                <h3>Contractors</h3>
                <div class='Contractors'>
                    <?php
                    for ($i = 1; $i <= count($contractor[$j]); $i++) {
                        echo "<p id='addContractor{$k}{$i}'>"
                        . "<span class='tag'>{$i}: </span><span id='contractor{$k}{$i}'>" . $contractor[$j][$i - 1]->entity->getName() . "</span>&ensp;"
                        . "<span class='tag'>Payment: $</span><span id='payment{$k}{$i}'>" . $contractor[$j][$i - 1]->payment . "</span>&ensp;"
                        . "<span class='tag'>Pay date: </span><span id='pay_date{$k}{$i}'>" . $contractor[$j][$i - 1]->date_payed . "</span>"
                        . "</p>";
                    }
                    echo "<span id='addContractorA{$k}Link'></span>";
                    echo "</div>";
                    echo "<br><p><span class='tag'>Notes: </span><span id='aNotes$k'>" . $activity[$j]->notes . "</span></p><br>";
                    echo "<br><div id='saveEditActivity{$k}'></div>";
                    echo "<br></fieldset>";
                }
                ?>
        </body>
    </html>
    <?php
} else {
    echo "Please set project_code";
}