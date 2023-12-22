/**Function to change the flag languages.*/
function loadLang(lang) {
  if (lang == "spanish") {
    document.getElementById("langImage").src = "View/Resources/Spain.png";
    setCookie("lang", "ES");
    setLang("ES");
  } else if (lang == "english") {
    document.getElementById("langImage").src = "View/Resources/United-Kingdom.png";
    setCookie("lang", "EN");
    setLang("EN");
  } else if (lang == "galego") {
    document.getElementById("langImage").src = "View/Resources/Galicia.png";
    setCookie("lang", "GA");
    setLang("GA");
  }
  includeTopMenu();
}

/**Function to include the footer.*/
function includeFooter() {
  $("#footer").html("");

  var footer =
    '<footer class="fixed-bottom page-footer font-small footer">' +
    '<div class="footer-copyright text-center py-3 font-weight-bold">© 2023 Copyright: ' +
    '<a href="#">EDUCENTER</a>' +
    "</div>" +
    "</footer>";

  $("#footer").append(footer);
}

/*Function to obtains the cookie's value.*/
function getCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(";");

  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
  }

  return null;
}

/*Function to stablish the cookie's value.*/
function setCookie(name, value, days) {
  var expires = "";

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }

  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

/** Function to show error modals.**/
function errorFailAjax(status) {
  if (status === 500) {
    errorInternal("MENSAJE_ERROR_INTERNO");
  } else if (status === 403 || status === 412) {
    authenticationError("ERROR_AUTENTICACION");
  } else if (status === 0 || status === 404) {
    errorInternal("ERR_CONNECTION_REFUSED");
  }
}

function errorInternal(code) {
  var lang = getCookie("lang");
  $("#modal-title").removeClass();
  $("#modal-title").addClass("ERROR_INTERNO");
  document.getElementById("modal-title").style.color = "#a50707";
  document.getElementById("modal-title").style.top = "10%";
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass(code);
  $(".imagenAviso").attr("src", "./View/Resources/failed.png");
  document.getElementById("modal").style.display = "block";
  setLang(lang);
}

/** Function to check that user doesn't has the cap lock activated.*/
function capLock(e, elementId) {
  kc = e.keyCode ? e.keyCode : e.which;
  sk = e.shiftKey ? e.shiftKey : kc == 16 ? true : false;

  if ((kc >= 65 && kc <= 90 && !sk) || (kc >= 97 && kc <= 122 && sk)) {
    document.getElementById(elementId).style.display = "block";
  } else {
    document.getElementById(elementId).style.display = "none";
  }
}

function encrypt(elementId) {
  document.getElementById(elementId).value = hex_md5(
    document.getElementById(elementId).value
  );

  return true;
}

function closeModal(idElement) {
  document.getElementById(idElement).style.display = "none";

  modalType = document.getElementById("modal-mensaje").textContent;
  if (modalType == "Contraseña cambiada correctamente" || modalType == "Password changed successfully" || modalType == "Contrasinal cambiada correctamente") {
    logout();
    window.location.href = './index.html';
  }

}


function ajaxResponseKO(code) {
  $("#modal-title").removeClass();
  $("#modal-title").addClass("ERROR");
  document.getElementById("modal-title").style.color = "#a50707";
  document.getElementById("modal-title").style.top = "13%";
  $(".imagenAviso").attr("src", "./Resources/failed.png");
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass(code);
  setLang(getCookie("lang"));
}

function ajaxResponseOK(clase, codigo) {
  $(".imagenAviso").attr("src", "./Resources/ok.png");
  document.getElementById("modal-title").style.color = "#238f2a";
  document.getElementById("modal-title").style.top = "13%";
  $("#modal-title").removeClass();
  $("#modal-title").addClass(clase);
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass(codigo);
  setLang(getCookie("lang"));
}

function includeTopMenu() {
  $("#topMenu").html("");

  var topMenu =
    '<nav class="fixed-top navbar navbar-expand-md navbar-dark menuIdioma">' +
    '<a class="navbar-brand" href="menu.html">' +
    '<img src="Resources/icon.png" alt="Logo" class="imagenLogo">' +
    "</a>" +
    '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">' +
    '<span class="navbar-toggler-icon"></span>' +
    "</button>" +
    '<div class="collapse navbar-collapse" id="collapsibleNavbar">' +
    '<ul class="navbar-nav">' +
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown" href="#" id="navbardrop2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<div class="usuarioConectado">' +
    translateWord(getCookie("userRole").toUpperCase()) +
    "</div>" +
    "</a>" +
    "</li>" +
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown-toggle" href="#" id="navbardrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<img class="nav-link dropdown-toggle" id="langImage" src=""/>' +
    "</a>" +
    '<div class="dropdown-menu" aria-labelledby="navbarDropdown">' +
    '<a class="dropdown-item" href="#" onclick="loadLang(\'spanish\');">' +
    '<input type="submit" name="btnSpain" id="btnSpain" value="" onclick="loadLang(\'spanish\');" />' +
    "</a>" +
    '<div class="dropdown-divider"></div>' +
    '<a class="dropdown-item" href="#" onclick="loadLang(\'english\');">' +
    '<input type="submit" name="btnEnglish" id="btnEnglish" value="" onclick="loadLang(\'english\');" />' +
    "</a>" +
    '<div class="dropdown-divider"></div>' +
    '<a class="dropdown-item" href="#" onclick="loadLang(\'galego\');">' +
    '<input type="submit" name="btnGalician" id="btnGalician" value="" onclick="loadLang(\'galego\');" />' +
    "</a>" +
    "</div>" +
    "</li>" +
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown-toggle" href="#" id="navbardrop3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<img id="imagenHome" src="Resources/home.png" class="blue-icon"/>' +
    '<div class="home MENU">'+translateWord("MENU")+'</div></a>' +
    '<div class="dropdown-menu">' +
    '<a class="dropdown-item GESTION_USUARIO" href="userManagement.html">Gestión Usuarios</a>' +
    (getCookie("userRole") == "usuario" && getCookie("academicCourseName") != "" ?
    '<a class="dropdown-item GESTION_USUARIO_MATERIA" href="userSubjectManagement.html">Gestión Solicitud Materia</a>'
    : "") +
    "</a>" +
    (getCookie("userRole") == "docente" && getCookie("academicCourseName") != "" ?
    '<a class="dropdown-item GESTION_DOCENTE_MATERIA" href="teacherSubjectManagement.html">Gestión Docente Materia</a>'
    : "") +
    "</a>" +
    "</div>" +
    (getCookie("userRole") == "administrador" ?
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown-toggle" href="#" id="navbardrop3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<img id="imagenHome" src="Resources/rol.png" class="blue-icon"/>' +
    '<div class="home PROCESOS"></div>' +
    "</a>" +
    '<div class="dropdown-menu" id="listadoFuncionalidadesProcesos">' +
    '<a class="dropdown-item GESTION_CURSO_ACADEMICO" href="academicCourseManagement.html">Gestión Cursos Académicos</a>' +
    '<a class="dropdown-item GESTION_ACCION_FUNCIONALIDAD" href="actionFunctionalityManagement.html">Gestión Acción-Funcionalidad</a>' +
    '<a class="dropdown-item GESTION_ROL_ACCION_FUNCIONALIDAD" href="roleActionFunctionalityManagement.html">Gestión Rol-Acción-Funcionalidad</a>' +
    "</div>" +
    "</li>"
    : "") +
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown-toggle" href="#" id="navbardrop2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<img id="imagenUsuario" src="Resources/usuario.png" class="blue-icon"/>' +
    '<div class="usuarioConectado">' +
    getCookie("userSystem") +
    "</div>" +
    "</a>" +
    '<div class="dropdown-menu">' +
    '<a class="dropdown-item PERFIL_USUARIO" href="#" data-toggle="modal" data-target="#viewProfile-modal" onclick="javascript:viewProfile()">Ver Perfil</a>' +
    '<a class="dropdown-item CAMBIAR_CONTRASEÑA_MENU" href="#" data-toggle="modal" data-target="#changePass-modal" onclick="javascript:modalChangePass()">'+translateWord("CAMBIAR_CONTRASEÑA")+'</a>' +
    '<div class="dropdown-divider"></div>' +
    '<a class="dropdown-item DESCONECTAR" href="./index.html" onclick="javascript:logout()">Desconectar</a>' +
    "</div>" +
    "</li>" +
    '<li class="nav-item dropdown">' +
    '<a class="nav-link dropdown" href="#" id="navbardrop2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
    '<img id="imagenUsuario" src="Resources/academicCourse.png" class="blue-icon"/>' +
    '<div class="usuarioConectado">' +
    (getCookie("academicCourseName") != null ? getCookie("academicCourseName") : "") +
    "</div>" +
    "</a>" +
    "</li>" +
    "</ul>" +
    "</div>" +
    "</nav>";

  $("#topMenu").append(topMenu);

  setLang(getCookie("lang"));
}

async function viewProfile() {
  data = {
    "action": "searchBy",
    "controller": "user",
    "dni": getCookie("userSystem")
  };
  await ajaxPromiseNoSerialize(data, "RECORDSET_DATOS", true)
    .then((res) => {
      $("#viewProfile-modal").html("");

      var resource = res["resource"];
      var modalContent =
        '<div class="modal-dialog">' +
        '<div class="viewProfile-container">' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '<h1 class="PERFIL_USUARIO"></h1><br>' +
        '<form name="viewProfileForm" id="viewProfileForm" action="#">' +
        '<div class="form-group">' +
        '<label class="DNI" id="DNI"> </label>' +
        ' <input type="text" name="dni" placeholder="DNI" id="dniP" value="' + resource["dni"] + '" class="dni DNI form-control" maxlength="9" size="30" disabled>' +
        '</div><div class="form-group"><label class="NOMBRE_PERSONA" id="NOMBRE_PERSONA"> </label>' +
        ' <input type="text" name="nombre" placeholder="NOMBRE_PERSONA" id="nombreP" value="' + resource["nombre"] + '" class="nombre NOMBRE_PERSONA form-control" maxlength="45" size="30" disabled>' +
        '</div><div class="form-group"><label class="APELLIDOS_PERSONA" id="APELLIDOS_PERSONA"> </label>' +
        ' <input type="text" name="apellidos" placeholder="APELLIDOS_PERSONA" id="apellidosP" value="' + resource["apellidos_usuario"] + '" class="apellidos APELLIDOS_PERSONA form-control" maxlength="45" size="30" disabled>' +
        '</div><div class="form-group"><label class="FECHA_NAC" id="FECHA_NAC"> </label>' +
        ' <input type="text" name="fecha_nac" placeholder="FECHA_NAC" id="fechaNacP" value="' + resource["fecha_nac"] + '" class="fecha_nac FECHA_NAC form-control" maxlength="10" size="30" disabled>' +
        '</div><div class="form-group"><label class="DIRECCION_PERSONA" id="DIRECCION_PERSONA"> </label>' +
        ' <input type="text" name="direccion" placeholder="DIRECCION_PERSONA" id="direccionP" value="' + resource["direccion"] + '" class="direccion DIRECCION_PERSONA form-control" maxlength="200" size="30" disabled>' +
        '</div><div class="form-group"><label class="TELEFONO" id="TELEFONO"> </label>' +
        ' <input type="text" name="telefono" placeholder="TELEFONO" id="telefonoP" value="' + resource["telefono"] + '" class="telefono TELEFONO form-control" maxlength="9" size="30" disabled>' +
        '</div><div class="form-group"><label class="EMAIL" id="EMAIL"> </label>' +
        ' <input type="text" name="email" placeholder="EMAIL" id="emailP" value="' + resource["email"] + '" class="email EMAIL form-control" maxlength="9" size="30" disabled>' +
        '</div><div class="form-group"><label class="ROL" id="ROL"> </label>' +
        ' <input type="text" name="id_rol" placeholder="ROL" id="rolP" value="' + getCookie("userRole") + '" class="rol ROL form-control" maxlength="9" size="30" disabled>' +
        "<button name='btnAcciones' style='background-color: #222;' class='mt-3 tooltip6 btn w-100 border border-dark' id='btnAcciones' onclick='closeProfile()'>" +
        "<img class='iconoCerrar white-icon' src='Resources/close2.png' alt='' id='iconoAcciones' />" +
        "<span class='tooltiptext ICONO_CERRAR' id='spanAcciones'></span>" +
        "</button>" +
        "</form>" +
        "</div>" +
        "</div>";

      $("#viewProfile-modal").append(modalContent);
      document.getElementById("viewProfile-modal").style.display = 'block';

      setLang(getCookie("lang"));
    })
    .catch((res) => {
      ajaxResponseKO(res.code);
      setLang(getCookie("lang"));
      document.getElementById("modal").style.display = "block";
    });
  deleteActionController();
}

function closeProfile() {
    document.getElementById('viewProfile-modal').style.display = 'none';
    $('#viewProfile-modal').modal('hide');
}

/**Function to system logout.*/
function logout() {
  deleteAllCookies();
}

function backMenu() {
  $("#viewProfile-modal").html("");

  $("#viewProfile-modal").append("");
  document.getElementById("viewProfile-modal").style.display = 'none';

  cleanSearchCookies();
}

function cleanSearchCookies() {
  setCookie("nombreRol", "");
  setCookie("descripcionRol", "");
}

/*Función que elimina las cookies del navegador cuando cambiamos de pestaña html*/
function deleteAllCookies() {
  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    var eqPos = cookie.indexOf("=");
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    setCookie(name, "");
  }
}

function authenticationError(responseCode) {
  var lang = getCookie("lang");
  $("#modal-title").removeClass();
  $("#modal-title").addClass("STOP");
  document.getElementById("modal-title").style.color = "#a50707";
  document.getElementById("modal-title").style.top = "13%";
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass(responseCode);
  $(".imagenAviso").attr("src", "images/stop.png");
  document.getElementById("modal").style.display = "block";
  setLang(lang);
}

async function userRole() {
  var lang = getCookie("lang");
  createHideForm("formularioRolUsuario", "javascript:userRole()");
  insertField(
    document.formularioRolUsuario,
    "dni",
    getCookie("userSystem")
  );

  await ajaxPromise(document.formularioRolUsuario, "search", "user", "RECORDSET_DATOS", true)
    .then((res) => {
      setCookie("userRole", res.resource[0].id_rol.nombre_rol);
      includeTopMenu();
    })
    .catch((res) => {
      actionError(res.code);
      setLang(lang);
    });
  deleteActionController();
}

function actionError(responseCode) {
  $("#modal-title").addClass("ERROR");
  $("#formularioAcciones").modal("hide");
  $(".imagenAviso").attr("src", "Resources/failed.png");
  $("#cerrar").attr("onclick", "closeModal('modal', 'index.html', '')");
  $("#modal-title").attr("style", "color: #ff0000;");
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass(responseCode);
  $(".imagenAviso").attr("style", "width: 16%; margin-top: 0");
  $("#modal").attr("style", "display: block");
  deleteAllCookies();
}


function ajaxPromise(form, action, method, errorMsg, checkToken) {
  var token = getCookie("token");
  addActionControler(form, action, method);

  if (checkToken && token == null) {
    authenticationError("ACCESO_DENEGADO");
  } else {
    return new Promise(function (resolve, reject) {
      $.ajax({
        method: "POST",
        url: URL_REST,
        data: $(form).serialize(),
        headers: token != null ? { Authorization: token } : "",
      })
        .done((res) => {
          if (res.code != errorMsg) {
            reject(res);
          }
          resolve(res);
        })
        .fail(function (jqXHR) {
          errorFailAjax(jqXHR.status);
        });
    });
  }
}

function ajaxPromiseNoSerialize(form, errorMsg, checkToken) {
  var token = getCookie("token");
  if (checkToken && token == null) {
    authenticationError("ACCESO_DENEGADO");
  } else {
    return new Promise(function (resolve, reject) {
      $.ajax({
        method: "POST",
        url: URL_REST,
        data: form,
        headers: { Authorization: token }
      })
        .done((res) => {
          if (res.code != errorMsg) {
            reject(res);
          }
          resolve(res);
        })
        .fail(function (jqXHR) {
          errorFailAjax(jqXHR.status);
        });
    });
  }
}

/**Función que genera la modal para que el usuario pueda cambiar su contraseña*/
function modalChangePass() {
  $("#changePass-modal").html("");

  var contenidoModal =
    '<div class="modal-dialog">' +
    '<div class="changePassmodal-container">' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">' +
    '<span aria-hidden="true">&times;</span>' +
    '</button>' +
    '<h1 class="CAMBIAR_CONTRASEÑA"></h1>' +
    '<div class-form-group>' +
    '<form name="formularioChangePass" id="formularioChangePass" action="javascript:changePass()" onsubmit="return checkChangePass()">' +
    '<label class="CAMBIAR_CONTRASEÑA mt-3"> </label>' +
    '<input type="password" name="password" class="PASS_USUARIO_NUEVA form-control" maxlength="45" size="45" id="passChangePass1" placeholder="" placeholder="Contraseña" onKeyPress="capLock(event,\'bloqueoMayusculasChangePass\');" onblur="return checkPass(\'passChangePass1\', \'errorFormatoChangePass1\', \'passwordChange\')"; autocomplete="new-password">' +
    '<div style="display:none" id="errorFormatoChangePass1"></div>' +
    '<label class="CONFIRMAR_PASS_USUARIO"> </label>' +
    '<input type="password" name="passwordConfirm" class="CONFIRMAR_PASS_USUARIO form-control" id="passChangePass2" maxlength="45" size="45" placeholder="Contraseña" onKeyPress="capLock(event,\'bloqueoMayusculasChangePass\');" onblur="return checkPassConfirmChangePass(\'passChangePass2\', \'errorFormatoChangePass2\', \'passwordChange\')" autocomplete="new-password">' +
    '<div style="display:none" id="errorFormatoChangePass2" class="alert alert-danger ocultar"></div>' +
    '<div style="display:none" class="BLOQUEO_MAYUSCULAS alert alert-warning" id="bloqueoMayusculasChangePass"></div>' +
    '<div id="error" class="alert alert-danger ocultar" role="alert" class="CONTRASEÑAS_NO_COINCIDEN"></div>' +
    '<button type="submit" name="btnChangePass" value="Cambiar contraseña" class="btnChangePass tooltip3 mt-3">' +
    '<img class="iconoResetPass iconResetPass white-icon" src="Resources/resetPass.png" alt="CAMBIAR_CONTRASEÑA" />' +
    '<span class="tooltiptext3 ICONO_RESET_PASS"></span>' +
    "</button>" +
    "</form>" +
    "</div>" +
    "</div>" +
    "</div>";

  $("#changePass-modal").append(contenidoModal);

  setLang(getCookie("lang"));
}

/**Función para ordenar una tabla por columna*/
function sortTable(n, idTable) {
  var table,
    rows,
    switching,
    i,
    x,
    y,
    shouldSwitch,
    dir,
    switchcount = 0;

  table = document.getElementById(idTable);
  switching = true;

  dir = "asc";

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = 1; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }

    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;

      switchcount++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

/**Función para ordenar una tabla por columna desde un índice indicado*/
function sortTableFromIndex(n, idTable, index) {
  var table,
    rows,
    switching,
    i,
    x,
    y,
    shouldSwitch,
    dir,
    switchcount = 0;

  table = document.getElementById(idTable);
  switching = true;

  dir = "asc";

  while (switching) {
    switching = false;
    rows = table.rows;

    for (i = index; i < rows.length - 1; i++) {
      shouldSwitch = false;

      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }

    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;

      switchcount++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

/**Función que habilita los campos de un formulario*/
function enableFields(idElementoList) {
  idElementoList.forEach(function (idElemento) {
    $("#" + idElemento).attr("readonly", false);
    $("#" + idElemento).attr("disabled", false);
  });
}

/**Función que deshabilita los campos de un formulario*/
function disableFields(idElementoList) {
  idElementoList.forEach(function (idElemento) {
    $("#" + idElemento).attr("readonly", true);
    $("#" + idElemento).attr("disabled", true);
  });
}

/**Función para cambiar valores del formulario.*/
function changeForm(tituloForm, action, onsubmit) {
  $("#formularioAcciones").attr("style", "display: block");
  $("#cerrarForm").attr("onclick", "cerrarModal('formularioAcciones', '', '')");
  $("#tituloForms").addClass(tituloForm);

  if (action != "") {
    $("#formularioGenerico").attr("action", action);
  }

  if (onsubmit != "") {
    $("#formularioGenerico").attr("onsubmit", onsubmit);
  } else {
    $("#formularioGenerico").attr("onsubmit", "");
  }
}

/**Función para cambiar valores del formulario.*/
function changeForm1(tituloForm, action, onsubmit) {
  $("#formularioAcciones").attr("style", "display: block");
  $("#cerrarForm").attr("onclick", "cerrarModal('formularioAcciones', '', '')");
  $("#tituloForms").addClass(tituloForm);

  if (action != "") {
    $("#formularioGenerico1").attr("action", action);
  }

  if (onsubmit != "") {
    $("#formularioGenerico1").attr("onsubmit", onsubmit);
  } else {
    $("#formularioGenerico1").attr("onsubmit", "");
  }
}

/**Función para cambiar valores del icono **/
function changeIcon(ruta, nombreIcono, estiloIcono, valorIcono) {
  $("#iconoAcciones").attr("src", ruta);
  $("#iconoAcciones").removeClass();
  $("#iconoAcciones").addClass(nombreIcono);
  $("#iconoAcciones").addClass(estiloIcono);
  $("#spanAcciones").removeClass();
  $("#spanAcciones").addClass("tooltiptext");
  $("#spanAcciones").addClass(nombreIcono);
  $("#btnAcciones").attr("value", valorIcono);
  $("#iconoAccionesProfesor").attr("src", ruta);
  $("#iconoAccionesProfesor").removeClass();
  $("#iconoAccionesProfesor").addClass(nombreIcono);
  $("#iconoAccionesProfesor").addClass(estiloIcono);
  $("#spanAccionesProfesor").removeClass();
  $("#spanAccionesProfesor").addClass("tooltiptext");
  $("#spanAccionesProfesor").addClass(nombreIcono);
  $("#btnAccionesProfesor").attr("value", valorIcono);
  $("#iconoAcciones1").attr("src", ruta);
  $("#iconoAcciones1").removeClass();
  $("#iconoAcciones1").addClass(nombreIcono);
  $("#iconoAcciones1").addClass(estiloIcono);
  $("#spanAcciones1").removeClass();
  $("#spanAcciones1").addClass("tooltiptext");
  $("#spanAcciones1").addClass(nombreIcono);
  $("#btnAcciones1").attr("value", valorIcono);
}

/* Funcion para cambiar la contraseña */
async function changePass() {
  addActionControler(
    document.formularioChangePass,
    "editPass",
    "user"
  );
  await changePassUserAjaxPromesa()
    .then((res) => {
      $("#changePass-modal").modal("toggle");
      setCookie("token", res.resource); //Actualizamos el token de sesión
      ajaxResponseOK("USUARIO_EDITAR_CONTRASENA_OK", res.code);

      let idElementoList = ["passChangePass1", "passChangePass2"];
      resetForm("formularioChangePass", idElementoList);
      setLang(getCookie("lang"));
      document.getElementById("modal").style.display = "block";

    })
    .catch((res) => {
      $("#changePass-modal").modal("toggle");
      ajaxResponseKO(res.code);

      let idElementoList = ["passChangePass1", "passChangePass2"];
      cleanForm(idElementoList);
      resetForm("formularioChangePass", idElementoList);
      setLang(getCookie("lang"));
      document.getElementById("modal").style.display = "block";
    });
}

/* Función para cambiar la contraseña con ajax y promesas */
function changePassUserAjaxPromesa() {
  var token = getCookie("token");
  if (token == null) {
    errorAutenticado("ACCESO_DENEGADO");
  } else {
    return new Promise(function (resolve, reject) {
      if (verificarPasswd()) {
        encrypt("passChangePass1");

        $.ajax({
          method: "POST",
          url: URL_REST,
          data: $("#formularioChangePass").serialize(),
          headers: { Authorization: token },
        })
          .done((res) => {
            if (res.code != "USUARIO_EDITAR_CONTRASENA_OK") {
              reject(res);
            }
            resolve(res);
          })
          .fail(function (jqXHR) {
            errorFailAjax(jqXHR.status);
          });
      } else {
        document.getElementById("error").setAttribute("style", "");
      }
    });
  }
}

/**Función para limpiar los campos de un formulario*/
function cleanForm(idElementoList) {
  idElementoList.forEach(function (idElemento) {
    $("#" + idElemento).val("");
  });
}

/**Función que resetear los valores del formulario*/
function resetForm(idFormulario, idElementoList) {
  document.getElementById(idFormulario).reset();

  idElementoList.forEach(function (idElemento) {
    document.getElementById(idElemento).style.borderColor = "#c8c8c8";
  });
}

function filterElement(list, field, val) {
const elem = document.getElementById(val).value;

if (elem !== null && elem !== "") {
    const components = field.split('.');

    list.resource = list.resource.filter(entry => {
        let currentObj = entry;
        let allPropertiesExist = true;

        // Verificar si todas las propiedades anidadas existen en el elemento
        for (const component of components) {
            if (currentObj !== null && currentObj.hasOwnProperty(component)) {
                currentObj = currentObj[component];
            } else {
                allPropertiesExist = false;
                break;
            }
        }

        return allPropertiesExist;
    });

    // Filtrar nuevamente para incluir solo los elementos que cumplen con el criterio de búsqueda
    list.resource = list.resource.filter(entry => {
        const fieldValue = components.reduce((obj, prop) => (obj !== null && obj !== undefined) ? obj[prop] : undefined, entry);

        if (fieldValue !== undefined && fieldValue !== null) {
            const normalizedFieldValue = fieldValue.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "");
            const normalizedElem = elem.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "");

            return normalizedFieldValue.includes(normalizedElem);
        }

        return false;
    });
}
}

function valueNullAndDisplayNone(value) {
    document.getElementById(value).value = "";
    document.getElementById(value).style.display = "none";
}

function displayBlock(value) {
    document.getElementById(value).style.display = "block";
}

function convertirFecha(fecha) {
    const partesFecha = fecha.split('/');
    const año = partesFecha[2];
    const mes = agregarCeroSiNecesario(partesFecha[1]);
    const dia = agregarCeroSiNecesario(partesFecha[0]);

    return `${año}-${mes}-${dia}`;
}

function agregarCeroSiNecesario(numero) {
    return parseInt(numero, 10) < 10 ? '0' + numero : numero;
}

/**Function to add a breadcrumb.*/
function includeBreadCrumb(pages) {
  $("#breadcrumb").html("");

  var breadcrumb = '<ol id="listaBreadcrumb" class="breadcrumb">';

  for (var i = 0; i < pages.length; i++) {
    var text;
    switch (pages[i]) {
      case "userManagement":
        text = "GESTION_USUARIO";
        break;
      case "teacherSubjectManagement":
        text = "GESTION_DOCENTE_MATERIA";
        break;
      case "subjectManagement":
        text = "GESTION_MATERIAS";
        break;
      case "showCompetencesGradesManagement":
        text = "CALIFICACIONES_COMPETENCIAS";
        break;
      case "teacherDetail":
        text = "GESTION_PROFESORES_MATERIA";
        break;
      case "studentDetail":
        text = "GESTION_ALUMNOS_MATERIAS";
        break;
      case "subjectDetail":
        text = "GESTION_TRABAJOS";
        break;
      case "competenceDetail":
        text = "GESTION_COMPETENCIAS";
        break;
      case "projectAllGrades":
        text = "CALIFICACIONES_MATERIA";
        break;
      case "subjectDeliveriesManagement":
        text = "DETALLE_ENTREGA";
        break;
      case "criteriaDetail":
        text = "DETALLE_CRITERIOS";
        break;
      case "assignCompetenceCriteria":
        text = "GESTION_COMPETENCIA_CRITERIO";
        break;
      case "projectGradeManagement":
        text = "CALIFICACIONES";
        break;
      case "actionFunctionalityManagement":
        text = "GESTION_ACCION_FUNCIONALIDAD";
        break;
      case "roleActionFunctionalityManagement":
        text = "GESTION_ROL_ACCION_FUNCIONALIDAD";
        break;
      case "showFinalGradesStudent":
        text = "CALIFICACIONES_MATERIA";
        break;
      case "showCompetencesGradesStudent":
        text = "CALIFICACIONES_COMPETENCIAS";
        break;
      case "projectGrade":
        text = "CALIFICACION_TRABAJO";
        break;
      case "assignedCorrections":
        text = "ICONO_CORRECCION_ASIGNADA";
        break;
      case "userSubjectManagement":
        text = "GESTION_USUARIO_MATERIA";
        break;
      case "academicCourseManagement":
        text = "GESTION_CURSO_ACADEMICO";
        break;
      case "showCompetencesGrades":
        text = "CALIFICACIONES_COMPETENCIAS";
        break;
      default:
        text = "INICIO";
        break;
    }

    breadcrumb += '<li class="breadcrumb-item"><a class="' + text + '" href="' + pages[i] + '.html"></a></li>';
  }

  breadcrumb += '</ol>';
  $("#breadcrumb").append(breadcrumb);
}
