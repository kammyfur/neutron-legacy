<?php

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {
if (isset($_POST['sitename'])) {
    if (trim($_POST['sitename']) == "") {
        die("Le nom du site ne peut pas être vide");
    }
    if (strpos($_POST['sitename'], '<') !== false || strpos($_POST['sitename'], '>') !== false || strpos($_POST['sitename'], '{') !== false || strpos($_POST['sitename'], '}') !== false || strpos($_POST['sitename'], '@') !== false || strpos($_POST['sitename'], '#') !== false || strpos($_POST['sitename'], '|') !== false) {
        die("Le nom du site contient des caractères invalides");
    }
    if (strlen($_POST['sitename']) > 75) {
        die("Le nom du site est trop long");
    }
} else {
    die("Aucun nom n'a été reçu");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

if (isset($_FILES['icon'])) {
    if ($_FILES['icon']['error'] == 1) {
        $maxsize = ini_get('upload_max_filesize');
        if ($maxsize > 1000) {
            if ($maxsize > 1000000) {
                $maxsizestr = round($maxsize / 1000000, 2) . " Mio";
            } else {
                $maxsizestr = round($maxsize / 1000, 2) . " Kio";
            }
        } else {
            $maxsizestr = $maxsize . " octets";
        }
        die("La taille du fichier d'îcone dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['icon']['error'] == 2) {
        die("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['icon']['error'] == 3) {
        die("Le fichier d'îcone est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['icon']['error'] == 4) {
        die("Le fichier d'îcone est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['icon']['error'] == 6) {
        die("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['icon']['error'] == 7) {
        die("Impossible d'écrire sur le disque");
    }
    if ($_FILES['icon']['error'] == 8) {
        die("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['icon']['type'] != "image/png" && $_FILES['icon']['type'] != "image/jpeg" && $_FILES['icon']['type'] != "image/gif") {
        die("Le type de fichier du fichier îcone n'est pas supporté");
    }
    if ($_FILES['icon']['error'] == 0) {
        imagepng(imagecreatefromstring(file_get_contents($_FILES['icon']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
        unlink($_FILES['icon']['tmp_name']);
    }
}

if (isset($_FILES['banner'])) {
    if ($_FILES['banner']['error'] == 1) {
        $maxsize = ini_get('upload_max_filesize');
        if ($maxsize > 1000) {
            if ($maxsize > 1000000) {
                $maxsizestr = round($maxsize / 1000000, 2) . " Mio";
            } else {
                $maxsizestr = round($maxsize / 1000, 2) . " Kio";
            }
        } else {
            $maxsizestr = $maxsize . " octets";
        }
        die("La taille du fichier de bannière dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['banner']['error'] == 2) {
        die("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['banner']['error'] == 3) {
        die("Le fichier de bannière est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['banner']['error'] == 4) {
        die("Le fichier de bannière est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['banner']['error'] == 6) {
        die("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['banner']['error'] == 7) {
        die("Impossible d'écrire sur le disque");
    }
    if ($_FILES['banner']['error'] == 8) {
        die("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['banner']['type'] != "image/png" && $_FILES['banner']['type'] != "image/jpeg" && $_FILES['banner']['type'] != "image/gif") {
        die("Le type de fichier du fichier de bannière n'est pas supporté");
    }
    if ($_FILES['banner']['error'] == 0) {
        imagejpeg(imagecreatefromstring(file_get_contents($_FILES['banner']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg");
        unlink($_FILES['banner']['tmp_name']);
    }
}

$sitename = str_replace('>', '&gt;', $_POST['sitename']);
$sitename = str_replace('<', '&lt;', $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename", $sitename);
echo("ok");
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}