<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - DEMO-DEBUGINFO/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - DEMO-DEBUGINFO/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

?>

<?php phpinfo(); ?>