/**Function that validate the user.*/
function checkUserDNI(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (checkNotEmpty(elementId, elementIdError, field) &&
    checkLettersNumbers(elementId, elementIdError, field) &&
    checkMinLength(elementId, 9, elementIdError, field) &&
    checkMaxLength(elementId, 9, elementIdError, field) &&
    checkEnhe(elementId, elementIdError, field) &&
    checkDNIFormat(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

/**Function that validate the user's password.*/
function checkPass(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (checkNotEmpty(elementId, elementIdError, field) &&
    checkLettersNumbers(elementId, elementIdError, field) &&
    checkMinLength(elementId, 3, elementIdError, field) &&
    checkMaxLength(elementId, 45, elementIdError, field) &&
    checkEnhe(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function verificarPasswd() {
  passwdUsuario1 = $("#passwdUsuario1").val();
  passwdUsuario2 = $("#passwdUsuario2").val();

  if (passwdUsuario1 != passwdUsuario2) {
    addCodeError("error", "CONTRASEÑAS_NO_COINCIDEN");
    return false;
  } else {
    $("#error").removeClass();
    $("#error").html("");
    $("#error").css("display", "none");
    return true;
  }
}

/**Función que valida si un field está vacío*/
function checkNotEmpty(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;
  var length = document.getElementById(elementId).value.length;

  if (value == null || length == 0) {
    switch (field) {
      case "userLogin":
        code = "LOGIN_USUARIO_VACIO";
        break;
      case "passwdUserLogin":
        code = "CONTRASENA_USUARIO_VACIA";
        break;
      case "passwdUserLogin", "passwdUserRegister":
        code = "CONTRASENA_USUARIO_VACIA";
        break;
      case "emailUsuarioRecPass":
        code = "EMAIL_VACIO";
        break;
      case "personDni":
        code = "DNI_VACIO";
        break;
      case "namePersonRegister":
        code = "NOMBRE_VACIO";
        break;
      case "surnamePersonRegister":
        code = "APELLIDOS_VACIO";
        break;
      case "datePersonRegister":
        code = "FECHA_NACIMIENTO_VACIA";
        break;
      case "addressPersonRegister":
        code = "DIRECCION_VACIA";
        break;
      case "phonePersonRegister":
        code = "TELEFONO_VACIO";
        break;
      case "emailPersonRegister":
        code = "EMAIL_VACIO";
        break;
      case "passwordChange":
        code = "CONTRASENA_USUARIO_VACIA";
        break;
      case "loginUsuarioRecPass":
        code = "LOGIN_USUARIO_VACIO";
        break;
      case "nameSubject":
        code = "NOMBRE_MATERIA_VACIO";
        break;
      case "creditsSubject":
        code = "CREDITOS_VACIO";
        break;
      case "data":
         code = "DATOS_VACIO";
         break;
      case "nameProject":
         code = "NOMBRE_VACIO";
         break;
      case "notePercentProject":
         code = "PORCENTAJE_NOTA_VACIO";
         break;
      case "correctionPercentProject":
         code = "CORRECCION_NOTA_VACIO";
         break;
      case "correctionInitDateProject":
         code = "FECHA_INICIAL_VACIO";
         break;
      case "correctionEndDateProject":
         code = "FECHA_FIN_VACIO";
         break;
      case "titleCompetence":
          code = "TITULO_VACIO";
          break;
      case "descriptionCompetence":
          code = "DESCRIPCION_VACIO";
          break;
      case "selectCompetence":
          code = "COMPETENCIA_VACIO";
          break;
      case "descriptionCriteria":
          code = "DESCRIPCION_VACIO";
          break;
      case "correctionDescriptionCriteria":
          code = "DESCRIPCION_VACIO";
          break;
      case "assignCorrection":
          code = "ALUMNOS_VACIO";
          break;
      case "numAlumnos":
          code = "ALUMNOS_VACIO";
          break;
      case "endDateCorrection":
          code = "FECHA_FIN_VACIO";
          break;
      case "correccionCriterio":
        code = "CORRECTO_VACIO";
        break;
      case "comentarioCorreccionCriterio":
        code = "COMENTARIO_VACIO";
        break;
      case "comentarioCorreccionCriterioProfesor":
        code = "COMENTARIO_PROFESOR_VACIO";
        break;
      case "academicCourseName":
        code = "NOMBRE_VACIO";
        break;
    }
    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

/**Function that validates that a field contains letters and numbers.**/
function checkLettersNumbers(idElement, idElementError, field) {
  var code = "";

  var value = document.getElementById(idElement).value;

  var pattern = /^[a-zA-Z0-9\u00f1\u00d1]+$/;

  if (!pattern.test(value)) {
    switch (field) {
      case "loginUsuario":
        code = "LOGIN_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "passwdUserLogin", "passwdUserRegister":
        code = "CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "personDni":
        code = "DNI_ALFANUMERICO_INCORRECTO";
      case "loginUsuarioRecPass":
        code = "LOGIN_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "profesorPpal":
        code = "DNI_ALFANUMERICO_INCORRECTO";
        break;
    }

    addCodeError(idElementError, code);
    return false;
  } else {
    return true;
  }
}

/**Function that validates the minimun length of a field.**/
function checkMinLength(elementId, sizeMin, elementIdError, field) {
  var code = "";

  var longitud = document.getElementById(elementId).value.length;

  if (longitud < sizeMin) {
    switch (field) {
      case "loginUsuario":
        code = "LOGIN_USUARIO_MENOR_QUE_3";
        break;
      case "passwdUserLogin", "passwdUserRegister":
        code = "CONTRASENA_USUARIO_MENOR_QUE_3";
        break;
      case "personDni":
        code = "DNI_USUARIO_MENOR_QUE_9";
        break;
      case "phonePersonRegister":
        code = "PHONE_USUARIO_MENOR_QUE_9";
        break;
      case "addressPersonRegister":
        code = "ADDRESS_USUARIO_MENOR_QUE_5";
        break;
      case "loginUsuarioRecPass":
        code = "LOGIN_USUARIO_MENOR_QUE_3";
        break;
      case "nameSubject":
        code = "NOMBRE_MATERIA_MENOR_QUE_3";
        break;
      case "creditsSubject":
        code = "CREDITOS_MENOR_QUE_1";
        break;
      case "profesorPpal":
        code = "DNI_USUARIO_MENOR_QUE_9";
        break;
      case "nameProject":
        code = "NOMBRE_MENOR_QUE_3";
        break;
      case "titleCompetence":
          code = "TITULO_MENOR_QUE_3";
          break;
      case "descriptionCompetence":
          code = "DESCRIPCION_MENOR_QUE_5";
          break;
      case "descriptionCriteria":
          code = "DESCRIPCION_MENOR_QUE_5";
          break;
      case "correctionDescriptionCriteria":
          code = "DESCRIPCION_MENOR_QUE_5";
          break;
      case "numAlumnos":
          code = "ALUMNOS_MENOR_QUE_1";
          break;
      case "endDateCorrection":
          code = "FECHA_FIN_MENOR_QUE_1";
          break;
      case "academicCourseName":
          code = "NOMBRE_MENOR_QUE_3";
          break;
    }

    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

/**Function that check the max length of a field.**/
function checkMaxLength(elementId, sizeMax, elementIdError, field) {
  var code = "";

  var longitud = document.getElementById(elementId).value.length;

  if (longitud > sizeMax) {
    switch (field) {
      case "loginUsuario":
        code = "LOGIN_USUARIO_MAYOR_QUE_15";
        break;
      case "passwdUserLogin", "passwdUserRegister":
        code = "CONTRASENA_USUARIO_MAYOR_QUE_45";
        break;
      case "personDni":
        code = "DNI_USUARIO_MAYOR_QUE_9";
        break;
      case "phonePersonRegister":
        code = "PHONE_USUARIO_MAYOR_QUE_9";
        break;
      case "addressPersonRegister":
        code = "ADDRESS_USUARIO_MAYOR_QUE_200";
        break;
      case "loginUsuarioRecPass":
        code = "LOGIN_USUARIO_MAYOR_QUE_3";
        break;
      case "nameSubject":
        code = "NOMBRE_MATERIA_MAYOR_QUE_45";
        break;
      case "creditsSubject":
        code = "CREDITOS_MAYOR_QUE_4";
        break;
      case "profesorPpal":
        code = "DNI_USUARIO_MAYOR_QUE_9";
        break;
      case "nameProject":
        code = "NOMBRE_MAYOR_QUE_60";
        break;
      case "correctionInitDateProject":
         code = "PORCENTAJE_NOTA_MAYOR_QUE_3";
         break;
      case "correctionEndDateProject":
         code = "CORRECCION_NOTA_MAYOR_QUE_3";
         break;
      case "correctionDescriptionProject":
         code = "DESCRIPCION_TRABAJO_MAYOR_QUE_200";
         break;
      case "descriptionProject":
         code = "DESCRIPCION_TRABAJO_MAYOR_QUE_200";
         break;
      case "titleCompetence":
          code = "TITULO_MAYOR_QUE_60";
          break;
      case "descriptionCompetence":
          code = "DESCRIPCION_MAYOR_QUE_200";
          break;
      case "descriptionCriteria":
          code = "DESCRIPCION_MAYOR_QUE_200";
          break;
      case "correctionDescriptionCriteria":
          code = "DESCRIPCION_MAYOR_QUE_200";
          break;
      case "numAlumnos":
          code = "ALUMNOS_MAYOR_QUE_99";
          break;
      case "endDateCorrection":
          code = "FECHA_FIN_MAYOR_QUE_10";
          break;
      case "academicCourseName":
          code = "NOMBRE_MAYOR_QUE_45";
          break;
    }

    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

function checkDNIFormat(elementId, elementIdError, field) {
  var value = document.getElementById(elementId).value;
  var pattern = /(^[0-9]{8}[A-Z]{1}$)/;
  if (!pattern.test(value)) {
    switch (field) {
      case "loginUsuario":
        code = "LOGIN_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "personDni":
        code = "DNI_ALFANUMERICO_INCORRECTO";
        break;
      case "profesorPpal":
        code = "DNI_ALFANUMERICO_INCORRECTO";
        break;
    }

    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

/**Function that check a field not contains ñ.**/
function checkEnhe(elementId, elementIdError, field) {
  var code = "";
  var value = document.getElementById(elementId).value;
  var pattern = /[ñÑ]/;

  if (pattern.test(value)) {
    switch (field) {
      case "loginUsuario":
        code = "LOGIN_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "passwdUserLogin", "passwdUserRegister":
        code = "CONTRASEÑA_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "personDni":
        code = "DNI_ALFANUMERICO_INCORRECTO";
        break;
      case "loginUsuarioRecPass":
        code = "LOGIN_USUARIO_ALFANUMERICO_INCORRECTO";
        break;
      case "profesorPpal":
        code = "DNI_ALFANUMERICO_INCORRECTO";
        break;
    }

    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

/**Function to add error messages.*/
function addCodeError(elementIdError, code) {
  var lang = getCookie("lang");

  $("#" + elementIdError).removeClass();
  $("#" + elementIdError).addClass(code);
  $("#" + elementIdError).addClass("alert alert-danger");

  setLang(lang);
}

/** Function to show success message.*/
function checkOK(elementId, elementIdError) {
  document.getElementById(elementIdError).style.display = "none";
  document.getElementById(elementId).style.borderColor = "#00e600";
}

/** Function to show error message.*/
function checkKO(elementId, elementIdError) {
  document.getElementById(elementIdError).setAttribute("style", "");
  document.getElementById(elementId).style.borderColor = "#ff0000";
}

function checkName(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkOnlyLetters(elementId, elementIdError, field) &&
    checkMinLength(elementId, 3, elementIdError, field) &&
    checkMaxLength(elementId, 45, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkSurname(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";
  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkOnlyLetters(elementId, elementIdError, field) &&
    checkMinLength(elementId, 3, elementIdError, field) &&
    checkMaxLength(elementId, 45, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkBirthDate(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMinLength(elementId, 3, elementIdError, field) &&
    checkMaxLength(elementId, 10, elementIdError, field) &&
    checkFormatDates(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkInitDate(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkFormatDates(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkEndDate(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkFormatDates(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkAddress(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMinLength(elementId, 5, elementIdError, field) &&
    checkMaxLength(elementId, 200, elementIdError, field) &&
    checkLettersNumbersCaracteres(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkPhone(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMinLength(elementId, 9, elementIdError, field) &&
    checkMaxLength(elementId, 9, elementIdError, field) &&
    checkOnlyNumbers(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkDescription(elementId, elementIdError, field) {
    document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkMaxLength(elementId, 200, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkDescriptionCriteria(elementId, elementIdError, field) {
    document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMinLength(elementId, 5, elementIdError, field) &&
    checkMaxLength(elementId, 200, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkAssignCorrectionManually(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkEndDateCorrection(elementId, elementIdError, field) {
    document.getElementById(elementId).style.borderWidth = "2px";

    if (
        checkNotEmpty(elementId, elementIdError, field) &&
        checkMinLength(elementId, 3, elementIdError, field) &&
        checkMaxLength(elementId, 10, elementIdError, field) &&
        checkFormatDates(elementId, elementIdError, field)
    ) {
        checkOK(elementId, elementIdError);
        return true;
    } else {
        checkKO(elementId, elementIdError);
        return false;
    }
}

function checkDescriptionCompetence(elementId, elementIdError, field) {
    document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMaxLength(elementId, 200, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkNotePercent(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMaxLength(elementId, 3, elementIdError, field) &&
    checkOnlyNumbers(elementId, elementIdError, field) &&
    checkPercent(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkCorrectionPercent(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMaxLength(elementId, 3, elementIdError, field) &&
    checkOnlyNumbers(elementId, elementIdError, field) &&
    checkPercent(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkData(elementId, elementIdError, field) {
    if (
        checkNotEmpty(elementId, elementIdError, field)
      ) {
        checkOK(elementId, elementIdError);
        return true;
      } else {
        checkKO(elementId, elementIdError);
        return false;
      }
}

function checkEmail(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkFormatEmail(elementId, elementIdError, field) &&
    checkMinLength(elementId, 6, elementIdError, field) &&
    checkMaxLength(elementId, 40, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkPassConfirmChangePass(idElemento, idElementoError, campo) {
  document.getElementById(idElemento).style.borderWidth = "2px";

  if (
    checkNotEmpty(idElemento, idElementoError, campo) &&
    checkLettersNumbers(idElemento, idElementoError, campo) &&
    checkMinLength(idElemento, 3, idElementoError, campo) &&
    checkMaxLength(idElemento, 45, idElementoError, campo) &&
    checkEnhe(idElemento, idElementoError, campo)
  ) {
    checkOK(idElemento, idElementoError);
    if ($("#passChangePass1").val() != $("#passChangePass2").val()) {
      addCodeError("error", "CONTRASEÑAS_NO_COINCIDEN");
      return false;
    } else {
      $("#error").removeClass();
      $("#error").html("");
      $("#error").css("display", "none");
      return true;
    }
  } else {
    checkKO(idElemento, idElementoError);
    if ($("#passChangePass1").val() != $("#passChangePass2").val()) {
      addCodeError("error", "CONTRASEÑAS_NO_COINCIDEN");
      return false;
    } else {
      $("#error").removeClass();
      $("#error").html("");
      $("#error").css("display", "none");
    }
    return false;
  }
}

function checkPassRep(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkLettersNumbers(elementId, elementIdError, field) &&
    checkMinLength(elementId, 3, elementIdError, field) &&
    checkMaxLength(elementId, 45, elementIdError, field) &&
    checkEnhe(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    if ($("#passwdUsuario1").val() != $("#passwdUsuario2").val()) {
      addCodeError("error", "CONTRASEÑAS_NO_COINCIDEN");
      $("#error").css("display", "block");
      return false;
    } else {
      $("#error").removeClass();
      $("#error").html("");
      $("#error").css("display", "none");
      return true;
    }
  } else {
    checkKO(elementId, elementIdError);
    if ($("#passwdUsuario1").val() != $("#passwdUsuario2").val()) {
      addCodeError("error", "CONTRASEÑAS_NO_COINCIDEN");
      $("#error").css("display", "block");
      return false;
    } else {
      $("#error").removeClass();
      $("#error").html("");
      $("#error").css("display", "none");
    }
    return false;
  }
}

function checkOnlyLetters(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  var pattern = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/g;

  if (!pattern.test(value)) {
    switch (field) {
      case "namePersonRegister":
        code = "NOMBRE_FORMATO_INCORRECTO";
        break;
      case "surnamePersonRegister":
        code = "APELLIDOS_FORMATO_INCORRECTO";
        break;
    }

    if (code !== "") {
        addCodeError(elementIdError, code);
        return false;
    }
  }

  return true;
}

function checkFormatDates(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  var pattern = /^[0-9]{4}(-)[0-9]{2}(-)[0-9]{2}/g;

  if (!pattern.test(value)) {
    switch (field) {
      case "datePersonRegister":
        code = "FECHA_NACIMIENTO_NUMERICA_INCORRECTA";
        break;
      case "fecha":
        code = "FECHA_NUMERICA_INCORRECTA";
        break;
      case "correctionInitDateProject":
        code = "FECHA_FORMATO_INCORRECTO";
        break;
      case "correctionEndDateProject":
        code = "FECHA_FORMATO_INCORRECTO";
        break;
      case "endDateCorrection":
        code = "FECHA_FORMATO_INCORRECTO";
        break;
    }
    addCodeError(elementIdError, code);
    return false;
  }

  return true;
}

function checkLettersNumbersCaracteres(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  var pattern = /^[a-zA-Z0-9À-ÿ\u00f1\u00d1\u00AA\u00BA///-\s]+$/;

  if (!pattern.test(value)) {
    switch (field) {
      case "addressPersonRegister":
        code = "DIRECCION_FORMATO_INCORRECTO";
        break;
    }
    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

function checkPercent(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  if (value < 1 || value > 100) {
    switch (field) {
      case "notePercentProject":
         code = "PORCENTAJE_NOTA_MAYOR_100";
         break;
      case "correctionPercentProject":
         code = "CORRECCION_NOTA_MAYOR_100";
    }
    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

function checkOnlyNumbers(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  var pattern = /^[0-9]+$/;

  if (!pattern.test(value)) {
    switch (field) {
      case "phonePersonRegister":
        code = "TELEFONO_FORMATO_INCORRECTO";
        break;
      case "creditsSubject":
         code = "CREDITOS_FORMATO_INCORRECTO";
         break;
      case "notePercentProject":
         code = "PORCENTAJE_NOTA_ERROR_FORMATO";
         break;
      case "correctionPercentProject":
         code = "CORRECCION_NOTA_ERROR_FORMATO";
         break;
      case "numAlumnos":
         code = "ALUMNOS_ERROR_FORMATO";
         break;
    }
    addCodeError(elementIdError, code);
    return false;
  } else {
    return true;
  }
}

function checkFormatEmail(elementId, elementIdError, field) {
  var code = "";

  var value = document.getElementById(elementId).value;

  var pattern =
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/; // establecemos un pattern para un email
  if (!pattern.test(value)) {
    switch (field) {
      case "emailUsuarioRecPass":
        code = "EMAIL_ALFANUMERICO_INCORRECTO";
        break;
      case "emailPersonRegister":
        code = "EMAIL_ALFANUMERICO_INCORRECTO";
        break;
    }
    addCodeError(elementIdError, code);
    return false;
  }

  return true;
}

function checkEditUser() {
  if (
    checkUserDNI("input_dni_usuario", "errorFormatoDni", "dniPersona") &&
    checkName(
      "input_nombre_usuario",
      "errorFormatoNombre",
      "nombrePersonaRegistro"
    ) &&
    checkSurname(
      "input_apellidos_usuario",
      "errorFormatoApellidos",
      "apellidosPersonaRegistro"
    ) &&
    checkBirthDate(
      "input_fechaNacimiento_usuario",
      "errorFormatoFecha",
      "fechaPersonaRegistro"
    ) &&
    checkAddress(
      "input_direccion_usuario",
      "errorFormatoDireccion",
      "direccionPersonaRegistro"
    ) &&
    checkPhone(
      "input_telefono_usuario",
      "errorFormatoTelefono",
      "telefonoPersonaRegistro"
    ) &&
    checkEmail(
      "input_email_usuario",
      "errorFormatoEmail",
      "emailPersonaRegistro"
    )
  ) {
    return true;
  } else {
    return false;
  }
}

/** Función que valida el formulario de cambio de contraseña **/
function checkChangePass() {
  if (
    checkPass(
      "passChangePass1",
      "errorFormatoChangePass1",
      "passwordChange"
    ) &&
    checkPass(
      "passChangePass2",
      "errorFormatoChangePass2",
      "passwordChange"
    )
  ) {
    return true;
  } else {
    return false;
  }
}

function checkCredits(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field) &&
    checkMinLength(elementId, 1, elementIdError, field) &&
    checkMaxLength(elementId, 4, elementIdError, field) &&
    checkOnlyNumbers(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkEditProject() {
if (
    checkName('input_nombre_trabajo', 'errorFormatNombreTrabajo', 'nameProject') &&
    checkNotePercent('input_porcentaje_nota', 'errorFormatPorcentajeNota', 'notePercentProject') &&
    checkCorrectionPercent('input_correccion_nota', 'errorFormatCorreccionNota', 'correctionPercentProject') &&
    checkInitDate('input_fecha_ini', 'errorFormatFechaIni', 'correctionInitDateProject') &&
    checkEndDate('input_fecha_fin', 'errorFormatFechaFin', 'correctionEndDateProject') &&
    checkDescription('input_descripcion_trabajo', 'errorFormatDescripcionTrabajo', 'correctionDescriptionProject')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkProject() {
if (checkName('nombreT', 'errorFormatProjectName', 'nameProject') &&
    checkNotePercent('porcentajeNotaT', 'errorFormatProjectNotePercent', 'notePercentProject') &&
    checkCorrectionPercent('porcentajeCorreccionT', 'errorFormatProjectCorrectionPercent', 'correctionPercentProject') &&
    checkInitDate('fechaIniT', 'errorFormatInitDate', 'correctionInitDateProject') &&
    checkEndDate('fechaFinT', 'errorFormatEndDate', 'correctionEndDateProject') &&
    checkDescription('descripcionT', 'errorFormatProjectDescription', 'descriptionProject')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkCompetence() {
if (
    checkName('tituloC', 'errorFormatCompetenceTitle', 'titleCompetence') &&
    checkDescriptionCompetence('descripcionC', 'errorFormatCompetenceDescription', 'descriptionCompetence')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkSubject() {
if (
    checkName(
      "nombreM",
      "errorFormatSubjectName",
      "nameSubject"
    ) &&
    checkCredits(
      "creditosM",
      "errorFormatSubjectCredits",
      "creditsSubject"
    )
  ) {
    if (document.getElementById("select_dni").value != "Seleccione un profesor ppal") {
       return checkUserDNI(
          "select_dni",
          "errorFormatoCategoriaPadre",
          "profesorPpal"
        )
    }
    return true;
  } else {
    return false;
  }
}

function checkDelivery() {
 if (
    checkData(
      "input_datos",
      "errorFormatData",
      "data"
    )
  ) {
    return true;
  } else {
    return false;
  }
}

function checkEditSubject() {
  if (
    checkName(
      "input_nombre_materia",
      "errorFormatSubjectName",
      "nameSubject"
    ) &&
    checkCredits(
      "input_creditos",
      "errorFormatSubjectCredits",
      "creditsSubject"
    )
  ) {
    if (document.getElementById("input_select_dni").value != "") {
       return checkUserDNI(
          "input_select_dni",
          "errorFormatoCategoriaPadre",
          "profesorPpal"
        )
    }
    return true;
  } else {
    return false;
  }
}

function checkSelectElement(elementId, elementIdError, field, acceptedValues, value) {
    document.getElementById(elementId).style.borderWidth = "2px";

    if (
        checkNotEmpty(elementId, elementIdError, field) &&
        checkSelectValue(acceptedValues, value, elementIdError, "VALOR_INCORRECTO")) {
            checkOK(elementId, elementIdError);
            return true;
    } else {
       checkKO(elementId, elementIdError);
       return false;
    }
}

function checkSelectValue(acceptedValues, selectedValue, idElementError, code) {
    if (acceptedValues.includes(selectedValue)) {
        return true;
    } else {
        addCodeError(idElementError, code);
        return false;
    }
}

function checkText(elementId, elementIdError, field) {
    if (document.getElementById(elementId)) {
        document.getElementById(elementId).style.borderWidth = "2px";

        if (checkNotEmpty(elementId, elementIdError, field)) {
           checkOK(elementId, elementIdError);
           return true;
        } else {
           checkKO(elementId, elementIdError);
           return false;
        }
    }
    return true;
}

function checkAssignedCorrections(id_entrega, selectedDelivery) {
    element = true;
    for (const delivery of selectedDelivery) {
        selectElement = document.getElementById('select' + delivery['id_criterio']);
        if(
            checkSelectElement('select' + delivery['id_criterio'], 'errorFormat' + delivery['id_criterio'], 'correccionCriterio', ['0', '1', '3'], selectElement.value) &&
            checkText('textarea' + delivery['id_criterio'], 'errorTextFormat' + delivery['id_criterio'], 'comentarioCorreccionCriterio')
        ) {
            element = true;
        } else {
            element = false;
            break;
        }
    }
    return element;
}


function checkSelectCompetence(elementId, elementIdError, field) {
  document.getElementById(elementId).style.borderWidth = "2px";

  if (
    checkNotEmpty(elementId, elementIdError, field)
  ) {
    checkOK(elementId, elementIdError);
    return true;
  } else {
    checkKO(elementId, elementIdError);
    return false;
  }
}

function checkCompetenceSelected() {
  if (
    checkSelectCompetence('select_id_competencia', 'errorFormatoCategoriaPadre', 'selectCompetence')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkCriteria() {
  if (
    checkDescriptionCriteria('descripcionC', 'errorFormatCriteriaDescription', 'descriptionCriteria')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkEditCriteria() {
  if (
    checkDescriptionCriteria('input_descripcion_criterio', 'errorFormatDescripcionCriterio', 'correctionDescriptionCriteria')
  ) {
    return true;
  } else {
    return false;
  }
}

function checkAssignCorrection() {
    if (
      checkAssignCorrectionManually('input_alumno', 'errorFormatAlumno', 'assignCorrection') &&
      checkEndDateCorrection('input_fecha_fin_correccion', 'errorFormatFechaFinCorreccion', 'endDateCorrection')
    ) {
        return true;
    } else {
        return false;
    }
}

function checkNumAlumnos(elementId, elementIdError, field) {
    document.getElementById(elementId).style.borderWidth = "2px";

    if (
         checkNotEmpty(elementId, elementIdError, field) &&
         checkMinLength(elementId, 1, elementIdError, field) &&
         checkMaxLength(elementId, 2, elementIdError, field) &&
         checkOnlyNumbers(elementId, elementIdError, field)
    ) {
         checkOK(elementId, elementIdError);
         return true;
    } else {
         checkKO(elementId, elementIdError);
         return false;
    }
}

function checkAssignRandomCorrection() {
    if (
      checkNumAlumnos('numeroAlumnos', 'errorNumAlumnos', 'numAlumnos') &&
      checkEndDateCorrection('input_fecha_fin_correccionRandom', 'errorFormatFechaFinCorreccionRandom', 'endDateCorrection')
    ) {
        return true;
    } else {
        return false;
    }
}

function checkAcademicCourse() {
    if (
      checkName('nombreCA', 'errorFormatNameAC', 'academicCourseName')
    ) {
        return true;
    } else {
        return false;
    }
}

function checkEditAcademicCourse() {
  if (
    checkName(
      "input_nombre_curso_academico",
      "errorFormatNombreCursoAcademico",
      "academicCourseName"
    )
  ) {
    return true;
  } else {
    return false;
  }
}