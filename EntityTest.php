<?php

/*
 *  Entity.php class test
 */
include 'Entity.php';
$entity = new Entity();
$entity->first_name = "Tom";
$entity->last_name = "Tom";
$entity->email = "dif33f@mail.com";
$entity->salutation = "Mr.";
$entity->company = "sTom inc.";

$entity->openConnection();

$entity->createEntity();
echo "<br>";

$id = $entity->id;
$entity->first_name = "Samu";
$entity->updateEntity();
echo "<br>";

$entity->getEntity("9");
echo "<br>";
$entity->getEntity($id);
echo "<br>";
//echo $entity;
$entity->deleteEntity($id);
echo "<br>";
$entity->getEntity($id);

$entity->closeConnection();
