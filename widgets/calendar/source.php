<?php

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

?>

<div id="widget-space">
    <ul>
    <?php

    $jsonraw = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json");
    if (isJson($jsonraw)) {
        $json = json_decode($jsonraw);
        $eventlist = [];
        foreach ($json->events as $event) {
            if (isset($event->timestamp)) {
                array_push($eventlist, $event->timestamp);
            }
        }
        sort($eventlist);
        $pos = 1;
        $shown = 0;
        foreach ($eventlist as $event) {
            if ($pos == 4) {} else {
                foreach ($json->events as $el) {
                    if ($el->timestamp == $event) {
                        (int)$currentDate = date("Ymd");
                        // (int)$currentDate = "20191001";
                        if ($currentDate < $el->timestamp) {
                            $shown = $shown + 1;
                            echo("<li><b>" . $el->datestr . "</b> : " . $el->name . "</li><i>" . $el->description . "</i><br><br>");
                            $pos = $pos + 1;
                        }
                        if ($currentDate == $el->timestamp) {
                            $shown = $shown + 1;
                            echo("<li><b>Aujourd'hui</b> : " . $el->name . "</li><i>" . $el->description . "</i><br><br>");
                            $pos = $pos + 1;
                        }
                    }
                }
            }
        }
        if ($shown == "0") {
            echo("</ul><center><i>Aucun événement à venir</i></center>");
        }
    } else {
        echo("<b>Base de données du calendrier corrompue</b>");
    }

    ?>
    </ul>
</div>