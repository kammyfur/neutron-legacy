<div id="widget-space">
    <?php

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data")) {
        $parts = explode('|', file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widget-contact-data"));
        echo("<table><tbody>");

        if (trim($parts[0]) != "") {
            echo("<tr><td style=\"vertical-align:middle;\"><img src=\"/resources/image/contact_phone.svg\" width=24px height=24px></td><td style=\"vertical-align:middle;\">" . $parts[0] . "</td></tr>");
        }

        if (trim($parts[1]) != "") {
            echo("<tr><td style=\"vertical-align:middle;\"><img src=\"/resources/image/contact_email.svg\" width=24px height=24px></td><td style=\"vertical-align:middle;\">" . $parts[1] . "</td></tr>");
        }

        if (trim($parts[2]) != "") {
            echo("<tr><td style=\"vertical-align:middle;\"><img src=\"/resources/image/contact_address.svg\" width=24px height=24px></td><td style=\"vertical-align:middle;\">" . $parts[2] . "</td></tr>");
        }

        if (trim($parts[3]) != "") {
            echo("<tr><td style=\"vertical-align:middle;\"><img src=\"/resources/image/contact_priority.svg\" width=24px height=24px></td><td style=\"vertical-align:middle;\">" . $parts[3] . "</td></tr>");
        }

        echo("</tbody></table>");
    } else {
        echo("<center><i>Le widget n'a pas été configuré</i></center>");
    }

    ?>
</div>