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
    
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery")) {
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery");
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
    }

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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/galery" class="sblink">Galerie de photos</a></small></p>
        <center><h4>État global</h4><input type="checkbox" id="state" onchange="changeState()" <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/enabled")) {echo("checked");} ?>><label for="state">Activer la galerie de photos</label></center>
        <h2>Galerie de photos</h2>
        <h3>Catégories</h3>
        <ul>
            <li><?php
            
            $count = 0;
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    $count = $count + 1;
                }
            }
            if ($count != 0) {
                echo($count);
            } else {
                echo("Aucune");
            }

            ?> catégorie<?php if ($count > 1) {echo("s");} ?> - <?php
            
            $count = 0;
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    $count = $count + 1;
                }
            }
            if ($count != 0) {
                echo($count);
            } else {
                echo("Aucune");
            }

            ?> photo<?php if ($count > 1) {echo("s");} ?></li>
            <li><a class="sblink" href="/cms-special/admin/galery/addcategory">Créer une nouvelle catégorie</a></li>
        </ul>
        <h3>Catégories</h3>
        <i>Une catégorie créée ne peut pas être modifiée ou supprimée. Pour vraiment supprimer cette catégorie, contactez votre administrateur réseau.</i>
        <ul>
            <?php
            
            $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories");
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    echo("<li>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $el) . "</li>");
                }
            }

            ?>
        </ul>
        <h3>Photos</h3>
        <ul>
        <?php
        
        $count = 0;
        $dirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures");
        foreach ($dirs as $el) {
            if ($el == "." || $el == "..") {} else {
                $count = $count + 1;
            }
        }
        if ($count == 0) {
            echo("<i>Aucune photo n'a été ajoutée à la galerie de photos.</i><p><a class=\"sblink\" href=\"/cms-special/admin/galery/publish\">Publier une nouvelle photo</a></p>");
        } else {
            foreach ($dirs as $el) {
                if ($el == "." || $el == "..") {} else {
                    echo("<li><i>" . $el ."</i>, ");
                    if (explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[1] == "unclassed") {
                        echo("Non classé");
                    } else {
                        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[1]));
                    }
                    echo(", <a href=\"" . explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/pictures/" . $el))[0] . "\" class=\"sblink\" download>Télécharger</a> - <a onclick=\"confirmDelete('$el')\" class=\"sblink\">Supprimer</a></li>");
                }
            }
        }

        ?>
        </ul>
    </div>
</body>
</html>

<script>

function confirmDelete(id) {
    if (confirm('Vous allez supprimer cette image et la dépublier du site.\nCette action est irréversible et l\'image ne pourra pas être récupérée...')) {
        $('body').fadeOut(200)
        document.title = "Suppression de l'image..."
        var formData = new FormData();
        formData.append("id", id);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/admin/galery_delete_image.php",
            success: function (data) {
                if (data == "ok") {
                    location.reload()
                } else {
                    alert("Erreur : " + data)
                    location.reload()
                }
            },
            error: function (error) {
                alert("Erreur de communication")
                location.reload()
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }
}

function changeState() {
    document.getElementById('state').disabled = true;
    var formData = new FormData();
    if (document.getElementById('state').checked) {
        formData.append("state", "1");
    } else {
        formData.append("state", "0");
    }
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/galery_toggle_state.php",
        success: function (data) {
            if (data == "ok") {
                document.getElementById('state').disabled = false;
            } else {
                alert("Erreur : " + data)
                document.getElementById('state').disabled = false;
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('state').disabled = false;
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>