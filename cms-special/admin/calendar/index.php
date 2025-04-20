<?php

$invalid = false;

if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("<script>location.href = '/cms-special/admin'</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin'</script>");
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password"))) {
        die("<script>location.href = '/cms-special/admin/home';</script>");
        return;
    } else {
        $invalid = true;
    }
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

?>

<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/admin.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo("Administration du site - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Administration du site - MPCMS");
    }

    ?></title>
    <?php
        if (!$ready) {
            die("<script>location.href = '/cms-special/setup';</script></head>");
        }
    ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
</head>
<body>
    <div id="settings">
        <h1><center>Administration du site</center></h1><center><a class="sblink" href="/cms-special/admin/logout" title="Terminer la session de manière sécurisée et retourner à l'écran de connexion">Terminer la session</a></center>
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/calendar" class="sblink">Calendrier</a></small></p>
        <h2>Ajouter/supprimer des événements</h2>
        <h3>Événements</h3>
        <ul>
        <?php
        
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json")) {
            $dbraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
            $corrupted = false;
            if (isJson($dbraw)) {
                $events = json_decode($dbraw);
                foreach ($events->events as $event) {
                    if (isset($event->timestamp)) {
                        echo("<li><span style=\"cursor:help;\" title=\"" . $event->description . "\">" . $event->name . "</span> (" . $event->datestr . ")" . " - <a class=\"sblink\" href=\"/cms-special/admin/calendar/manage/?id=" . $event->timestamp . "\" title=\"Supprimer l'événément\">Gérer</a></li>");
                    }
                }
            } else {
                echo("<center style=\"color:red;\"><b><u>Important :</u> La base de données du calendrier semble corrompue. Si vous n'avez pas effectué d'actions particulières récemment, cela peut venir de corruption du disque ou d'une intrusion dans votre serveur. <u>Contactez votre administrateur réseau</u></b></center>");
                $corrupted = true;
            }
        } else {
            echo("<center>Aucun événement dans le calendrier pour le moment</center>");
        }

        ?>
        <?php
        
        if (!$corrupted) {
            echo('<br><li><i><a href="/cms-special/admin/calendar/add" title="Ajouter un nouvel événement au calendrier" class="sblink">Ajouter un nouvel événement</a></i></li>');
        }
        
        ?>
        </ul>
    </div>
</body>
</html>