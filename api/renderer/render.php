<?php

function render(string $name) {
    if ($name == "index") {
        include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/homepage.php";
    } else {
        $MPCMSRendererPageNameValue = $name;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/init.php";
    }
}

function renderSpecial(string $markup, string $displayName = "Page") {
    $MPCMSRendererPageMarkup = $markup;
    $MPCMSRendererPageMarkupDN = $displayName;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/renderer/init.php";
}