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

function getAvgLuminance($filename, $num_samples=30) {
    // needs a mimetype check
    $img = imagecreatefromjpeg($filename);
    $width = imagesx($img);
    $height = imagesy($img);
    $x_step = intval($width/$num_samples);
    $y_step = intval($height/$num_samples);
    $total_lum = 0;
    $sample_no = 1;
    for ($x=0; $x<$width; $x+=$x_step) {
        for ($y=0; $y<$height; $y+=$y_step) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            // choose a simple luminance formula from here
            // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
            $lum = ($r+$r+$b+$g+$g+$g)/6;
            $total_lum += $lum;
            $sample_no++;
        }
    }
    // work out the average
    $avg_lum  = $total_lum / $sample_no;
    return ($avg_lum / 255) * 100;
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

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg")) {
    $banner = "/resources/upload/banner.jpg";
    if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/upload/banner.jpg") > 50) {
        $blackBannerText = true;
    } else {
        $blackBannerText = false;
    }
} else {
    $banner = "/resources/image/default.jpg";
    if (getAvgLuminance($_SERVER['DOCUMENT_ROOT'] . "/resources/image/default.jpg") > 50) {
        $blackBannerText = true;
    } else {
        $blackBannerText = false;
    }
}

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
    
    getData($_SERVER['DOCUMENT_ROOT']);
    $sizestr = $size . " octets";
    if ($size > 1024) {
        if ($size > 1048576) {
            if ($size > 1073741824) {
                $sizestr = round($size / 1073741824, 2) . " Gio";
            } else {
                $sizestr = round($size / 1048576, 2) . " Mio";
            }
        } else {
            $sizestr = round($size / 1024, 2) . " Kio";
        }
    } else {
        $sizestr = $size . " octets";
    }
    $sizestr = str_replace(".", ",", $sizestr);
    
    ?>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <center><table style="width:100%;"><tr><td style="width:50%;"><img style="float:right;" id="banner-logo" src="/resources/upload/siteicon.png"><td><td><span style="float:left;" id="adminb" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename") ?><br></span>MPCMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?> • <?= $sizestr ?></span></td></tr></table></center>
    </div>
        <a href="/cms-special/admin/logout" title="Terminer l'administration de votre site de manière sécurisée"><div class="setting"><table><tr><td><img src="/resources/image/admin_logout.png" class="setting-img"><td><td><b>Terminer la session</b><br>Terminez l'administration de votre site de manière sécurisée<br><code>/cms-special/admin/logout</code></td></tr></table><span class="setting-info"><p>Terminez de manière sécurisée l'administration de votre site, et vous déconnecte de manière sécurisée afin d'éviter que quelqu'un compromette votre session</p><p>Cela aura aussi pour effet de vous déconnecter de tous les autres sites à partir desquels vous êtes connectés</p></span></div></a>
        <a onclick="window.open('/?source=siteadmin')" title="Visiter votre site pour voir les changements appliqués"><div class="setting"><table><tr><td><img src="/resources/image/admin_tosite.png" class="setting-img"><td><td><b>Visiter le site</b><br>Visiter votre site pour voir les changements appliqués<br><code>/?source=siteadmin</code></td></tr></table><span class="setting-info"><p>Ouvrez votre site en tant que visiteur dans un nouvel onglet ou une nouvelle fenêtre.</p><p>Cela ne termine pas la session en cours</p></span></div></a>

        <hr style="border-width:1px;border-color:lightgray;border-bottom-style:none;">

        <a href="/cms-special/admin/appearance" title="Modifiez l'apparance de votre site et son comportement"><div class="setting"><table><tr><td><img src="/resources/image/admin_appearance.png" class="setting-img"><td><td><b>Apparance</b><br>Modifiez l'apparance de votre site et son comportement<br><code>/cms-special/admin/appearance</code></td></tr></table><span class="setting-info"><p>Modifiez les paramètres d'apparance de votre site facilement, comme l'îcone, la bannière, le nom, ou le pied de page</p><p>Cela permet aussi de modifier le mot de passe qui permet d'administrer votre site</p></span></div></a>
        <a href="/cms-special/admin/housekeeping" title="Supprimez, sauvegardez, ou désactivez votre site"><div class="setting"><table><tr><td><img src="/resources/image/admin_housekeeping.png" class="setting-img"><td><td><b>Maintenance</b><br>Supprimez, sauvegardez, ou désactivez votre site<br><code>/cms-special/admin/housekeeping</code></td></tr></table><span class="setting-info"><p>Réinitialisez facilement et directement votre site en cas de besoin</p><p>Vous pouvez choisir de conserver les données ou non. Tout supprimer supprimera toutes les données de votre site, alors que le choix de conserver les données supprimera toutes les informations de votre site excepté les pages et les îcones.</p></span></div></a>
        <a href="/cms-special/admin/pages" title="Gérez les pages de votre site, leur nom, et leur contenu"><div class="setting"><table><tr><td><img src="/resources/image/admin_pages.png" class="setting-img"><td><td><b>Pages</b><br>Gérez les pages de votre site, leur nom, et leur contenu<br><code>/cms-special/admin/pages</code></td></tr></table><span class="setting-info"><p>Modifiez/créez/supprimez les pages de votre site facilement, et visualisez la consommation d'espace disque de vos pages.</p><p>L'éditeur visuel vous permet de modifier vos pages sans avoir de connaissances en développement Web. Vous pouvez aussi utiliser l'éditeur HTML pour coder votre page manuellement afin d'avoir plus de choix.</p></span></div></a>
        <a href="/cms-special/admin/stats" title="Permet de visualiser les statistiques de votre site"><div class="setting"><table><tr><td><img src="/resources/image/stats.png" class="setting-img"><td><td><b>Statistiques</b><br>Permet de visualiser les statistiques de votre site<br><code>/cms-special/admin/stats</code></td></tr></table><span class="setting-info"><p>Permet de voir le nombre de visites sur votre site pour ce mois, ce jour, cette année, ou l'année dernière.</p><p>Vous voyez en haut de la page un graphique détaillant la proportion de visites sur votre site ce mois-ci.</p></span></div></a>
        <a href="/cms-special/admin/widgets" title="Personnalisez la barre des widgets présente sur votre site"><div class="setting"><table><tr><td><img src="/resources/image/admin_widgets.png" class="setting-img"><td><td><b>Barre des widgets</b><br>Personnalisez la barre des widgets présente sur votre site<br><code>/cms-special/admin/widgets</code></td></tr></table><span class="setting-info"><p>Les widgets sont des petits panneaux qui s'affichent partout sur votre site, dans une barre nommée Barre des widgets. Cette page est accessible via le bouton "Détails" sur n'importe quel page.</p><p>Certains widgets n'ajoutent pas de panneau à la Barre des widgets, mais modifient l'apparance ou le fonctionnement interne de votre site.</p></span></div></a>
        <a href="/cms-special/admin/logs" title="Déboggez facilement votre site et suivez son activité grâce aux fichier journal détaillés"><div class="setting"><table><tr><td><img src="/resources/image/admin_logs.png" class="setting-img"><td><td><b>Historique d'activité</b><br>Déboggez facilement votre site et suivez son activité grâce aux fichier journal détaillés<br><code>/cms-special/admin/logs</code></td></tr></table><span class="setting-info"><p>Diagnostiquez les problèmes avec votre site et surveillez les connexions à ce dernier facilement grâce à l'historique d'activité.</p><p>L'historique d'activité enregistre toutes les actions effectués sur votre site (connexions) ainsi que les différentes erreurs qui sont survenues au cours du chargement des pages.</p></span></div></a>
        <a href="/cms-special/admin/calendar" title="Modifier la configuration du widget &quot;Prochains événements&quot; en ajoutant/supprimant des événements du calendrier"><div class="setting"><table><tr><td><img src="/resources/image/admin_calendar.png" class="setting-img"><td><td><b>Calendrier</b><br>Modifier la configuration du widget &quot;Prochains événements&quot; en ajoutant/supprimant des événements du calendrier<br><code>/cms-special/admin/calendar</code></td></tr></table><span class="setting-info"><p>Le calendrier permet de prévenir vos visiteurs des prochains événements liés à votre site ou à son contenu (une réunion, une mise à jour, une maintenance, etc...).</p><p>Le widget du calendrier permet d'afficher les 3 prochains événements du calendrier, directement dans la Barre des widgets</p></span></div></a>
        <a href="/cms-special/admin/galery" title="Ajouter une page supplémentaire &quot;Galerie de photos&quot; à votre site pour exposer des photos"><div class="setting"><table><tr><td><img src="/resources/image/admin_galery.png" class="setting-img"><td><td><b>Calendrier</b><br>Ajouter une page supplémentaire &quot;Galerie de photos&quot; à votre site pour exposer des photos<br><code>/cms-special/admin/galery</code></td></tr></table><span class="setting-info"><p>La galerie de photo vous permet de publier des images relatives à votre site et/ou à certains événements, et de les classer dans des catégories.</p><p>En activant la galerie de photos, une page supplémentaire apparaîtra dans le menu de votre site et permettra de voir toutes les photos de votre site. Vous pouvez cliquez sur une image de la galerie pour la voir en plus grand</p></span></div></a>
        <a href="/cms-special/admin/updates" title="Rechercher des mises à jour et surveiller la sécurité de votre site"><div class="setting"><table><tr><td><img src="/resources/image/admin_updates.png" class="setting-img"><td><td><b>Mise à jour et sécurité</b><br>Rechercher des mises à jour et surveiller la sécurité de votre site<br><code>/cms-special/admin/updates</code></td></tr></table><span class="setting-info"><p>Voyez en un coup d'œil l'état de la sécurité de votre site.</p><p>Vous serez immédiatement prévenu si une nouvelle version de Minteck Projects CMS est disponible. Vous pouvez aussi avoir un aperçu de l'espace disque détaillé que prend votre site, classé dans différentes catégories.</p></span></div></a>
    </div>
</body>
</html>
