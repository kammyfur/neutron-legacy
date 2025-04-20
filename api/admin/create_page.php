<?php

// die("API pas prêt");

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

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_POST['type'])) {} else {
    die("Aucun type de page défini");
}

if (isset($_POST['title'])) {} else {
    die("Aucun titre défini");
}

if (isset($_POST['content'])) {} else {
    die("Aucun contenu n'a été spécifié");
}

$title = $_POST['title'];
$title = str_replace('>', '&gt;', $title);
$title = str_replace('<', '&lt;', $title);
$type = $_POST['type'];
$content = $_POST['content'];

$slug = preg_replace("/[^0-9a-zA-Z ]/m", "", $title );
$slug = str_replace(" ", "-", $slug);
$slug = strtolower($slug);

if (trim($title) == "") {
    die("Le titre ne peut pas être vide");
}

if ($slug == "api" || $slug == "cms-special" || $slug == "data" || $slug == "resources" || $slug == "widgets" || $slug == "-htaccess" || $slug == "index" || $slug == "index-php") {
    die("Vous ne pouvez pas utiliser un nom réservé en interne par le logiciel");
}

if (strlen($slug) > 70) {
    die("Le nom de la page est trop long");
}

if ($type != "0" && $type != "1") {
    die("Le type de page est inconnu");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $slug)) {
    die("Une page du même nom existe déjà");
}

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $slug, $content);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $slug, $type);
mkdir($_SERVER['DOCUMENT_ROOT'] . "/" . $slug);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $slug . "/index.php", '<?php include_once $_SERVER[\'DOCUMENT_ROOT\'] . "/api/renderer/render.php"; render(\'' . $slug . '\'); ?>');
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $slug . "/pagename", $title);
die("ok");