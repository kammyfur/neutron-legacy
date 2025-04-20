<?php

// die("It works!");

if (substr($_SERVER['SERVER_PROTOCOL'], 0, 4) != "HTTP") {
    die("Le protocole de transmission utilisé n'est pas supporté");
}

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    die("La méthode de requête n'est pas supportée par ce type de requête à l'API");
}

if ($_SERVER['SCRIPT_NAME'] != "/api/setup/check.php") {
    die("L'API n'est pas installé correctement");
}

if (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false) {} else {
    die("Le navigateur ne supporte pas le type de pages web utilisé par le logiciel");
}

ob_start();
phpinfo();
$data = ob_get_contents();
ob_clean();
if (strpos($data, '<tr><td class="e">GD Support </td><td class="v">enabled </td></tr>') !== false) {} else {
    die("La librairie GD2 n'est pas installée ou activée sur ce serveur");
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {} else {
    die("Votre navigateur n'est pas supporté, merci d'utiliser Firefox ou un autre navigateur récent et mis à jour");
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iOS') !== false) {
    die("Vous ne pouvez pas configurer le logiciel depuis un téléphone mobile, merci de passer par un ordinateur");
}

die("ok");