<?php

if (isset($_POST['id'])) {
    // die($_POST['id']);
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id'])) {
        $url = explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id']))[0];
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $_POST['id']);
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $url);
        }
        die("ok");
    }
} else {
    die("Pas d'identifiant");
}