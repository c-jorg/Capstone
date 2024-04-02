<?php

use Classes\{
    Project,
    Entity,
    Activity,
    Principal_Researcher,
    Researcher,
    Contractor
};

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . ".php";
});
function removeQuotes($value) {
    return trim($value,'\'"');
}
$project_code = removeQuotes($_GET['project_code']);
$project = new Project($project_code);
$project->load($project_code);

$activity_code = removeQuotes($_GET['activity_code']);
$activity = new Activity($project, $activity_code);
$activity->load($activity_code);

if (strcmp($activity->title, $_GET['title'])) {
    $activity->title = removeQuotes($_GET['title']);
}
if (strcmp($activity->description, $_GET['description'])) { 
    $activity->description = removeQuotes($_GET['description']);
}
if (strcmp($activity->start_date, $_GET['start_date'])) {
    $activity->start_date = removeQuotes($_GET['start_date']);
}
if (strcmp($activity->end_date, $_GET['end_date'])) {
    $activity->end_date = removeQuotes($_GET['end_date']);
}
if (strcmp($activity->notes, $_GET['notes'])) {
    $activity->notes = removeQuotes($_GET['notes']);
}
$activity->update(); 
$pResearcherId = Principal_Researcher::getIds($activity);
$newPResearcherId = (int) filter_var($_GET['principal_researcher'], FILTER_SANITIZE_NUMBER_INT);
if ($newPResearcherId !== 0) {
    if ($pResearcherId !== $newPResearcherId) {
        if ($pResearcherId !== $newPResearcherId) {
            $pResearcher;
            if (!empty($pResearcherId)) {
                $pResearcher = new Principal_Researcher(new Entity($pResearcherId), $activity);
                $newPResearcher = new Entity($newPResearcherId);
                $pResearcher->update($newPResearcher, $activity);
            } else {
                $pResearcher = new Principal_Researcher(new Entity($newPResearcherId), $activity);
                $pResearcher->insert();
            }
        }
    } else if ($_GET['principal_researcher'] === "''") {
        $pResearcherId = Principal_Researcher::getIds($activity);
        $pResearcher;
        if ($pResearcherId !== 0) {
            $pResearcher = new Principal_Researcher(new Entity($pResearcherId), $activity);
            $pResearcher->delete();
        }
    }
}
$researcherId = Researcher::getIds($activity);
$numOfResearchers = (int) filter_var($_GET['numOfResearchers'], FILTER_SANITIZE_NUMBER_INT);
$researcher = [];
for ($i = 0; $i < $numOfResearchers; $i++) {
    $j = $i + 1;
    $newResearcherId = (int) filter_var($_GET["researcher{$j}"], FILTER_SANITIZE_NUMBER_INT);
    if (!empty($newResearcherId) && $newResearcherId !== 0) {
        if (!in_array($newResearcherId, $researcherId)) {
            if ($i < count($researcherId)) {
                $researcher[$i] = new Researcher(new Entity($researcherId[$i]), $activity);
                $newResearcher = new Entity($newResearcherId);
                $researcher[$i]->update($newResearcher, $activity);
            } else {
                $researcher[$i] = new Researcher(new Entity($newResearcherId), $activity);
                $researcher[$i]->insert();
            }
        }
    } else if ($newResearcherId === 0 && $i < count($researcherId)) {
        // do nothing
    } else {
        $researcher[$i] = new Researcher(new Entity($researcherId[$i]), $activity);
        $researcher[$i]->delete();
    }
}
for ($i = $numOfResearchers; $i < count($researcherId); $i++) {
    $researcher[$i] = new Researcher(new Entity($researcherId[$i]), $activity);
    $researcher[$i]->delete();
}
$contractorId = Contractor::getIds($activity);
$numOfContractors = (int) filter_var($_GET['numOfContractors'], FILTER_SANITIZE_NUMBER_INT);
$contractor = [];
for ($i = 0; $i < $numOfContractors; $i++) {
    $j = $i + 1;
    $newContractorId = (int) filter_var($_GET["contractor{$j}"], FILTER_SANITIZE_NUMBER_INT);
    echo "\n" . $_GET["contractor{$j}"] . "\n";
    echo "\n" . "NEW C id : " . $newContractorId . "\n";
    if (!empty($newContractorId) && $newContractorId !== 0) {
        if (!in_array($newContractorId, $contractorId)) {
            if ($i < count($contractorId)) {
                $contractor[$i] = new Contractor(new Entity($contractorId[$i]), $activity);
                $contractor[$i]->entity->load($contractorId[$i]);
                $contractor[$i]->update(new Entity($newContractorId), $activity, $_GET["payment{$j}"], $_GET["date_payed{$j}"]);
            } else {
                $contractor[$i] = new Contractor(new Entity($newContractorId), $activity);
                $contractor[$i]->entity->load($newContractorId);
                $contractor[$i]->payment = $_GET["payment{$j}"] === "''" ? 'NULL' : removeQuotes($_GET["payment{$j}"]);
                $contractor[$i]->date_payed = $_GET["date_payed{$j}"] === "''" ? 'NULL' : $_GET["date_payed{$j}"];
                $contractor[$i]->insertContractor();
            }
        }
    } else if ($newContractorId === 0 && $i < count($contractorId)) {
        echo "CON ID: ". $contractorId[$i] ."\n";
        $contractor[$i] = new Contractor(new Entity($contractorId[$i]), $activity);
        $contractor[$i]->entity->load($contractorId[$i]);
        $contractor[$i]->update(new Entity($contractorId[$i]), $activity,
                $_GET["payment{$j}"] === "''" ? 'NULL' : $_GET["payment{$j}"],
                $_GET["date_payed{$j}"] === "''" ? 'NULL' : $_GET["date_payed{$j}"]
                );
    } else {
        $contractor[$i] = new Contractor(new Entity($contractorId[$i]), $activity);
        $contractor[$i]->delete();
    }
}
for ($i = $numOfContractors; $i < count($contractorId); $i++) {
    $contractor[$i] = new Contractor(new Entity($contractorId[$i]), $activity);
    $contractor[$i]->delete();
}
echo "HERE END OF Contractors";
?>