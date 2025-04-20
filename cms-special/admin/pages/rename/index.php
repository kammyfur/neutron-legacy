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

<?php

if (isset($_GET['slug'])) {
    $currentSlug = $_GET['slug'];
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)) {} else {
        die("<script>location.href = '/cms-special/admin/pages';</script>");
    }
} else {
    die("<script>location.href = '/cms-special/admin/pages';</script>");
}

if ($currentSlug == "index") {
    $currentName = "Accueil";
} else {
    $currentName = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $currentSlug . "/pagename");
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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/pages" class="sblink">Pages</a> &gt; <a href="/cms-special/admin/pages/manage/?slug=<?= $currentSlug ?>" class="sblink"><?= $currentName ?></a></small></p>
        <h2><?= $currentName ?></h2>
        <div id="confirm">
            <p>Vous allez renommer la page "<?= $currentName ?>". Tout lien pointant vers l'ancien nom de cette page reverra une page d'erreur...</p>
            <?php

            if ($currentSlug == "index") {
                die("<i>Vous ne pouvez pas renommer la page d'accueil de votre site</i></div></body></html>");
            }

            ?>
                <!-- <li>Ancien nom : <input id="oldname" placeholder="Erreur" value="<?= $currentName ?>" disabled></li>
                <li>Nouveau nom : <input id="newname" placeholder="Erreur" value="<?= $currentName ?>"></li> -->
            <table>
                <tbody>
                    <tr>
                        <td>Ancien nom : </td>
                        <td><input id="oldname" type="text" placeholder="Erreur" value="<?= $currentName ?>" disabled></td>
                    </tr>
                    <tr>
                        <td>Nouveau nom : </td>
                        <td><input id="newname" type="text" placeholder="Erreur" value="<?= $currentName ?>"></td>
                    </tr>
                </tbody>
            </table>
            <p><center><a class="button" onclick="renamePage()" title="Renommer la page">Renommer</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    </div>
</body>
</html>

<script>

function renamePage() {
    document.getElementById('confirm').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("page", "<?= $currentSlug ?>");
    formData.append("newname", document.getElementById('newname').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/rename_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages"
            } else {
                alert("Erreur : " + data);
                document.getElementById('confirm').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('confirm').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>