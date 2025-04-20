<?php

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

$jsonraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
if (isJson($jsonraw)) {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        die("Pas de nom");
    }
    if (isset($_POST['desc'])) {
        $desc = $_POST['desc'];
    } else {
        die("Pas de description");
    }
    if (isset($_POST['day'])) {
        $day = $_POST['day'];
    } else {
        die("Pas de jour");
    }
    if (isset($_POST['month'])) {
        $month = $_POST['month'];
    } else {
        die("Pas de mois");
    }
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
    } else {
        die("Pas d'année");
    }
    $date = strtotime($year . "-" . $month . "-" . $day);
    if (($month == "4" || $month == "6" || $month == "9" || $month == "11") && ($day == "31")) {
        die("Jour sélectionné invalide par rapport au mois sélectionné");
    }
    if (($month == "2") && ($day == "30" || $day == "31" || ((bool)date('L', strtotime("$year-01-01")) === false && $day == "29"))) {
        die("Jour sélectionné invalide par rapport au mois sélectionné");
    }
    if ((int)date('Y', $date) < (int)date('Y')) {
        die("Impossible de créer un événement dans le passé");
    }
    if (((int)date('m', $date) < (int)date('m')) && ((int)date('Y', $date) == (int)date('Y'))) {
        die("Impossible de créer un événement dans le passé");
    }
    if (((int)date('d', $date) < (int)date('d')) && ((int)date('m', $date) == (int)date('m'))) {
        die("Impossible de créer un événement dans le passé");
    }
    $name = str_replace('>', '&gt;', $name);
    $name = str_replace('<', '&lt;', $name);
    if (strlen($name) > 75) {
        die("Le nom de l'événement est trop long. Si vous avez des informations à ajouter, ajoutez les dans la description");
    }
    if (trim($name) == "") {
        die("Le nom de l'événement ne peut pas être vide");
    }
    $desc = str_replace('>', '&gt;', $desc);
    $desc = str_replace('<', '&lt;', $desc);
    if ($day == "1") {
        $daystr = "1er";
    } else {
        $daystr = $day;
    }
    if ($month == "01") {
        $monthstr = "janv.";
    }
    if ($month == "02") {
        $monthstr = "févr.";
    }
    if ($month == "03") {
        $monthstr = "mars";
    }
    if ($month == "04") {
        $monthstr = "avr.";
    }
    if ($month == "05") {
        $monthstr = "mai";
    }
    if ($month == "06") {
        $monthstr = "juin";
    }
    if ($month == "07") {
        $monthstr = "juil.";
    }
    if ($month == "08") {
        $monthstr = "août";
    }
    if ($month == "09") {
        $monthstr = "sept.";
    }
    if ($month == "10") {
        $monthstr = "oct.";
    }
    if ($month == "11") {
        $monthstr = "nov.";
    }
    if ($month == "12") {
        $monthstr = "déc.";
    }
    $json = json_decode($jsonraw);
    foreach($json->events as $event) {
        if (isset($event->timestamp)) {
            if ($event->timestamp == $year . date('m', $date) . date('d', $date)) {
                die("Un événement existe déjà ce jour là");
            }
        }
    }
    $pos = count($json->events);
    $json->events[$pos] = new stdClass();
    $json->events[$pos]->timestamp = $year . date('m', $date) . date('d', $date);
    $json->events[$pos]->name = $name;
    $json->events[$pos]->description = $desc;
    $json->events[$pos]->datestr = $daystr . " " . $monthstr . " " . $year;
    $newjsonraw = json_encode($json);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json", $newjsonraw);
    die("ok");
} else {
    die("Impossible d'initialiser la base de données");
}