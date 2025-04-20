<!DOCTYPE html>
<html lang="en" style="height:100%;overflow:hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/preview.css">
    <title>Prévisualisation de l'image</title>
</head>
<?php
    
    if (isset($_GET['url'])) {
    } else {
        die("Pas d'image");
    }
    
?>
<body style="background-image:url('<?= $_GET['url'] ?>');background-size:contain;background-position:center;height: 100%;margin: 0;background-repeat: no-repeat;background-color: #222;">
    <img src="/resources/image/close.svg" onclick="history.back()">
</body>
</html>