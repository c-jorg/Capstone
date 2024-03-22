<?php

/*
 *  Entity.php class test
 */
include 'Project.php';
$project = new Project("1010");
$project->title = "Title here";
$project->description = "Description of Project";
$project->stage = "In Progress";
$project->type = "Engineering";
$project->start_date = "'2024-05-11'";
$project->end_date = "'2025-05-11'";

$project->openConnection();

$project->createProject();
echo "<br>";
$code = $project->project_code;
echo "PROJECT CODE: " . $code;
echo "<br>";

$project->title = "New Title";
$project->updateProject();
echo "<br>";
//echo $project;
echo "<br>";

$project->getProject("7754");
echo "<br>";
echo $project;
echo "<br>";
$project->getProject($code);
echo "<br>";
//echo $entity;
//$project->deleteProject($code);
echo "<br>";
$project->getProject($code);

$project->closeConnection();


