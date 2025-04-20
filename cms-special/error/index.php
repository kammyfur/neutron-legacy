<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

if ($ready) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        if (isset($_GET['id'])) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - " . $_GET['id'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - Unknown \n\n");
        }
    } else {
        if (isset($_GET['id'])) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - " . $_GET['id'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/HTTP-ERROR - Unknown \n\n");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/error.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo("Erreur - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Erreur - MPCMS");
    }

    ?></title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php" ?>
</head>
<body>
    <div class="centered discover">
        <h2>Une erreur s'est produite</h2>
        <p>Nous sommes désolés, mais une erreur s'est produite lors du chargement de la page.</p>
        <p>Si vous avez cliqué sur un lien, celui-ci n'est peut-être plus valide, ou alors un autre type d'erreur s'est produit.</p>
        <p><b><?php
        
        if (isset($_GET['id'])) {
            if (isset($_GET['description'])) {
                echo("Erreur " . $_GET['id'] . " : " . $_GET['description']);
            } else {
                echo("Erreur " . $_GET['id']);
            }
        } else {
            if (isset($_GET['description'])) {
                echo($_GET['description']);
            } else {
                echo("Aucune information sur l'erreur n'a été renvoyée");
            }
        }

        ?></b></p>
        <a class="button" href="/">Accueil du site</a>
    </div>
</body>
</html>