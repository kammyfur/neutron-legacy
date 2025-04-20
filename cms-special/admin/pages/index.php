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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/pages" class="sblink">Pages</a></small></p>
        <h2>Gestion des pages</h2>
        Cliquez sur le nom d'une page pour la modifier, la renommer, ou la supprimer.
        <ul>
            <?php
            
            $pages = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/");
            $sizetotal = 0;
            foreach ($pages as $page) {
                if ($page != "." && $page != "..") {
                    $type = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/" . $page);
                        if ($type == "0") {
                            $typestr = "page classique";
                        }
                        if ($type == "1") {
                            $typestr = "page HTML";
                        }
                        $size = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $page);
                        if ($size > 1024) {
                            if ($size > 1048576) {
                                $sizestr = round($size / 1048576, 2) . " Mio";
                            } else {
                                $sizestr = round($size / 1024, 2) . " Kio";
                            }
                        } else {
                            $sizestr = $size . " octets";
                        }
                        $sizetotal = $sizetotal + $size;
                        $sizestr = str_replace(".", ",", $sizestr);
                    if ($page == "index") {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='Modifier/renommer/supprimer cette page'>Accueil</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    } else {
                        echo("<li><a href='/cms-special/admin/pages/manage/?slug={$page}' class='sblink' title='Modifier/renommer/supprimer cette page'>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a> ({$page}), {$typestr}, {$sizestr}</li>");
                    }
                }
            }
            if ($sizetotal > 1024) {
                if ($sizetotal > 1048576) {
                    if ($sizetotal > 1073741824) {
                        $sizestr = round($sizetotal / 1073741824, 2) . " gibioctets (Gio)";
                    } else {
                        $sizestr = round($sizetotal / 1048576, 2) . " mibioctets (Mio)";
                    }
                } else {
                    $sizestr = round($sizetotal / 1024, 2) . " kibioctets (Kio)";
                }
            } else {
                $sizestr = $size . " octets";
            }
            $sizestr = str_replace(".", ",", $sizestr);
            echo("<p><b>Espace disque total utilisé par votre site : {$sizestr}</b></p>");

            ?>
        </ul>
        <p><center><a href="/cms-special/admin/pages/add" class="button" title="Ajouter une nouvelle page à votre site">Créer une page</a></center></p>
    </div>
</body>
</html>