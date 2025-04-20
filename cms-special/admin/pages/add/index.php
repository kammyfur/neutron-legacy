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
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/translations/fr.js"></script>
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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/pages" class="sblink">Pages</a> &gt; <a href="/cms-special/admin/pages/add" class="sblink">Créer</a></small></p>
        <h2>Créer une page</h2>
            <p>
                <form name="settings">
                    <center><input id="name" type="text" placeholder="Nom de la page"></center><br>
                    <input type="radio" id="type-visual" value="visual" onchange="switchEditor()" name="type" checked>
                    <label for="type-visual">Classique</label><br>
                    <input type="radio" id="type" onchange="switchEditor()" value="html" name="type">
                    <label for="type-html">HTML <i>(avancé)</i></label>
                </form>
            </p>
            <div id="editing">Ajouter du contenu à votre page :<div id="editor-visual">
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/VisualEditor$2.php";
                ?></div>
                <div id="editor-html" class="hide">
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/CodeEditor$2.php" ?>
                </div>
            </div>
    <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    </div>
</body>
</html>

<script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les modifications non enregistrées sur cette page.";
    };
</script>

<script>

function createPageVisual() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "0");
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function createPageHTML() {
    Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = false})
    document.getElementById('loader').classList.remove('hide')
    document.getElementById('editing').classList.add('hide')
    var formData = new FormData();
    formData.append("title", document.getElementById('name').value);
    formData.append("type", "1");
    formData.append("content", document.getElementById('codeeditor').value);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/create_page.php",
        success: function (data) {
            if (data == "ok") {
                window.onbeforeunload = undefined;
                location.href = "/cms-special/admin/pages";
            } else {
                alert("Erreur : " + data)
                Array.from(document.getElementsByTagName('input')).forEach((el) => {el.disabled = true})
                document.getElementById('loader').classList.add('hide')
                document.getElementById('editing').classList.remove('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication")
            document.getElementById('loader').classList.add('hide')
            document.getElementById('editing').classList.remove('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function switchEditor() {
    if (document.forms['settings'].type.value == "visual") {
        document.getElementById('editor-visual').classList.remove('hide')
        document.getElementById('editor-html').classList.add('hide')
    } else {
        document.getElementById('editor-visual').classList.add('hide')
        document.getElementById('editor-html').classList.remove('hide')
    }
}

document.forms['settings'].type.value = "visual"

</script>