function checkLogin() {
    if (checkUserDNI("userLogin", "errorFormatUser", "userLogin") &&
        checkPass("passLogin", "errorFormatPass", "passwdUserLogin")) {
        encrypt("passLogin");
        return true;
    } else {
        return false;
    }
}

async function login() {
    await ajaxPromise(document.loginForm, "login", "auth", "LOGIN_USUARIO_CORRECTO", false)
        .then((res) => {
            setCookie("token", res.resource);
            setCookie("userSystem", document.getElementById("userLogin").value);
            window.location.href = "./menu.html";
        })
        .catch((res) => {
            $("#login-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementList = ["userLogin", "passLogin"];
            resetForm("loginForm", idElementList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
    deleteActionController();
}

function checkGetNewPassword() {
    if (
        checkUserDNI(
            "userRecuperarPass",
            "errorFormatUserPass",
            "loginUsuarioRecPass"
        ) &&
        checkEmail(
            "emailUser",
            "errorFormatoEmailRecPass",
            "emailUsuarioRecPass"
        )
    ) {
        return true;
    } else {
        return false;
    }
}

function obtenerNuevaContrasenaAjaxPromesa() {
    addActionControler(
        document.formularioObtenerNuevaContrasena,
        "getPasswordEmail",
        "auth"
    );

    return new Promise(function (resolve, reject) {
        $.ajax({
            method: "POST",
            url: URL_REST,
            data: $("#formularioObtenerNuevaContrasena").serialize(),
        })
            .done((res) => {
                if (res.code != "RECOVER_PASSWORD_EMAIL_OK") {
                    reject(res);
                }
                resolve(res);
            })
            .fail(function (jqXHR) {
                errorFailAjax(jqXHR.status);
            });
    });
}

async function getNewPassword() {
    await obtenerNuevaContrasenaAjaxPromesa()
        .then((res) => {
            $("#recuperarcontrasena-modal").modal("toggle");
            $("#login-modal").modal("toggle");
            ajaxResponseOK("RECOVER_PASSWORD_EMAIL_OK", res.code);
            let idElementoList = ["userRecuperarPass", "emailUser"];
            resetForm("formularioObtenerNuevaContrasena", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#recuperarcontrasena-modal").modal("toggle");
            $("#login-modal").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = ["userRecuperarPass", "emailUser"];
            resetForm("formularioObtenerNuevaContrasena", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
    deleteActionController();
}