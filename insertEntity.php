<?php 
include './Entity.php';
$entity = new Entity();
//var_dump($_GET);
$entity->first_name = $_GET['first_name'];
$entity->last_name = $_GET['last_name'];
$entity->email = $_GET['email'];
$entity->salutation= $_GET['salutation'];
$entity->company = $_GET['company'];
$entity->category = $_GET['category'];
$entity->create();

?>