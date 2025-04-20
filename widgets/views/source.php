<div id="widget-space"><center>
    Vous êtes la <h2 style="margin:0;"><?php
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d"))) {
        (int)$count = trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/stats/" . date("Y-m-d")));
        if ($count < 3) {
            if ($count < 2) {
                echo($count . "ère");
            } else {
                echo($count . "nde");
            }
        } else {
            echo($count . "ème");
        }
    } else {
        echo("(erreur)");
    }
    
    ?></h2> personne à visiter ce site aujourd'hui
</center></div>