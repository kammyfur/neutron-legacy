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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/widgets" class="sblink">Barre des widgets</a></small></p>
        <h2>Aide</h2>
        MPCMS dispose d'une barre des widgets, qui vous permet d'afficher des widgets (sortes d'informations enrichies qui sont affichés à la suite)
        <h2>Widgets installés</h2>
        <?php

        $widgets = scandir($_SERVER['DOCUMENT_ROOT'] . "/widgets/");
        $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
        foreach ($widgets as $widget) {
            if ($widget != "." && $widget != "..") {
                echo("<div class=\"widget\"><div id=\"header-{$widget}\" class=\"widget-header ");
                if (array_search($widget, $json->list) === false) {
                    echo("disabled");
                } else {
                    echo("enabled");
                }
                echo("\"><input type=\"checkbox\" onclick=\"updateWidgetStatus('" . $widget . "')\" name=\"" . $widget . "\"");
                if (array_search($widget, $json->list) === false) {} else {
                    echo("checked");
                }
                echo("><label for=\"" . $widget . "\"><b>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/name") . "</b></label></div><p>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/description") . "</p>");
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config")) {
                    echo("<p><a href=\"" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/config") . "\" title=\"Modifier les paramètres dédiés au widget\" class=\"sblink\">Configurer...</a></p>");
                }
                echo("</div>");
            }
        }
        
        ?>
        
    </div>
</body>
</html>

<script>

function updateWidgetStatus(widget) {
    checkbox = document.getElementsByName(widget)[0]
    if (typeof checkbox == "undefined") {} else {
        if (checkbox.checked) {
            document.getElementById('header-' + widget).classList.remove('disabled');
            document.getElementById('header-' + widget).classList.add('enabled');
        } else {
            document.getElementById('header-' + widget).classList.remove('enabled');
            document.getElementById('header-' + widget).classList.add('disabled');
        }
        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})

        var formData = new FormData();
        formData.append("element", widget);
        formData.append("value", checkbox.checked.toString());
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/widgets.php",
            success: function (data) {
                if (data == "ok") {
                    console.log("Sauvegardé avec succès")
                    setTimeout(() => {
                        Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                    }, 500)
                } else {
                    alert("Erreur : " + data);
                }
            },
            error: function (error) {
                alert("Erreur de communication");
                window.onbeforeunload = undefined;
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });

    }
}

</script>