<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>

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
    <title>Réinitilisation du site - MPCMS</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php"; ?>
</head>
<body>
    <div id="settings" class="centered">
        <img src="/resources/image/resetted.png" height="64px" width="64px">
        <p>Réinitialisation du site terminée avec succès</p>
        <p><a href="/" class="button">Retourner à l'accueil</a></p>
    </div>
</body>
</html>