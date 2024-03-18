<?php

class Project {
    public $pCode, $title, $stage, $description, $type, $manager;
    //arrays
    public $funders, $fundingTotals, $dateReceived, $frequency; // maybe Key: Funder, Value: Funding ... maybe Bool for yearly
    //dates
    public $startDate, $endDate;
    

    public function __construct($pCode) {
        $this->pCode = $pCode;
        $this->getProjectData($pCode);
    }
    
    public function updateProjectData($pCode) {
        $mysqli = new mysqli("localhost:3306", "root", "", "Research");
        
        if(mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        } else {
            $update_project = "UPDATE Projects ";
            $update_project .= "SET project_code = '$this->pCode', title = '$this->title', description = '$this->description', "
                    . "stage = '$this->stage', type = '$this->type', project_manager = '$this->manager', "
                    . "start_date = '$this->startDate', end_date = '$this->endDate' "
                    . "WHERE project_code = '$this->pCode';";
            echo $update_project;
            $update = mysqli_query($mysqli, $update_project) or die(mysqli_error($mysqli));
            echo "I'm HERE 44";
            if($update === true) { echo "Record has been updated successfully"; }
            
//            $update_funders = "UPDATE funding_amt, date_given, frequency, first_name, last_name, email, salutation, company" .
//                             " FROM Funders f, Entities e" .
//                             " WHERE f.project_code = '{$pCode}' AND f.entity_id = e.id;";
//            $result_funders= mysqli_query($mysqli, $query_funders) or die(mysqli_error($mysqli));
//            if($result_funders->num_rows > 0) { $this->setFundersEntries($result_funders); }
//            else { echo "Funders Not Found"; }
            
            mysqli_close($mysqli);
        }
    }
    
    private function getProjectData($pCode) {
        $mysqli = new mysqli("localhost:3306", "root", "", "Research");
        if(mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        } else {
            $query_projects = "SELECT title, description, stage, type, project_manager, start_date, end_date" . 
                               " FROM Projects" . 
                               " WHERE project_code = '{$pCode}';";
            $result_projects= mysqli_query($mysqli, $query_projects) or die(mysqli_error($mysqli));
            if($result_projects->num_rows == 1) { $this->setProjectEntries($result_projects); }
            else { echo "Project Not Found"; }
            
            $query_funders = "SELECT funding_amt, date_given, frequency, first_name, last_name, email, salutation, company" .
                             " FROM Funders f, Entities e" .
                             " WHERE f.project_code = '{$pCode}' AND f.entity_id = e.id;";
            $result_funders= mysqli_query($mysqli, $query_funders) or die(mysqli_error($mysqli));
            if($result_funders->num_rows > 0) { $this->setFundersEntries($result_funders); }
            else { echo "Funders Not Found"; }
            
            mysqli_close($mysqli);
        }
    }
    private function setProjectEntries($result) {
        $project = mysqli_fetch_array($result, MYSQLI_ASSOC);      
        $this->title = $project['title'];
        $this->description = $project['description'];
        $this->stage = $project['stage'];
        $this->type = $project['type'];
        $this->manager = $project['project_manager'];
        $this->startDate = $project['start_date'];
        $this->endDate = $project['end_date'];
    }
    private function setFundersEntries($result) {
        while ($funder_row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($funder_row['company'] != NULL) { $this->funders[] = $funder_row['company']; }
            else { $this->funders[] = "{$funder_row['first_name']} {$funder_row['last_name']}"; }
            $this->fundingTotals[] = $funder_row['funding_amt'];
            $this->dateReceived[] = $funder_row['date_given'];
            $this->frequency[] = $funder_row['frequency'];
        }
    }
}
class Activity extends Project {
    public $aCode, $principleResearcher, $notes;
    //arrays
    public $clients, $coResearchers, $students, $contractors;
    
    public function __construct($pCode, $aCode) {
        parent::__construct($pCode);
        $this->aCode = $aCode;
        getActivityData($aCode);
    }
    
    protected function getActivityData($aCode) {
        $mysqli = mysqli_connect("localhost", "USERNAME", "PASSWORD", "Research");
        if(mysqli_connect_errno()) {
            echo "Error connecting to the Database";
            exit();
        } else {
            $query = "SELECT title, stage, description, type, manager" .
                "FROM TABLE_NAMES" .
                "WHERE code != '$aCode';";
            $result= mysqli_query($mysqli, $query) or die(mysqli_error($mysqli));
            if ($result->num_rows == 1) {
                $activity = mysqli_fetch_array($result, MYSQLI_ASSOC);
//                 $this->title = $project['title'];
//                 $this->description = $project['description'];
//                 $this->stage = $project['stage'];
//                 $this->type = $project['type'];
//                 $this->manager = $project['manager'];
            }
            mysqli_close($mysqli);
        }
    }   
}
class Entity {
    
}
