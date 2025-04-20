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
        <?php
        
        $eventsraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
        if (isset($_GET['id'])) {} else {
            die("<script>location.href = '/cms-special/admin/calendar';</script>");
        }
        if (isJson($eventsraw)) {
            $events = json_decode($eventsraw);
            foreach ($events->events as $element) {
                if (isset($element->timestamp)) {
                    if ($element->timestamp == $_GET['id']) {
                        $event = $element;
                    }
                }
            }
        } else {
            die("<script>location.href = '/cms-special/admin/calendar';</script>");
        }
        if (!isset($event)) {
            die("<script>location.href = '/cms-special/admin/calendar';</script>");
        }

        ?>
        <h1><center>Administration du site</center></h1><center><a class="sblink" href="/cms-special/admin/logout" title="Terminer la session de manière sécurisée et retourner à l'écran de connexion">Terminer la session</a></center>
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/calendar" class="sblink">Calendrier</a> &gt; <a href="/cms-special/admin/calendar/manage/?id=<?= $event->timestamp ?>" class="sblink"><?= $event->name ?></a></small></p>
        <h2>Supprimer un événement</h2>
        <h3>Informations sur l'événement</h3>
        <ul>
            <li><b><?= $event->name ?></b></li>
            <li><i><?= $event->description ?></i></li>
            <li><?= $event->datestr ?> (<code><?= $event->timestamp ?></code>)</li>
        </ul>
        <h3>Supprimer l'événement ?</h3>
        <ul id="delete">
            <li><a class="sblink" href="/cms-special/admin/calendar" title="Ne pas supprimer l'événement sélectionné">Non</a></li>
            <li><a class="sblink" onclick="deleteEvent()" title="Supprimer l'événement sélectionné">Oui</a></li>
        </ul>
    </div>
</body>
</html>

<script>

function deleteEvent() {
    document.getElementById('delete').classList.add('hide')
    var formData = new FormData();
    formData.append("id", <?= $event->timestamp ?>);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/calendar_delete.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/calendar";
            } else {
                alert("Erreur : " + data + "\n\nLa base de données du calendrier est peut être corrompue")
                document.getElementById('delete').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication\n\nRien a été modifié dans le calendrier")
            document.getElementById('delete').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>