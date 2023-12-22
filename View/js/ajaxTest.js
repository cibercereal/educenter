/**Función para recuperar los test con ajax y promesas*/
function test(code, codeFracaso, controladorTest, actionTest) {
  var lang = getCookie("lang");
  var token = getCookie("token");

  createHideFormNoAction("formularioTest");
  insertField(document.formularioTest, "controller", controladorTest);
  insertField(document.formularioTest, "action", actionTest);

  if (token == null) {
    authenticationError("ACCESO_DENEGADO", lang);
  } else {
    return new Promise(function (resolve, reject) {
      $.ajax({
        method: "POST",
        url: URL_TEST,
        data: $("#formularioTest").serialize(),
        headers: { Authorization: token },
      })
        .done((res) => {
          if (res.code != code && res.code != codeFracaso) {
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////AUTH////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de autenticacion */
async function testAutenticacion(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "autenticacionAtributos";
      switch (accion) {
        case "Login":
          code = "PETICION_TEST_LOGIN_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_LOGIN_ATRIBUTOS_FRACASO";
          actionTest = "login";
          break;
        case "Registro":
          code = "PETICION_TEST_REGISTRO_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_REGISTRO_ATRIBUTOS_FRACASO";
          actionTest = "registrar";
          break;
        case "ObtenerContrasenaCorreo":
          code = "PETICION_TEST_OBTENER_CONTRASENA_CORREO_ATRIBUTOS_EXITO";
          codeFracaso =
            "PETICION_TEST_OBTENER_CONTRASENA_CORREO_ATRIBUTOS_FRACASO";
          actionTest = "obtenerContrasenaCorreo";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "autenticacionAcciones";
      switch (accion) {
        case "Login":
          code = "PETICION_TEST_LOGIN_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_LOGIN_ACCIONES_FRACASO";
          actionTest = "login";
          break;
        case "Registro":
          code = "PETICION_TEST_REGISTRO_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_REGISTRO_ACCIONES_FRACASO";
          actionTest = "registrar";
          break;
        case "ObtenerContrasenaCorreo":
          code = "PETICION_TEST_OBTENER_CONTRASENA_CORREO_ACCIONES_EXITO";
          codeFracaso =
            "PETICION_TEST_OBTENER_CONTRASENA_CORREO_ACCIONES_FRACASO";
          actionTest = "obtenerContrasenaCorreo";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestAuth",
        "iconoTestAutenticacion" + tipoTest,
        "iconoTestAutenticacion" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Autenticacion" + accion,
        "cuerpo" + tipoTest + "Autenticacion" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////GESTION DE ACCIÓN-FUNCIONALIDAD//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

async function testAccionFuncionalidad(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "accionFuncionalidadAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Eliminar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "eliminar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "accionFuncionalidadAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Eliminar":
          code = "PETICION_TEST_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_FRACASO";
          actionTest = "eliminar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestAccionFuncionalidad",
        "iconoTestAccionFuncionalidad" + tipoTest,
        "iconoTestAccionFuncionalidad" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "AccionFuncionalidad" + accion,
        "cuerpo" + tipoTest + "AccionFuncionalidad" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////GESTION DE ROL-ACCIÓN-FUNCIONALIDAD//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

async function testRolAccionFuncionalidad(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "rolAccionFuncionalidadAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Borrar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "eliminar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "rolAccionFuncionalidadAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ACCION_FUNCIONALIDAD_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Borrar":
          code = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ROL_ACCION_FUNCIONALIDAD_ELIMINAR_ACCIONES_FRACASO";
          actionTest = "eliminar";
          break;
      }
      break;
  }
  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestRolAccionFuncionalidad",
        "iconoTestRolAccionFuncionalidad" + tipoTest,
        "iconoTestRolAccionFuncionalidad" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "RolAccionFuncionalidad" + accion,
        "cuerpo" + tipoTest + "RolAccionFuncionalidad" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE USUARIOS///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de usuario */
async function testUsuario(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "usuarioAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_USUARIO_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_USUARIO_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_USUARIO_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_USUARIO_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
        case "VerEnDetalle":
          code = "PETICION_TEST_USUARIO_VERENDETALLE_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_VERENDETALLE_ATRIBUTOS_FRACASO";
          actionTest = "verEnDetalle";
          break;
        case "EditarContrasena":
          code = "PETICION_TEST_USUARIO_EDITARCONTRASENA_ATRIBUTOS_EXITO";
          codeFracaso =
            "PETICION_TEST_USUARIO_EDITARCONTRASENA_ATRIBUTOS_FRACASO";
          actionTest = "editarContrasena";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "usuarioAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_USUARIO_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_USUARIO_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_USUARIO_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_USUARIO_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
        case "VerEnDetalle":
          code = "PETICION_TEST_USUARIO_VERENDETALLE_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_USUARIO_VERENDETALLE_ACCIONES_FRACASO";
          actionTest = "verEnDetalle";
          break;
        case "EditarContrasena":
          code = "PETICION_TEST_USUARIO_EDITARCONTRASENA_ACCIONES_EXITO";
          codeFracaso =
            "PETICION_TEST_USUARIO_EDITARCONTRASENA_ACCIONES_FRACASO";
          actionTest = "editarContrasena";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestUsuario",
        "iconoTestUsuario" + tipoTest,
        "iconoTestUsuario" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Usuario" + accion,
        "cuerpo" + tipoTest + "Usuario" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////GESTION DE MATERIAS//////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

async function testMaterias(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "materiasAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_MATERIAS_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_MATERIAS_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Borrar":
          code = "PETICION_TEST_MATERIAS_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
        case "Modificar":
          code = "PETICION_TEST_MATERIAS_MODIFICAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_MODIFICAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "SolicitarImpartir":
          code = "PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO";
          actionTest = "solicitarImpartir";
          break;
        case "EliminarSolicitarImpartir":
          code = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO";
          actionTest = "eliminarSolicitarImpartir";
          break;
        case "BuscarSolicitarImpartir":
          code = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO";
          actionTest = "buscarSolicitarImpartir";
          break;
        case "AceptarSolicitarImpartir":
          code = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ATRIBUTOS_FRACASO";
          actionTest = "aceptarSolicitarImpartir";
          break;
        case "InsertarSolicitarCursar":
          code = "PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO";
          actionTest = "insertarSolicitarCursar";
          break;
        case "BuscarSolicitarCursar":
          code = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO";
          actionTest = "buscarSolicitarCursar";
          break;
        case "EliminarSolicitarCursar":
          code = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO";
          actionTest = "eliminarSolicitarCursar";
          break;
        case "EditarSolicitarCursar":
          code = "PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ATRIBUTOS_FRACASO";
          actionTest = "editarSolicitarCursar";
          break;
        case "AceptarSolicitarImpartirSecundario":
          code = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ATRIBUTOS_FRACASO";
          actionTest = "aceptarSolicitarImpartirSecundario";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "materiasAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_MATERIAS_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_MATERIAS_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_MATERIAS_MODIFICAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_MODIFICAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_MATERIAS_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_MATERIAS_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
        case "SolicitarImpartir":
         code = "PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_SOLICITAR_IMPARTIR_ACCIONES_FRACASO";
         actionTest = "solicitarImpartir";
         break;
        case "EliminarSolicitarImpartir":
         code = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO";
         actionTest = "eliminarSolicitarImpartir";
         break;
        case "BuscarSolicitarImpartir":
         code = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO";
         actionTest = "buscarSolicitarImpartir";
        break;
        case "InsertarSolicitarCursar":
         code = "PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_INSERTAR_SOLICITAR_CURSAR_ACCIONES_FRACASO";
         actionTest = "insertarSolicitarCursar";
        break;
        case "BuscarSolicitarCursar":
         code = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_BUSCAR_SOLICITAR_CURSAR_ACCIONES_FRACASO";
         actionTest = "buscarSolicitarCursar";
        break;
        case "EliminarSolicitarCursar":
         code = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_ELIMINAR_SOLICITAR_CURSAR_ACCIONES_FRACASO";
         actionTest = "eliminarSolicitarCursar";
        break;
        case "EditarSolicitarCursar":
         code = "PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_EDITAR_SOLICITAR_CURSAR_ACCIONES_FRACASO";
         actionTest = "editarSolicitarCursar";
        break;
        case "AceptarSolicitarImpartir":
         code = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_ACCIONES_FRACASO";
         actionTest = "aceptarSolicitarImpartir";
        break;
        case "AceptarSolicitarImpartirSecundario":
         code = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ACCIONES_EXITO";
         codeFracaso = "PETICION_TEST_MATERIAS_ACEPTAR_SOLICITAR_IMPARTIR_SECUNDARIO_ACCIONES_FRACASO";
         actionTest = "aceptarSolicitarImpartirSecundario";
        break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestMaterias",
        "iconoTestMaterias" + tipoTest,
        "iconoTestMaterias" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Materias" + accion,
        "cuerpo" + tipoTest + "Materias" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////GESTION DE CURSO ACADEMICO//////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

async function testCursoAcademico(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "cursoAcademicoAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_CURSO_ACADEMICO_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CURSO_ACADEMICO_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "cursoAcademicoAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_CURSO_ACADEMICO_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CURSO_ACADEMICO_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CURSO_ACADEMICO_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCursoAcademico",
        "iconoTestCursoAcademico" + tipoTest,
        "iconoTestCursoAcademico" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "CursoAcademico" + accion,
        "cuerpo" + tipoTest + "CursoAcademico" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE TRABAJOS///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de trabajos */
async function testTrabajos(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "trabajosAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_TRABAJOS_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_TRABAJOS_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_TRABAJOS_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_TRABAJOS_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "trabajosAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_TRABAJOS_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_TRABAJOS_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_TRABAJOS_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_TRABAJOS_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_TRABAJOS_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestTrabajos",
        "iconoTestTrabajos" + tipoTest,
        "iconoTestTrabajos" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Trabajos" + accion,
        "cuerpo" + tipoTest + "Trabajos" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE COMPETENCIAS///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de competencias */
async function testCompetencias(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "competenciasAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_COMPETENCIAS_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_COMPETENCIAS_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_COMPETENCIAS_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_COMPETENCIAS_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
        case "Asignar":
          code = "PETICION_TEST_COMPETENCIAS_ASIGNAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_ASIGNAR_ATRIBUTOS_FRACASO";
          actionTest = "asignar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "competenciasAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_COMPETENCIAS_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_COMPETENCIAS_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_COMPETENCIAS_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_COMPETENCIAS_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
        case "Asignar":
          code = "PETICION_TEST_COMPETENCIAS_ASIGNAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_COMPETENCIAS_ASIGNAR_ACCIONES_FRACASO";
          actionTest = "asignar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCompetencias",
        "iconoTestCompetencias" + tipoTest,
        "iconoTestCompetencias" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Competencias" + accion,
        "cuerpo" + tipoTest + "Competencias" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE ENTREGAS///////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de entregas */
async function testEntrega(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "entregaAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ENTREGA_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ENTREGA_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_ENTREGA_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_ENTREGA_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "entregaAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_ENTREGA_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_ENTREGA_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_ENTREGA_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_ENTREGA_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_ENTREGA_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestEntrega",
        "iconoTestEntrega" + tipoTest,
        "iconoTestEntrega" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Entrega" + accion,
        "cuerpo" + tipoTest + "Entrega" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE CRITERIOS//////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de criterios */
async function testCriterio(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "criterioAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CRITERIO_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CRITERIO_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_CRITERIO_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CRITERIO_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "criterioAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CRITERIO_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CRITERIO_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Modificar":
          code = "PETICION_TEST_CRITERIO_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CRITERIO_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIO_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCriterio",
        "iconoTestCriterio" + tipoTest,
        "iconoTestCriterio" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "Criterio" + accion,
        "cuerpo" + tipoTest + "Criterio" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE CRITERIO-COMPETENCIA///////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de criterio-competencia */
async function testCriterioCompetencia(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "criterioCompetenciaAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ATRIBUTOS_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "criterioCompetenciaAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Borrar":
          code = "PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CRITERIOCOMPETENCIA_BORRAR_ACCIONES_FRACASO";
          actionTest = "borrar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCriterioCompetencia",
        "iconoTestCriterioCompetencia" + tipoTest,
        "iconoTestCriterioCompetencia" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "CriterioCompetencia" + accion,
        "cuerpo" + tipoTest + "CriterioCompetencia" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE CORRECCIÓN CRITERIO////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de corrección criterio */
async function testCorreccionCriterio(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "correccionCriterioAtributos";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ATRIBUTOS_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "AsignarAleatorio":
          code = "PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ATRIBUTOS_FRACASO";
          actionTest = "assignRandom";
          break;
        case "Editar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "edit";
          break;
        case "EditarDocente":
          code = "PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ATRIBUTOS_FRACASO";
          actionTest = "editarDocente";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "correccionCriterioAcciones";
      switch (accion) {
        case "Insertar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_INSERTAR_ACCIONES_FRACASO";
          actionTest = "insertar";
          break;
        case "Buscar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "AsignarAleatorio":
          code = "PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_ASIGNARALEATORIO_ACCIONES_FRACASO";
          actionTest = "assignRandom";
          break;
        case "Editar":
          code = "PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "EditarDocente":
          code = "PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONCRITERIO_EDITARDOCENTE_ACCIONES_FRACASO";
          actionTest = "editarDocente";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCorreccionCriterio",
        "iconoTestCorreccionCriterio" + tipoTest,
        "iconoTestCorreccionCriterio" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "CorreccionCriterio" + accion,
        "cuerpo" + tipoTest + "CorreccionCriterio" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE CORRECCIÓN PROFESOR////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de corrección docente */
async function testCorreccionDocente(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "correccionDocenteAtributos";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Eliminar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ATRIBUTOS_FRACASO";
          actionTest = "eliminar";
          break;
        case "Editar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "MostrarCorreccion":
          code = "PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ATRIBUTOS_FRACASO";
          actionTest = "mostrarCorreccion";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "correccionDocenteAcciones";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Eliminar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_ELIMINAR_ACCIONES_FRACASO";
          actionTest = "eliminar";
          break;
        case "Editar":
          code = "PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "MostrarCorreccion":
          code = "PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_CORRECCIONDOCENTE_MOSTRARCORRECCION_ACCIONES_FRACASO";
          actionTest = "mostrarCorreccion";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestCorreccionDocente",
        "iconoTestCorreccionDocente" + tipoTest,
        "iconoTestCorreccionDocente" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "CorreccionDocente" + accion,
        "cuerpo" + tipoTest + "CorreccionDocente" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE NOTAS CRITERIO/////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de notas criterio */
async function testNotasCriterio(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "notasCriterioAtributos";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_NOTASCRITERIO_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Editar":
          code = "PETICION_TEST_NOTASCRITERIO_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Anadir":
          code = "PETICION_TEST_NOTASCRITERIO_ANADIR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_ANADIR_ATRIBUTOS_FRACASO";
          actionTest = "anadir";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "notasCriterioAcciones";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_NOTASCRITERIO_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Editar":
          code = "PETICION_TEST_NOTASCRITERIO_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Anadir":
          code = "PETICION_TEST_NOTASCRITERIO_ANADIR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCRITERIO_ANADIR_ACCIONES_FRACASO";
          actionTest = "anadir";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestNotasCriterio",
        "iconoTestNotasCriterio" + tipoTest,
        "iconoTestNotasCriterio" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "NotasCriterio" + accion,
        "cuerpo" + tipoTest + "NotasCriterio" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////GESTION DE NOTAS COMPETENCIA//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Función que obtiene los test de notas competencia */
async function testNotasCompetencia(accion, tipoTest) {
  imagenErrorTestOcultar();

  var code = "";
  var codeFracaso = "";
  var controladorTest = "";
  var actionTest = "";

  switch (tipoTest) {
    case "Atributos":
      controladorTest = "notasCompetenciaAtributos";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ATRIBUTOS_FRACASO";
          actionTest = "buscar";
          break;
        case "Editar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ATRIBUTOS_FRACASO";
          actionTest = "editar";
          break;
        case "Visualizar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ATRIBUTOS_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ATRIBUTOS_FRACASO";
          actionTest = "visualizar";
          break;
      }
      break;
    case "Acciones":
      controladorTest = "notasCompetenciaAcciones";
      switch (accion) {
        case "Buscar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_BUSCAR_ACCIONES_FRACASO";
          actionTest = "buscar";
          break;
        case "Editar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_EDITAR_ACCIONES_FRACASO";
          actionTest = "editar";
          break;
        case "Visualizar":
          code = "PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ACCIONES_EXITO";
          codeFracaso = "PETICION_TEST_NOTASCOMPETENCIA_VISUALIZAR_ACCIONES_FRACASO";
          actionTest = "visualizar";
          break;
      }
      break;
  }

  await test(code, codeFracaso, controladorTest, actionTest)
    .then((res) => {
      let idElementoList = [
        "iconoTestNotasCompetencia",
        "iconoTestNotasCompetencia" + tipoTest,
        "iconoTestNotasCompetencia" + tipoTest + accion,
      ];
      cargarRespuestaOkTest(
        res.datos,
        "cabecera" + tipoTest + "NotasCompetencia" + accion,
        "cuerpo" + tipoTest + "NotasCompetencia" + accion,
        "",
        "",
        idElementoList,
        tipoTest.toLowerCase()
      );
    })
    .catch((res) => {
      cargarModalErroresTest();
    });
  removeFields();
}