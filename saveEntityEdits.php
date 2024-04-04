<?php

use Classes\Entity;
include 'Classes/Entity.php';

function removeQuotes($value) {
    return trim($value,'\'"');
}
$id = removeQuotes($_GET['id']);
ob_start();
$entity = new Entity($id);
$entity->load($id);
if (strcmp($entity->salutation, $_GET['salutation'])) {
    $entity->salutation = removeQuotes($_GET['salutation']);
}
if (strcmp($entity->first_name, $_GET['first_name'])) { 
    $entity->first_name= removeQuotes($_GET['first_name']);
}
if (strcmp($entity->last_name, $_GET['last_name'])) {
    $entity->last_name = removeQuotes($_GET['last_name']);
}
if (strcmp($entity->company, $_GET['company'])) {
    $entity->company = removeQuotes($_GET['company']);
}
if (strcmp($entity->email, $_GET['email'])) {
    $entity->email = removeQuotes($_GET['email']);
}
if (strcmp($entity->category, $_GET['category'])) {
    $entity->category = removeQuotes($_GET['category']);
}
$entity->update();

ob_end_clean();
echo "Contact Updated";
?>
