<?php
use Classes\Project;

/*
 *  Entity.php class test
 */
include 'Classes/Project.php';
$project = new Project("111010");
$project->title = "Title here";
$project->description = "Description of Project";
$project->stage = "In Progress";
$project->type = "Engineering";
$project->start_date = "'2024-05-11'";
$project->end_date = "'2025-05-11'";

//$project->openConnection();

$project->createxx();
echo "<br>";
$code = $project->project_code;
echo "PROJECT CODE: " . $code;
echo "<br>";

$project->title = "New Title";
$project->update();
echo "<br>";
echo $project;
echo "<br>";

$project->load("7754");
echo "<br>";
echo $project;
echo "<br>";
$project->load($code);
echo "<br>";
//echo $entity;
//$project->deleteProject($code);
echo "<br>";
$project->load($code);

//$project->closeConnection();


