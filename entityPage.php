<?php

use Classes\Entity;

include 'Classes/Entity.php';

if (!isset($_GET['id'])) {
    echo "Please send Entity id";
} else {
    ob_start();
    $id = $_GET['id'];
    $entity = new Entity($id);
    $entity->load($id);
    ob_end_clean();
    ?> 
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="index.css">
            <script src='header.js'></script>
            <script src='jquery-3.7.1.min.js'></script>
            <script src='entityPage.js'></script>
            <title>Contact : <?= $entity->id ?></title>
            <style>
                .tag {
                    font-weight: bold;
                }
            </style>
            <script></script>
        </head>
        <body onload="displayHeader();">
            <div class='header' id='header'></div>
            <br>
            <h1>Contact : <?= $entity->id?></h1>
            <br>
            <fieldset>
                <legend align="right" ><a class="editLink" id="editEntity"  onclick="editEntity(<?= $entity->id ?>);return false;" href="#">Edit</a></legend>
                <br>
                <p><span class='tag'>Salutation: </span><span id="salutation"><?= $entity->salutation ?></span></p>
                <br>
                <p><span class='tag'>First name: </span><span id="firstName"><?= $entity->first_name ?></span></p>
                <br>
                <p><span class='tag'>Last name: </span><span id="lastName"><?= $entity->last_name ?></span></p>
                <br>
                <p><span class='tag'>Company: </span><span id="company"><?= $entity->company ?></span></p>
                <br>
                <p><span class='tag'>Email: </span><span id="email"><?= $entity->email ?></span><span id="emailEmpty" style="color: red;"></span></p>
                <br>           
                <p><span class='tag'>Student designation: </span><span id="category"><?= $entity->category ?></span></p>
                <br>
                <div id="saveEditEntity" style="color: red;"></div>
                <br>
            </fieldset>
        </body>
    </html>
    <?php
}
?>