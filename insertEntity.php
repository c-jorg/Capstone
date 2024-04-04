<?php 
use Classes\Entity;
include 'Classes/Entity.php';
function removeQuotes($value) {
    return trim($value,'\'"');
}
$entity = new Entity();
$entity->first_name = removeQuotes($_GET['first_name']);
$entity->last_name = removeQuotes($_GET['last_name']);
$entity->email = removeQuotes($_GET['email']);
$entity->salutation= removeQuotes($_GET['salutation']);
$entity->company = removeQuotes($_GET['company']);
$entity->category = removeQuotes($_GET['category']);
$entity->create();

?>