<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - DEMO-CODEEDITOR/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - DEMO-CODEEDITOR/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>ACE in Action</title>
<style type="text/css" media="screen">
    #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>
</head>
<body>

<!-- <div id="editor">function foo(items) {
    var x = "All this is syntax highlighted";
    return x;
}</div> -->
    
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("codeeditor-placeholder");
    editor.session.setMode("ace/mode/html");
</script> -->
<div id="editor">&lt;!-- L'éditeur de code Minteck Projects CMS ne vous fait pas modifier un fichier entier.
Vous ne modifiez qu'une partie de fichier.

Vous pouvez donc ignorer les avertissements relatifs à certaines informations manquantes

____________________________

--&gt;

&lt;!-- Insérez le code CSS requis pour votre page ici --&gt;
&lt;style&gt;&lt;/style&gt;

&lt;!-- Insérez le code JavaScript requis pour votre page ici --&gt;
&lt;script type="text/javascript"&gt;&lt;/script&gt;

&lt;!-- Insérez le code HTML de votre page ici --&gt;</div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.6/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var codeeditor = ace.edit("editor");
    codeeditor.session.setMode("ace/mode/html");
</script>
</body>
</html>