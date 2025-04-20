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
        <p class="place-bar"><small><a href="/cms-special/admin/home" class="sblink">Administration</a> &gt; <a href="/cms-special/admin/widgets" class="sblink">Barre des widgets</a> &gt; <a href="/cms-special/admin/widgets/widget-notes-configure" class="sblink"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/notes/name") ?></a></small></p>
        <h2>Paramètres du widget</h2>
        <p>Entrez le texte qui devra être affiché dans la barre des widgets. L'édition "inline" uniquement est supportée (pas de titres, tableaux, etc...).</p>
        <div id="data">
        <textarea name="content" id="editor">
                <?php
                
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
                    echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data"));
                }
                
                ?>
            </textarea><br>
            <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
                },
                toolbar: [
                    'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ]
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
            <p><center><a class="button" onclick="saveChanges()" title="Sauvegarder la configuration du widget">Sauvegarder</a></center></p>
        </div>
        <div class="hide" id="loader"><center><img src="/resources/image/loader.svg" class="loader"></center></div>
    </div>
</body>
</html>

<script>

function saveChanges() {
    document.getElementById('data').classList.add('hide')
    document.getElementById('loader').classList.remove('hide')
    var formData = new FormData();
    formData.append("content", editor.getData());
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "/api/admin/widget-notes-configure.php",
        success: function (data) {
            if (data == "ok") {
                location.href = "/cms-special/admin/widgets"
            } else {
                alert("Erreur : " + data);
                document.getElementById('data').classList.remove('hide')
                document.getElementById('loader').classList.add('hide')
            }
        },
        error: function (error) {
            alert("Erreur de communication");
            document.getElementById('data').classList.remove('hide')
            document.getElementById('loader').classList.add('hide')
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

</script>