<?php

if (isset($_POST['category'])) {
    $category = trim($_POST['category']);
    $category = str_replace('>', '&gt;', $category);
    $category = str_replace('<', '&lt;', $category);
} else {
    die("Pas de nom donné");
}

$slug = preg_replace("/[^0-9a-zA-Z ]/m", "", $category );
$slug = str_replace(" ", "-", $slug);
$slug = strtolower($slug);

if ($slug == "unclassed") {
    die("Vous ne pouvez pas utiliser un nom réservé par le système");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug)) {
    die("Une catégorie du même nom ou d'un nom similaire existe déjà");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/galery/categories/" . $slug, $category);
    die("ok");
}