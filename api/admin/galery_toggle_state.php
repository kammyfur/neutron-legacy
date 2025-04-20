<?php

if (isset($_POST['state'])) {
    $state = $_POST['state'];
} else {
    die("Aucun état spécifié");
}

if ($state == "1") {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled", "");
    die("ok");
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled");
    }
    die("ok");
}