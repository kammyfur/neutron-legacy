window.onerror = function(msg, url, line, col, error) {
    alert("Une erreur d'exécution s'est produite :\nJSRuntimeError: " + msg + "\n\nDans le fichier " + url + "\nà la ligne " + line + " et au caractère " + col + "\n\nContactez votre administrateur réseau s'il a modifié MPCMS, ou les développeurs de MPCMS si personne n'a modifié MPCMS.");
 };