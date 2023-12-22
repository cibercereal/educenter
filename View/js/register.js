function checkRegister() {
    if(checkUserDNI("dniP", "errorFormatDni", "personDni") && 
        checkName("nombreP", "errorFormatNamePerson", "namePersonRegister") &&
        checkSurname("apellidosP", "errorFormatSurnameP", "surnamePersonRegister" ) &&
        checkBirthDate("fechaNacP", "errorFormatDate", "datePersonRegister") &&
        checkAddress("direccionP", "errorFormatAddress", "addressPersonRegister") &&
        checkPhone("telefonoP", "errorFormatPhone","phonePersonRegister") &&
        checkEmail("emailP", "errorFormatEmail", "emailPersonRegister") &&
        checkPass("passwdUsuario1","errorFormatoPassRegistro","passwdUserRegister") &&
        checkPassRep("passwdUsuario2","errorFormatPassRegister2","passwdUserRegister") &&
        verificarPasswd()) {
          encrypt("passwdUsuario1");
          return true;
        }
        return false;
}

async function register() {
    await ajaxPromise(document.formularioRegistro, "register", "auth", "REGISTRAR_USUARIO_OK", false)
      .then((res) => {
        $("#registro-modal").modal("toggle");
  
        ajaxResponseOK("REGISTRAR_USUARIO_OK", res.code);
  
        setLang(getCookie("lang"));
        document.getElementById("modal").style.display = "block";
      })
      .catch((res) => {
        $("#registro-modal").modal("toggle");
        ajaxResponseKO(res.code);
  
        let idElementoList = [
          "dniP",
          "nombreP",
          "apellidosP",
          "fechaNacP",
          "direccionP",
          "telefonoP",
          "emailP",
          "passwdUsuario1",
          "passwdUsuario2",
        ];
        resetForm("formularioRegistro", idElementoList);
        setLang(getCookie("lang"));
        document.getElementById("modal").style.display = "block";
      });
}

function fillSelectRole() {
  var select = $("#select_id_rol");

  select.empty();

  var option1 = document.createElement("option");
  option1.setAttribute("value", "");
  option1.setAttribute("label", "-----");
  option1.setAttribute("class", "-----");
  option1.setAttribute("selected", "true");
  select.append(option1);

  var rolesArrayCookie = ",,DOCENTE,ALUMNO";
  var rolesArray = rolesArrayCookie.split(",");
  var option2 = document.createElement("option");
  var optionTexto = "";

  for (var i = 0; i < rolesArray.length; i++) {
    if (rolesArray[i] != "") {
      option2 = document.createElement("option");
      option2.setAttribute("value", i);
      option2.setAttribute("name", i);
      optionTexto = document.createTextNode(translateWord(rolesArray[i]));
      option2.appendChild(optionTexto);
      select.append(option2);
    }
  }
}