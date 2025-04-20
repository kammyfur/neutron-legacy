<?php

if (isset($MPCMSRendererPageMarkup)) {
    $pagename = $MPCMSRendererPageMarkupDN;
} else {
    $pagename = $MPCMSRendererPageNameValue;
}
$ready = true;

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

?>
<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {} else {
    die("<script>location.href = '/';</script>");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php

    if ($ready) {
        echo('<link rel="stylesheet" href="/resources/css/main.css">');
        echo('<link rel="stylesheet" href="/resources/lib/pushbar.js/library.css">');
        echo('<script src="/resources/lib/pushbar.js/library.js"></script>');
        echo('<link rel="shortcut icon" href="/resources/upload/siteicon.png" type="image/png">');
    } else {
        echo('<link rel="stylesheet" href="/resources/css/ready.css">');
    }

    ?>
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if (isset($MPCMSRendererPageMarkup)) {
        echo($MPCMSRendererPageMarkupDN . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $pagename . "/pagename") . " - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    }

    ?></title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php" ?>
</head>
<body>
    <?php

    echo("<script type=\"text/javascript\">\nvar pushbar = new Pushbar({\nblur:true,\noverlay:true,\n});\n</script>");
    

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

    ?>
    <div id="always-on-top">
        <div id="siteadmin"><span class="branding-desktop">fonctionne sur Minteck Projects CMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?></span><span class="branding-mobile">MPCMS <?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version") ?></span><a href="/cms-special/admin" id="siteadmin-button"><img id="siteadmin-img" src="/resources/image/admin.svg">Administration du site</a></div>
        <div id="menubar"><span class="menubar-link" id="menubar-link-navigation" onclick="pushbar.open('panel-navigation')"><img src="/resources/image/menu.svg" class="menubar-img"><span class="menubar-link-text">Menu</span></span>
        <?php

        $widgets = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
        if (!empty($widgets->list)) {
            echo("<span class=\"menubar-link\" id=\"menubar-link-tools\" onclick=\"pushbar.open('panel-sidebar')\"><img src=\"/resources/image/tools.svg\" class=\"menubar-img\"><span class=\"menubar-link-text\">Détails</span></span>");
        }

        ?>
        </div>
    </div>
    <div id="banner" style='background-image: url("<?= $banner ?>");'>
        <img id="banner-logo" src="/resources/upload/siteicon.png"><span id="banner-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?php
        
        if (isset($MPCMSRendererPageMarkup)) {
            echo($MPCMSRendererPageMarkupDN);
        } else {
            echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $pagename . "/pagename"));
        }

        ?></span>
    </div>
    <div data-pushbar-id="panel-navigation" class="pushbar from_left">
        <div id="banner-menu" style='background-image: url("<?= $banner ?>");'>
            <img id="banner-menu-logo" src="/resources/upload/siteicon.png"><span id="banner-menu-name" <?php if ($blackBannerText) {echo("class=\"banner-black\"");} ?>><?php
            
            $sitename = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename");

            if (strlen($sitename) < 15) {
                echo($sitename);
            } else {
                echo(substr($sitename, 0, 14) . "...");
            }
            
            ?></span>
        </div>
        <img src="/resources/image/close.svg" id="menubar-close" onclick="pushbar.close()">
        <br>
        <a href="/" title="/" class="menu-link">Accueil</a>
        <?php

        $pages = scandir($_SERVER['DOCUMENT_ROOT']);
        foreach ($pages as $page) {
            if ($page != ".." && $page != ".") {
                if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $page)) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename")) {
                        echo("<a href=\"/{$page}\" title=\"/{$page}\" class=\"menu-link\">" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $page . "/pagename") . "</a>");
                    }
                }
            }
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {echo("<a href=\"/cms-special/galery\" title=\"/cms-special/galery\" class=\"menu-link\">Galerie de photos</a>");}

        ?>
	</div>
	<div data-pushbar-id="panel-sidebar" class="pushbar from_right">
        <img src="/resources/image/close.svg" id="sidebar-close" onclick="pushbar.close()">
        <span id="sidebar-title">Détails du site</span>
        <span id="sidebar-separator"></span>
        <span id="sidebar-widgets">
            <?php
                $config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
                foreach ($config->list as $widget) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php")) {
                        include_once $_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php";
                    }
                }
            ?>
        </span>
	</div>
    <div id="page-placeholder">
        <div id="page-content">
            <?php
            
            if (isset($MPCMSRendererPageMarkup)) {
                echo($MPCMSRendererPageMarkup);
            } else {
                echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $pagename));
            }
            
            ?>
        </div>
        <div id="page-footer">
        <?php echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer")); ?>
        </div>
    </div>
</body>
</html>