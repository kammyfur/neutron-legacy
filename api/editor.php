<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - DEMO-VISUALEDITOR/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
} else {
  file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - DEMO-VISUALEDITOR/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
}

?>

<!-- .text-tiny {
    font-size: 0.7em;
}

.text-small {
    font-size: 0.85em;
}

.text-big {
    font-size: 1.4em;
}

.text-huge {
    font-size: 1.8em;
} -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKEditor 5 – Classic editor</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/translations/fr.js"></script>
</head>
<body>
    <h1>Classic editor</h1>
    <textarea name="content" id="editor">
        <h1>Bienvenue sur Minteck Projects CMS !</h1>
        <blockquote>Une nouvelle façon de gérer votre site Internet</blockquote>
    </textarea>
    <script>
        let editor;
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                language: {
                    ui: 'fr',
                    content: 'fr'
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', '|', 'mediaembed', 'blockquote', 'inserttable', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'
                ]
            } )
            .then( newEditor => {
                editor = newEditor;
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>