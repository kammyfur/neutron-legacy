<?php

// var_dump($_FILES);
// var_dump($_GET);
// var_dump($_POST);
// exit;

// var_dump($_POST['sitename']);
// exit;

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    die("La configuration du site Web à déjà été effectuée, vous devez le réinitialiser pour relancer la configurer");
}

if (isset($_POST['sitename'])) {
    if (trim($_POST['sitename']) == "") {
        die("Le nom du site ne peut pas être vide");
    }
    if (strpos($_POST['sitename'], '<') !== false || strpos($_POST['sitename'], '>') !== false || strpos($_POST['sitename'], '{') !== false || strpos($_POST['sitename'], '}') !== false || strpos($_POST['sitename'], '@') !== false || strpos($_POST['sitename'], '#') !== false || strpos($_POST['sitename'], '|') !== false) {
        die("Le nom du site contient des caractères invalides");
    }
    if (strlen($_POST['sitename']) > 75) {
        die("Le nom du site est trop long");
    }
} else {
    die("Aucun nom n'a été spécifié pour le site");
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['error'] == 1) {
        $maxsize = ini_get('upload_max_filesize');
        if ($maxsize > 1000) {
            if ($maxsize > 1000000) {
                $maxsizestr = round($maxsize / 1000000, 2) . " Mio";
            } else {
                $maxsizestr = round($maxsize / 1000, 2) . " Kio";
            }
        } else {
            $maxsizestr = $maxsize . " octets";
        }
        die("La taille du fichier d'îcone dépasse la taille maximale imposée par le serveur ({$maxsizestr})");
    }
    if ($_FILES['file']['error'] == 2) {
        die("La taille maximale du fichier de formulaire à été dépassée");
    }
    if ($_FILES['file']['error'] == 3) {
        die("Le fichier d'îcone est incomplet (n'a pas été transmis entièrement)");
    }
    if ($_FILES['file']['error'] == 4) {
        die("Le fichier est renseigné au serveur, mais il n'a pas été transmis");
    }
    if ($_FILES['file']['error'] == 6) {
        die("Aucun dossier temporaire présent sur le serveur");
    }
    if ($_FILES['file']['error'] == 7) {
        die("Impossible d'écrire sur le disque");
    }
    if ($_FILES['file']['error'] == 8) {
        die("Un autre programme à interrompu la transmission du fichier");
    }
    if ($_FILES['file']['type'] != "image/png" && $_FILES['file']['type'] != "image/jpeg" && $_FILES['file']['type'] != "image/gif") {
        die("Ce type de fichier n'est pas supporté");
    }
    if ($_FILES['file']['error'] == 0) {
        imagepng(imagecreatefromstring(file_get_contents($_FILES['file']['tmp_name'])), $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
        unlink($_FILES['file']['tmp_name']);
    }
} else {
    copy($_SERVER['DOCUMENT_ROOT'] . "/resources/image/siteicon.png", $_SERVER['DOCUMENT_ROOT'] . "/resources/upload/siteicon.png");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages");
}

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes")) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes");
}

$password = password_hash("MPCMS-usr-motdepasse", PASSWORD_BCRYPT, ['cost' => 12,]);

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/index", "<h4>Bienvenue sur Minteck Projects CMS !</h4><blockquote><p>Une nouvelle façon de gérer votre site Internet</p></blockquote><h2>Installation terminée avec succès</h2><p>Vous avez terminé l'installation de Minteck Projects CMS, il ne vous reste plus qu'à le configurer</p><h3>Fonctionnalités</h3><p>Voici une courte liste de ce que vous pouvez faire avec Minteck Projects CMS :</p><ul><li>Mettre en ligne des fichiers,</li><li>Afficher une galerie de photos,</li><li>Informer vos visiteurs des prochains évènements,</li><li>Donner des informations sur ce que vous faites,</li><li>Modifier votre site plus facilement</li></ul><h3>Éditeur visuel</h3><p>Pour vous faciliter la modification de votre site, Minteck Projects CMS vous propose un éditeur visuel.</p><h4>Utilisation</h4><p>Pour créer une page avec l'éditeur visuel, accédez à <i>Administration &gt; Pages &gt; Créer une page &gt; Classique</i>.</p><h4>Fonctionnalités</h4><p>Voici une liste de ce que vous pouvez faire avec l'éditeur visuel :</p><ul><li>Paragraphe</li><li>Titre (3 niveaux différents)</li><li>Gras</li><li>Italique</li><li>Liens</li><li>Insertion de média (YouTube, Spotify, ...)</li><li>Citation</li><li>Insertion de tableau</li><li>Liste à puces</li><li>Liste numérotée</li><li>Annuler</li><li>Restaurer</li></ul><blockquote><p>Cette page a été créée en utilisant l'éditeur visuel de Minteck Projects CMS</p></blockquote><h3>Création de pages</h3><p>Une page Minteck Projects CMS peut être de plusieurs types, qui sont :</p><ul><li><strong>Classique : </strong>Écrire à la manière d'un éditeur de texte depuis l'éditeur visuel</li><li><strong>HTML :</strong> Coder manuellement la page pour plus de personnalisation</li><li><strong>Téléchargement :</strong> Proposer de télécharger un fichier</li><li><strong>Galerie de photos :</strong> Mettre à disposition plusieurs photos</li></ul><h3>À propos de Minteck Projects CMS</h3><ul><li>Proposé sous licence GNU General Public License 3</li><li>Créé par Minteck Projects en utilisant Visual Studio Code sur Ubuntu 18.04 (GNOME 3 avec le Communitheme)</li><li>Icônes Material et Flat Remix</li></ul>");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pagetypes/index", "0");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/footer", "Copyright © Votre nom ici<br>Tous droits réservés");
$sitename = str_replace('>', '&gt;', $_POST['sitename']);
$sitename = str_replace('<', '&lt;', $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename", $sitename);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json", "{\"list\": [\"test\"],\"settings\": {\"test\": {\"sampleSetting\": \"This is a sample setting\"}}}");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/caldb.json", "{\"events\":[{}]}");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/password", $password);
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - SETUP/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - SETUP/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

die("ok");