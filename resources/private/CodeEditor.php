<!-- <div id="editor">&lt;!-- L'éditeur de code Minteck Projects CMS ne vous fait pas modifier un fichier entier.
Vous ne modifiez qu'une partie de fichier.

Vous pouvez donc ignorer les avertissements relatifs à certaines informations manquantes

____________________________

--&gt;

&lt;!-- Insérez le code CSS requis pour votre page ici --&gt;
&lt;style&gt;&lt;/style&gt;

&lt;!-- Insérez le code JavaScript requis pour votre page ici --&gt;
&lt;script type="text/javascript"&gt;&lt;/script&gt;

&lt;!-- Insérez le code HTML de votre page ici --&gt;</div> -->

<textarea id="codeeditor"><?php echo(str_ireplace(">", "&gt;", str_ireplace("<", "&lt;", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $currentSlug)))) ?></textarea>
<center><p><a onclick="updatePageHTML()" class="button">Publier</a></p></center>