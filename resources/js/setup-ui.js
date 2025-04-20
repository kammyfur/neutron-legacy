setTimeout(() => {
    document.getElementById('02-check').classList.remove('hide')
    document.getElementById('01-loader').classList.add('hide')
    $.ajax({
        url: "/api/setup/check.php",
        dataType: 'html',
        cache: false,
        contentType: false,
        processData: false,
        type: 'get',
        success: function (data) {
            setTimeout(() => {
                if (data != "ok") {
                    document.getElementById('00-error-title').innerHTML = "Environnement incorrect"
                    document.getElementById('00-error-message').innerHTML = data
                    document.getElementById('02-check').classList.add("hide")
                    document.getElementById('00-error').classList.remove("hide")
                    window.onbeforeunload = undefined;
                } else {
                    document.getElementById('02-check').classList.add("hide")
                    document.getElementById('03-welcome').classList.remove("hide")
                }
            }, 1000)
        }
    })
}, 5000)

function validateName() {
    document.getElementById('04-name-tip').classList.remove('tip-orange')
    document.getElementById('04-name-tip').classList.remove('tip-green')
    document.getElementById('04-name-tip').classList.remove('tip-red')
    document.getElementById('04-name-tip').innerHTML = "...";
    setTimeout(() => {
        name = document.getElementById('04-name-field').value
        if (name.trim() == "") {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom ne peut pas être vide";
            return;
        }
        if (name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|")) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom contient des charactères invalides";
            return;
        }
        if (name.length > 75) {
            document.getElementById('04-name-tip').classList.add('tip-red')
            document.getElementById('04-name-tip').innerHTML = "Le nom est trop long";
            return;
        }
        if (name.length < 4) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus long recommandé";
            return;
        }
        if (name.length > 30) {
            document.getElementById('04-name-tip').classList.add('tip-orange')
            document.getElementById('04-name-tip').innerHTML = "Nom plus court recommandé";
            return;
        }
        document.getElementById('04-name-tip').classList.add('tip-green')
        document.getElementById('04-name-tip').innerHTML = "Ce nom semble parfait";
        return;
    }, 100)
}

function Name_ChangeIfOk() {
    name = document.getElementById('04-name-field').value
    if (name.trim() == "" || name.includes("<") || name.includes(">") || name.includes("#") || name.includes("@") || name.includes("}") || name.includes("{") || name.includes("|") || name.length > 75) {return;}
    document.getElementById('04-name').classList.add('hide');
    document.getElementById('05-icon').classList.remove('hide');
}

function Icon_UploadFile() {
    $("#05-icon-file").trigger('click');
    Icon_Validate()
}

function Icon_Validate() {
    if (document.getElementById('05-icon-file').value != "") {
        document.getElementById('05-icon-img').src = "/resources/image/config_file_replace.svg"
    } else {
        document.getElementById('05-icon-img').src = "/resources/image/config_file_import.svg"
    }
}

function Icon_Validate_Delayed() {
    setTimeout(() => {
        if (document.getElementById('05-icon-file').value != "") {
            document.getElementById('05-icon-img').src = "/resources/image/config_file_replace.svg"
        } else {
            document.getElementById('05-icon-img').src = "/resources/image/config_file_import.svg"
        }
    }, 1000)
}

document.getElementById('04-name-field').value = ""
document.getElementById('05-icon-file').value = ""
setInterval(Icon_Validate, 100)

function upload() {
    document.getElementById('07-finish').classList.add('hide');
    document.getElementById('08-checking').classList.remove('hide');
    setTimeout(() => {
        document.getElementById('08-checking').classList.add('hide');
        document.getElementById('09-uploading').classList.remove('hide');
        var formData = new FormData();
        if (document.getElementById('05-icon-file').value.trim() != "") {
            formData.append("file", document.getElementById('05-icon-file').files[0], document.getElementById('05-icon-file').files[0].name);
        }
        formData.append("upload_file", true);
        formData.append("sitename", document.getElementById('04-name-field').value);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/api/setup/push.php",
            success: function (data) {
                if (data == "ok") {
                    setTimeout(() => {
                        document.getElementById('09-uploading').classList.add('hide');
                        document.getElementById('10-summing').classList.remove('hide');
                        setTimeout(() => {
                            document.getElementById('10-summing').classList.add('hide');
                            document.getElementById('11-performance').classList.remove('hide');
                            setTimeout(() => {
                                document.getElementById('11-performance').classList.add('hide');
                                document.getElementById('12-done').classList.remove('hide');
                                window.onbeforeunload = undefined;
                            }, 3000)
                        }, 2000)
                    }, 3000)
                } else {
                    document.getElementById('00-error-title').innerHTML = "Impossible de terminer la configuration"
                    document.getElementById('00-error-message').innerHTML = data
                    document.getElementById('09-uploading').classList.add("hide")
                    document.getElementById('00-error').classList.remove("hide")
                    window.onbeforeunload = undefined;
                }
            },
            error: function (error) {
                document.getElementById('00-error-title').innerHTML = "Erreur de communication"
                document.getElementById('00-error-message').innerHTML = "La connexion avec le serveur distant à été intérrompue pendant la transmition des données"
                document.getElementById('02-check').classList.add("hide")
                document.getElementById('00-error').classList.remove("hide")
                window.onbeforeunload = undefined;
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    }, 1000)
}