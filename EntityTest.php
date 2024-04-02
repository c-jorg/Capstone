<?php
use Classes\Entity;
/*
 *  Entity.php class test
 */
include 'Classes/Entity.php';
$entity = new Entity();
$entity->first_name = "Tom";
$entity->last_name = "Tom";
$entity->email = "email1@mail.com";
$entity->salutation = "Mr.";
$entity->company = "sTom inc.";

//$entity->openConnection();

$entity->create();
echo "<br>";

$id = $entity->id;
$entity->first_name = "Samu";
$entity->update();
echo "<br>";

$entity->load("9");
echo "<br>";
$entity->load($id);
echo "<br>";
echo $entity;
$entity->delete($id);
echo "<br>";
$entity->load($id);

//$entity->closeConnection();
