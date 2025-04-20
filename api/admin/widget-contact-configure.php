<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    die("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $email = str_replace('>', '&gt;', $email);
    $email = str_replace('<', '&lt;', $email);
} else {
    die("Informations manquantes");
}

if (isset($_POST['address'])) {
    $address = $_POST['address'];
    $address = str_replace('>', '&gt;', $address);
    $address = str_replace('<', '&lt;', $address);
} else {
    die("Informations manquantes");
}

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $phone = str_replace('>', '&gt;', $phone);
    $phone = str_replace('<', '&lt;', $phone);
} else {
    die("Informations manquantes");
}

if (isset($_POST['people'])) {
    $people = $_POST['people'];
    $people = str_replace('>', '&gt;', $people);
    $people = str_replace('<', '&lt;', $people);
} else {
    die("Informations manquantes");
}

if (strpos($people, '|') !== false || strpos($phone, '|') !== false || strpos($address, '|') !== false || strpos($email, '|') !== false) {
    die("Un ou plusieurs champs ont des valeurs contenants des caractères invalides");
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data", $phone . "|" . $email . "|" . $address . "|" . $people);
die("ok");