<div id="widget-space">
    <?php

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data")) {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-notes-data"));
    } else {
        echo("<center><i>Le widget n'a pas été configuré</i></center>");
    }

    ?>
</div>