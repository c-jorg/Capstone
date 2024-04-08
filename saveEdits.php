<?php include 'loginchecker.php';?>

<?php
include 'Project.php';
$pCode = filter_input(INPUT_GET, 'project_code');
$project = new Project($pCode);

$project->title = filter_input(INPUT_GET, 'title');
$project->description = filter_input(INPUT_GET, 'description');
$project->stage = filter_input(INPUT_GET, 'stage');
$project->type = filter_input(INPUT_GET, 'type');
$project->manager = filter_input(INPUT_GET, 'project_manager');
$project->startDate= filter_input(INPUT_GET, 'start_date');
$project->endDate = filter_input(INPUT_GET, 'end_date');
$project->updateProjectData($pCode);
?>