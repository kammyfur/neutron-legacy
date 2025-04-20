<?php echo("<!--\n\n" . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/resources/private/license") . "\n\n-->") ?>
<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    $ready = true;
} else {
    $ready = false;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/setup.css">
    <link rel="stylesheet" href="/resources/css/fonts-import.css">
    <link rel="stylesheet" href="/resources/css/ui.css">
    <title><?php
    
    if ($ready) {
        echo("Configuration - " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename"));
    } else {
        echo("Configuration - MPCMS");
    }

    ?></title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/resources/private/header.php" ?>
</head>
<body>
    <?php
    
    if ($ready) {
        // Si le site est prêt, faire le rendu et s'arrêter là
        die("<script>location.href = '/';</script></body></html>");
    }

    ?>
    <script>
    window.onbeforeunload = function (e) {
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        e.returnValue = "En quittant cette page, vous perdrez les paramètres de configuration actuels.";
    }

        // For Safari
        return "En quittant cette page, vous perdrez les paramètres de configuration actuels.";
    };
    </script>
    <div class="centered box hide" id="00-error">
        <h2 id="00-error-title">Une erreur s'est produite</h2>
        <span id="00-error-message">Erreur inconnue</span><br><br>
        <img src="/resources/image/config_restart.svg" onclick="location.reload()" class="icon_button"><br><small>Relancer la configuration</small>
    </div>
    <div class="centered box" id="01-loader">
        <h2>Préparation</h2>
        <img src="/resources/image/loader.svg" class="loader">
    </div>
    <div class="centered box hide" id="02-check">
        <h2>Vérification de votre environnement</h2>
        <img src="/resources/image/loader.svg" class="loader">
    </div>
    <div class="centered box hide" id="03-welcome">
        <h2>Bienvenue !</h2>
        <p>Merci d'avoir choisi Minteck Projects CMS pour votre site Internet, nous apprécions votre soutien.</p>
        <p>La première étape dans la mise en marche de votre site Internet est de le configurer en choisissant parmi un large choix de paramètres disponibles.</p>
        <p>Tous ces paramètres sont modifiables dans le futur à partir du Tableau de bord de votre site, et certains sont même facultatifs.</p>
        <p>Si vous avez besoin de recommencer la configuration depuis le début ou que vous avez mal configuré quelque chose, vous pouvez recharger la page. Tant que vous ne cliquez pas sur le bouton "Terminer", aucun changement n'est appliqué sur le serveur.</p>
        <img src="/resources/image/config_next.svg" onclick="document.getElementById('03-welcome').classList.add('hide');document.getElementById('04-name').classList.remove('hide');" class="icon_button"><br><small>Commencer</small>
    </div>
    <div class="centered box hide" id="04-name">
        <h2>Votre site</h2>
        <p>Choisissez un nom pour votre site Internet</p>
        <p>Si vous ne savez pas quoi choisir, choisissez un nom court, facile à retenir, et qui définit bien le contenu que vous allez poster sur votre site</p>
        <input id="04-name-field" type="text" onchange="validateName()" onkeyup="validateName()" onkeydown="validateName()" placeholder="Nom de votre site"><br><p id="04-name-tip" class="tip-red">Le nom ne peut pas être vide</p>
        <img src="/resources/image/config_next.svg" onclick="Name_ChangeIfOk()" class="icon_button"><br><small>Suivant</small>
    </div>
    <div class="centered box hide" id="05-icon">
        <h2>Identité graphique</h2>
        <p>Importez une îcone pour votre site</p>
        <p>Vous pouvez ne pas importer d'îcone, ce qui affichera l'îcone par défaut</p>
        <input id="05-icon-file" type="file" onchange="Icon_Validate()" style="display:none;width:0;height:0;left:0;top:0;"><img id="05-icon-img" src="/resources/image/config_file_import.svg" onclick="Icon_UploadFile()" class="icon_button"><br><small>Importer un fichier</small><br><br>
        <img src="/resources/image/config_next.svg" onclick="document.getElementById('05-icon').classList.add('hide');document.getElementById('06-terms').classList.remove('hide');" class="icon_button"><br><small>Suivant</small>
    </div>
    <div class="centered box hide" id="06-terms">
        <h2>Contrat de licence</h2>
        <p>Vous devez accepter le suivant contrat de licence avant de commencer à utiliser Minteck Projects CMS</p>
        <iframe class="termsbox" src="https://www.gnu.org/licenses/gpl-3.0-standalone.html" style="width:100%;"></iframe><br><br>
        <img src="/resources/image/config_next.svg" onclick="document.getElementById('06-terms').classList.add('hide');document.getElementById('07-finish').classList.remove('hide');" class="icon_button"><br><small>J'accepte</small>
    </div>
    <div class="centered box hide" id="07-finish">
        <h2>Confirmation</h2>
        <p>Vous avez terminé la configuration de départ de Minteck Projects CMS, les informations vont maintenant être transmises au serveur.</p>
        <p>Cette action ne pourra pas être annulée, et peut prendre plusieurs minutes selon la vitesse de votre serveur. Cela inclut une verification des informations entrées, l'envoi des informations, la verification des informations envoyées, et un test des performances du serveur.</p>
        <img src="/resources/image/config_finish.svg" onclick="upload()" class="icon_button"><br><small>Terminer</small>
    </div>
    <div class="centered box hide" id="08-checking">
        <h2>Vérification des informations</h2>
        <img src="/resources/image/config_uploading_check.svg" class="finisher loadblink"><br><br><small>Ne quittez pas cette page<br>Cela peut prendre plusieurs minutes</small>
    </div>
    <div class="centered box hide" id="09-uploading">
        <h2>Envoi des informations</h2>
        <img src="/resources/image/config_uploading_data.svg" class="finisher loadblink"><br><br><small>Ne quittez pas cette page<br>Cela peut prendre plusieurs minutes</small>
    </div>
    <div class="centered box hide" id="10-summing">
        <h2>Validation des informations envoyées</h2>
        <img src="/resources/image/config_uploading_summing.svg" class="finisher loadblink"><br><br><small>Ne quittez pas cette page<br>Cela peut prendre plusieurs minutes</small>
    </div>
    <div class="centered box hide" id="11-performance">
        <h2>Test des performances du serveur</h2>
        <img src="/resources/image/config_uploading_performance.svg" class="finisher loadblink"><br><br><small>Ne quittez pas cette page<br>Cela peut prendre plusieurs minutes</small>
    </div>
    <div class="centered box hide" id="12-done">
        <h2>Terminé</h2>
        <p>Votre site à maintenant été créé, et est prêt à être visité par des personnes.</p>
        <p>Pour modifier son contenu et/ou ses paramètres, vous devez vous connecter à l'interface d'administration. Le mot de passe est <b>MPCMS-usr-motdepasse</b>. Pensez à le modifier !</p>
        <img src="/resources/image/config_explore.svg" onclick="location.href = '/'" class="icon_button"><br><small>Explorer</small>
    </div>
    <script src="/resources/js/setup-ui.js"></script>
</body>
</html>