<?php

function rrmdir($dir) { 
    if (is_dir($dir)) { 
      $objects = scandir($dir); 
      foreach ($objects as $object) { 
        if ($object != "." && $object != "..") { 
          if (is_dir($dir."/".$object))
            rrmdir($dir."/".$object);
          else
            unlink($dir."/".$object); 
        } 
      }
      rmdir($dir); 
    } 
  }

  if (isset($_COOKIE['ADMIN_TOKEN'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['ADMIN_TOKEN'])) {

    } else {
        die("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    die("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - API/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

sleep(2);

// die("API pas prêt");

if (isset($_POST['keep'])) {
    if ($_POST['keep'] == "1") {
        $keep = true;
    } else {
        $keep = false;
    }
} else {
    $keep = false;
}

if ($keep) {
    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
    copy($_SERVER['DOCUMENT_ROOT'] . "/resources/image/siteicon.png", $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json", '{"list":["test"],"settings":{"test":{"sampleSetting":"This is a sample setting"}}}');
    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer", "Réinitialisation terminée, accédez à l'administration du site pour modifier le pied de page");
    die("ok");
} else {
    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent");
    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
    $links = scandir($_SERVER['DOCUMENT_ROOT']);
    foreach ($links as $link) {
        if ($link != "." && $link != "..") {
            if (is_dir($_SERVER['DOCUMENT_ROOT'] . "/" . $link)) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $link . "/pagename")) {
                    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/" . $link);
                }
            }
        }
    }
    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/resources/upload");
    die("ok");
}