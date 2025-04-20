<script src="/resources/js/jquery.js"></script>

<?php

//
// Tout le code inséré ici affectera TOUTES LES PAGES du site, incluant les pages d'administration
//

function errors($level, $description, $file, $line) {
    if ($level == E_USER_ERROR) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/ERROR - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_WARNING) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/WARNING - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level == E_USER_NOTICE) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/NOTICE - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    if ($level != E_USER_NOTICE && $level != E_USER_ERROR && $level != E_USER_WARNING) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - PHP-INTERNAL-ERROR/UNKNOWN - " . $file . ":" . $line . " - " . $description . "\n\n");
        }
    }
    echo("<p class=\"php-internal-error\">Une erreur s'est produite lors de l'initialisation de cette page, au niveau de cet emplacement, nous vous conseillons de contacter l'administrateur du site Web. Si vous êtes l'administrateur du site Web, vous pouvez consulter les fichiers journaux. Cherchez un message du type <code>PHP-INTERNAL-ERROR/*</code></p>");
    return true;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    set_error_handler("errors");
} else {
    return;
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - INTERFACE/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

try {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats")) {} else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats");
        }
    }
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/")) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"))) {
            (int)$actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"));
            $actual = $actual + 1;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), $actual);
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"), "1");
        }
    }
} catch (E_WARNING $err) {
}

// file_get_contents("unexistingfile");

?>

<div id="snowapi-placeholder"><div snowapi-enable-snowfall></div></div>
<?= "<script>" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/global.js") . "</script>" ?>