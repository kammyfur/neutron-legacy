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

$size = 0;

function getData(string $dir, $ignoreUploadDir = false) {
    global $size;
    $dircontent = scandir($dir);
    foreach ($dircontent as $direl) {
        if ($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) {} else {
            if ($direl == "." || $direl == "..") {} else {
                if (is_link($dir . "/" . $direl)) {} else {
                    if (is_dir($dir . "/" . $direl)) {
                        getData($dir . "/" . $direl);
                    } else {
                        $size = $size + filesize($dir . "/" . $direl);
                    }
                }
            }
        }
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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/housekeeping" class="sblink">Mise à jour et sécurité</a></small></p>
        <h3>État global</h3>
        <?php

        $currentVersion = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version");
        $latestVersion = file_get_contents("https://mpcms-cdn.000webhostapp.com/latest_version");

        if (version_compare($currentVersion, $latestVersion) >= 1) {
            echo("<div id=\"protect\" class=\"s1\"><b>Votre site est potentiellement vulnérable</b><br>Vous utilisez une préversion de Minteck Projects CMS</div>");
        }
        
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("<div id=\"protect\" class=\"s0\"><b>Votre site n'est pas protégé</b><br>Une mise à jour pour Minteck Projects CMS est disponible</div>");
        }
        
        if (version_compare($currentVersion, $latestVersion) == 0) {
            echo("<div id=\"protect\" class=\"s2\"><b>Votre site est protégé</b><br>Minteck Projects CMS est à jour</div><br>");
        }

        ?>
    </div>
    <h3>Statistiques</h3>
    <ul><li>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
        echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>");
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>, et la dernière version disponible est la version <b>" . $latestVersion . "</b>");
        } else {
            echo("Votre serveur exécute Minteck Projects CMS version <b>" . $currentVersion . "</b>, et la dernière version stable en circulation est la version <b>" . $latestVersion . "</b>");
        }
    }
    echo("</li>");

    getData($_SERVER['DOCUMENT_ROOT']);
    $sizestr = $size . " octets";
    if ($size > 1024) {
        if ($size > 1048576) {
            if ($size > 1073741824) {
                $sizestr = round($size / 1073741824, 3) . " gibioctets";
            } else {
                $sizestr = round($size / 1048576, 3) . " mibioctets";
            }
        } else {
            $sizestr = round($size / 1024, 3) . " kibioctets";
        }
    } else {
        $sizestr = $size . " octets";
    }

    $sizestr = str_replace(".", ",", $sizestr);
    
    echo("<li>Votre site utilise <b>" . $sizestr . "</b> d'espace disque</li>");

    ?>
    </ul>
    <h3>Espace disque</h3>
    <meter id="storagebar" value="0" max="1" title="Espace disque utilisé"></meter>
    <span style="margin-left: 10px;"></span>
    <?php
    
    $globalSize = $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/api");
    $mpcmsSize = $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/cms-special");
    $mpcmsSize = $mpcmsSize + $size;
    getData($_SERVER['DOCUMENT_ROOT'] . "/widgets");
    $mpcmsSize = $mpcmsSize + $size;

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/data");
    $dataSize = $size;

    $calSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    $confSize = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password") + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
        $confSize = $confSize + filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data");
    }

    $size = 0;
    getData($_SERVER['DOCUMENT_ROOT'] . "/resources");
    $resSize = $size;
    
    ?>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#8bcf69;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Minteck Projects CMS (<?= round(($mpcmsSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#e6d450;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Pages, configuration et calendrier (<?= round(($dataSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#cf82bf;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Galerie de photos et ressources (<?= round(($resSize*100)/$globalSize, 2) ?>%)</span>
    <span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:gray;position:relative;width:15px;height:15px;display:inline-block;"></span><span style="margin-right:30px;">Autre</span>
    <!-- <?= $globalSize - ($mpcmsSize + $dataSize + $resSize) ?>
    <?= "<br>" ?>
    <?= (($mpcmsSize + $dataSize + $resSize) * 100)/$globalSize ?> -->
    <style>
        #storagebar {
            width: 100%; /* To support legacy browsers */
            width: calc(100% - 16px);
            margin: 8px;
            border-radius: 5px;
            box-shadow: 0 5px 5px -5px #999 inset;
            background-image: linear-gradient(
                90deg, 
                #8bcf69 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%, 
                #e6d450 <?= round(($mpcmsSize*100)/$globalSize, 2) ?>%,
                #e6d450 <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($dataSize*100)/$globalSize, 2) ?>%,
                #cf82bf <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray <?= round(($resSize*100)/$globalSize, 2) ?>%,
                gray 100%
                /* #719fd1 95%,
                #719fd1 100% */
            );
            background-size: 100% 100%;
        }
    </style>
    <h4>Légende</h4>
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#8bcf69;position:relative;width:15px;height:15px;display:inline-block;"></span>Minteck Projects CMS</h5>
    Fichiers critiques pour le bon fonctionnement du logiciel Minteck Projects CMS. Si un de ces fichiers est supprimé, Minteck Projects CMS ou une partie du logiciel peut ne plus fonctionner correctement.
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#e6d450;position:relative;width:15px;height:15px;display:inline-block;"></span>Pages, configuration et calendrier</h5>
    Fichiers spécifiques à votre site contenant les informations de ce dernier (les widgets activés, le calendrier, les différentes pages, etc...). Ces fichiers ne sont pas critiques pour le bon fonctionnement de Minteck Projects CMS, mais requis pour le bon fonctionnement de votre site. Vous pouvez les supprimer via l'option de <a href="/cms-special/admin/housekeeping/reset" class="sblink" title="Lien vers : Administration > Maintenance > Réinitiliser">Réinitialisation</a> du site.
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:#cf82bf;position:relative;width:15px;height:15px;display:inline-block;"></span>Galerie de photos et ressources</h5>
    Fichiers requis pour l'interface graphique de Minteck Projects CMS et pour la galerie de photos. Ces fichiers incluent notament les différentes polices de caractères, les définitions de l'apparance, les îcones, les librairies utilisées, le code de l'éditeur, la licence, et les définitions de code partagé. Les images utilisateur (dans le dossier <code>/resources/upload</code>) sont des images que vous avez vous-même importé sur votre site (logo du site, bannière, photos de la galerie de photos)
    <h5><span style="margin-right:5px;border-radius:999px;vertical-align:middle;background-color:gray;position:relative;width:15px;height:15px;display:inline-block;"></span>Autre</h5>
    Fichiers non classés par Minteck Projects CMS qui peuvent être plus ou moins critiques. Si vous avez l'intention de supprimer l'un d'entre eux, préférez contacter les développeurs avant toute manipulation.
    <h3>Changements</h3>
    <h4>Version actuelle (<?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?>)</h4>
    <?php
    
    try {
        echo(file_get_contents("https://mpcms-cdn.000webhostapp.com/changelog/" . $currentVersion));
    } catch (Notice $err) {
        echo("<i>Aucune information concernant votre version de Minteck Projects CMS</i>");
    }
    
    ?>
    <?php

    if (version_compare($currentVersion, $latestVersion) == 0) {
    } else {
        if (version_compare($currentVersion, $latestVersion) <= -1) {
            echo("<h4>Dernière version stable (" . $latestVersion . ")</h4>");
        } else {
            echo("<h4>Version stable en circulation (" . $latestVersion . ")</h4>");
        }
        try {
            echo(file_get_contents("https://mpcms-cdn.000webhostapp.com/changelog/" . $latestVersion));
        } catch (Notice $err) {
            echo("<i>Aucune information concernant la dernière version de Minteck Projects CMS</i>");
        }
    }

    ?>
</body>
</html>