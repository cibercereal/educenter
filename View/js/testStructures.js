/*Función para generar estructura básica de los test*/
function createTest(arrayDatosAccordion) {
  var aUno = "";

  if (arrayDatosAccordion[2] === null) {
    aUno =
      '<a class="collapsed card-link" data-toggle="collapse" href="#' +
      arrayDatosAccordion[1] +
      '">' +
      " " +
      arrayDatosAccordion[3] +
      " " +
      "</a>";
  } else {
    aUno =
      '<a class="collapsed card-link" data-toggle="collapse" href="#' +
      arrayDatosAccordion[1] +
      '"  onclick="' +
      arrayDatosAccordion[2] +
      '">' +
      " " +
      arrayDatosAccordion[3] +
      " " +
      "</a>";
  }

  var cardHeaderUno =
    '<div class="card-header">' +
    aUno +
    '<img class="iconTab" id="' +
    arrayDatosAccordion[4] +
    ' src="Resources/failed.png" hidden>' +
    "</div>";

  var cardsUno = "";

  if (arrayDatosAccordion[2] === null) {
    var arrayUno = arrayDatosAccordion[7];
    cardsUno = creaCards(arrayUno);
  } else {
    cardsUno = creaTableResponsive(
      arrayDatosAccordion[5],
      arrayDatosAccordion[6]
    );
  }

  var aDos = "";

  if (arrayDatosAccordion[9] === null) {
    aDos =
      '<a class="collapsed card-link" data-toggle="collapse" href="#' +
      arrayDatosAccordion[8] +
      '">' +
      " " +
      arrayDatosAccordion[10] +
      " " +
      "</a>";
  } else {
    aDos =
      '<a class="collapsed card-link" data-toggle="collapse" href="#' +
      arrayDatosAccordion[8] +
      '"  onclick="' +
      arrayDatosAccordion[9] +
      '">' +
      " " +
      arrayDatosAccordion[10] +
      " " +
      "</a>";
  }

  var cardHeaderDos =
    '<div class="card-header">' +
    aDos +
    '<img class="iconTab" id="' +
    arrayDatosAccordion[11] +
    ' src="Resources/failed.png" hidden>' +
    "</div>";

  var cardsDos = "";

  if (arrayDatosAccordion[9] === null) {
    var arrayDos = arrayDatosAccordion[14];
    cardsDos = creaCards(arrayDos);
  } else {
    cardsDos = creaTableResponsive(
      arrayDatosAccordion[12],
      arrayDatosAccordion[13]
    );
  }

  var contenidoTest =
    '<div id="' +
    arrayDatosAccordion[0] +
    '">' +
    '<div class="card">' +
    cardHeaderUno +
    '<div id="' +
    arrayDatosAccordion[1] +
    '" class="collapse" data-parent="#' +
    arrayDatosAccordion[0] +
    '">' +
    '<div class="card-body">' +
    cardsUno +
    "</div>" +
    "</div>" +
    cardHeaderDos +
    '<div id="' +
    arrayDatosAccordion[8] +
    '" class="collapse" data-parent="#' +
    arrayDatosAccordion[0] +
    '">' +
    '<div class="card-body">' +
    cardsDos +
    "</div>" +
    "</div>" +
    " </div>" +
    "</div>";

  return contenidoTest;
}

/*Función para crear los cards*/
function creaCards(arrayDatos) {
  var cards = "";

  for (let step = 1; step < arrayDatos.length; step++) {
    var array = arrayDatos[step];

    cards =
      cards +
      '<div class="card">' +
      '<div class="card-header">' +
      '<a class="collapsed card-link" data-toggle="collapse" href="#' +
      array[0] +
      '" onclick="' +
      array[1] +
      '">' +
      " " +
      array[2] +
      " " +
      "</a>" +
      '<img class="iconTab" id="' +
      array[3] +
      '" src="Resources/failed.png" hidden>' +
      "</div>" +
      '<div id="' +
      array[0] +
      '" class="collapse" data-parent="#' +
      arrayDatos[0] +
      '">' +
      '<div class="card-body">' +
      '<div class="table-responsive controlTamTabla">' +
      '<table class="table table-bordered">' +
      '<thead class="cabeceraTablasTest" id="' +
      array[4] +
      '"></thead>' +
      '<tbody id="' +
      array[5] +
      '"></tbody>' +
      "</table>" +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>";
  }

  var resultCards = '<div id="' + arrayDatos[0] + '">' + cards + "</div>";

  return resultCards;
}

/*Función que crea la tabla responsive si no tenemos subniveles*/
function creaTableResponsive(idCabecera, idCuerpo) {
  var table =
    '<div class="table-responsive">' +
    '<table class="table table-bordered">' +
    '<thead class="cabeceraTablasTest" id="' +
    idCabecera +
    '"></thead>' +
    '<tbody id="' +
    idCuerpo +
    '"></tbody>' +
    "</table>" +
    "</div>";
  return table;
}

/*Función para cargar las opciones de Tests de Autenticacion*/
function cargarTestAutenticaciones() {
  $("#testAutenticacion").html("");

  let arraySubAccordionUno = [
    "collapseAtributosLoginAutenticacion",
    "javascript:testAutenticacion('Login', 'Atributos')",
    "Login",
    "iconoTestAutenticacionAtributosLogin",
    "cabeceraAtributosAutenticacionLogin",
    "cuerpoAtributosAutenticacionLogin",
  ];
  let arraySubAccordionDos = [
    "collapseAtributosRegistroAutenticacion",
    "javascript:testAutenticacion('Registro', 'Atributos')",
    "Registro",
    "iconoTestAutenticacionAtributosRegistro",
    "cabeceraAtributosAutenticacionRegistro",
    "cuerpoAtributosAutenticacionRegistro",
  ];
  let arraySubAccordionTres = [
    "collapseAutenticacionAtributoObtenerContrasenaCorreo",
    "javascript:testAutenticacion('ObtenerContrasenaCorreo', 'Atributos')",
    "Obtener contraseña",
    "iconoTestAutenticacionAtributosObtenerContrasenaCorreo",
    "cabeceraAtributosAutenticacionObtenerContrasenaCorreo",
    "cuerpoAtributosAutenticacionObtenerContrasenaCorreo",
  ];
  let arrayAccordionUno = [
    "accordion3",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres
  ];

  let arraySubAccordionCuatro = [
    "collapseAutenticacionAccionesLogin",
    "javascript:testAutenticacion('Login', 'Acciones')",
    "Login",
    "iconoTestAutenticacionAccionesLogin",
    "cabeceraAccionesAutenticacionLogin",
    "cuerpoAccionesAutenticacionLogin",
  ];
  let arraySubAccordionCinco = [
    "collapseAutenticacionAccionesRegistro",
    "javascript:testAutenticacion('Registro', 'Acciones')",
    "Registro",
    "iconoTestAutenticacionAccionesRegistro",
    "cabeceraAccionesAutenticacionRegistro",
    "cuerpoAccionesAutenticacionRegistro",
  ];
  let arraySubAccordionSeis = [
    "collapseAutenticacionAccionesObtenerContrasenaCorreo",
    "javascript:testAutenticacion('ObtenerContrasenaCorreo', 'Acciones')",
    "Obtener contraseña",
    "iconoTestAutenticacionAccionesObtenerContrasenaCorreo",
    "cabeceraAccionesAutenticacionObtenerContrasenaCorreo",
    "cuerpoAccionesAutenticacionObtenerContrasenaCorreo",
  ];
  let arrayAccordionDos = [
    "accordion4",
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
    arraySubAccordionSeis
  ];

  let arrayAccordionTres = [
    "accordion2",
    "collapseAutenticacionAtributos",
    null,
    "Atributos",
    "iconoTestAutenticacionAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseAutenticacionAcciones",
    null,
    "Acciones",
    "iconoTestAutenticacionAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testAutenticacion").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Acción-Funcionalidad*/
function cargarTestGestionAccionFuncionalidad() {
  $("#testAccionFuncionalidad").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarAccionFuncionalidad",
    "javascript:testAccionFuncionalidad('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestAccionFuncionalidadAtributosInsertar",
    "cabeceraAtributosAccionFuncionalidadInsertar",
    "cuerpoAtributosAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseAccionFuncionalidadAtributoBuscar",
    "javascript:testAccionFuncionalidad('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestAccionFuncionalidadAtributosBuscar",
    "cabeceraAtributosAccionFuncionalidadBuscar",
    "cuerpoAtributosAccionFuncionalidadBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseAccionFuncionalidadAtributoEliminar",
    "javascript:testAccionFuncionalidad('Eliminar', 'Atributos')",
    "Eliminar",
    "iconoTestAccionFuncionalidadAtributosEliminar",
    "cabeceraAtributosAccionFuncionalidadEliminar",
    "cuerpoAtributosAccionFuncionalidadEliminar",
  ];
  let arrayAccordionUno = [
    "accordion7",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
  ];

  let arraySubAccordionSiete = [
    "collapseAccionFuncionalidadAccionesInsertar",
    "javascript:testAccionFuncionalidad('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestAccionFuncionalidadAccionesInsertar",
    "cabeceraAccionesAccionFuncionalidadInsertar",
    "cuerpoAccionesAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionOcho = [
    "collapseAccionFuncionalidadAccionesBuscar",
    "javascript:testAccionFuncionalidad('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestAccionFuncionalidadAccionesBuscar",
    "cabeceraAccionesAccionFuncionalidadBuscar",
    "cuerpoAccionesAccionFuncionalidadBuscar",
  ];
  let arraySubAccordionNueve = [
    "collapseAccionFuncionalidadAccionesEliminar",
    "javascript:testAccionFuncionalidad('Eliminar', 'Acciones')",
    "Eliminar",
    "iconoTestAccionFuncionalidadAccionesEliminar",
    "cabeceraAccionesAccionFuncionalidadEliminar",
    "cuerpoAccionesAccionFuncionalidadEliminar",
  ];
  let arrayAccordionDos = [
    "accordion8",
    arraySubAccordionSiete,
    arraySubAccordionOcho,
    arraySubAccordionNueve
  ];

  let arrayAccordionTres = [
    "accordion6",
    "collapseAccionFuncionalidadAtributos",
    null,
    "Atributos",
    "iconoTestAccionFuncionalidadAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseAccionFuncionalidadAcciones",
    null,
    "Acciones",
    "iconoTestAccionFuncionalidadAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testAccionFuncionalidad").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Funcionalidades*/
function cargarTestGestionFuncionalidades() {
  $("#testFuncionalidad").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarFuncionalidad",
    "javascript:testFuncionalidad('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestFuncionalidadAtributosInsertar",
    "cabeceraAtributosFuncionalidadInsertar",
    "cuerpoAtributosFuncionalidadInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseFuncionalidadAtributoBuscar",
    "javascript:testFuncionalidad('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestFuncionalidadAtributosBuscar",
    "cabeceraAtributosFuncionalidadBuscar",
    "cuerpoAtributosFuncionalidadBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseFuncionalidadAtributoModificar",
    "javascript:testFuncionalidad('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestFuncionalidadAtributosModificar",
    "cabeceraAtributosFuncionalidadModificar",
    "cuerpoAtributosFuncionalidadModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarFuncionalidad",
    "javascript:testFuncionalidad('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestFuncionalidadAtributosBorrar",
    "cabeceraAtributosFuncionalidadBorrar",
    "cuerpoAtributosFuncionalidadBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseFuncionalidadAtributoVerEnDetalle",
    "javascript:testFuncionalidad('VerEnDetalle', 'Atributos')",
    "Ver en detalle",
    "iconoTestFuncionalidadAtributosVerEnDetalle",
    "cabeceraAtributosFuncionalidadVerEnDetalle",
    "cuerpoAtributosFuncionalidadVerEnDetalle",
  ];
  let arrayAccordionUno = [
    "accordion10",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
  ];

  let arraySubAccordionSeis = [
    "collapseFuncionalidadAccionesInsertar",
    "javascript:testFuncionalidad('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestFuncionalidadAccionesInsertar",
    "cabeceraAccionesFuncionalidadInsertar",
    "cuerpoAccionesFuncionalidadInsertar",
  ];
  let arraySubAccordionSiete = [
    "collapseFuncionalidadAccionesBuscar",
    "javascript:testFuncionalidad('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestFuncionalidadAccionesBuscar",
    "cabeceraAccionesFuncionalidadBuscar",
    "cuerpoAccionesFuncionalidadBuscar",
  ];
  let arraySubAccordionOcho = [
    "collapseFuncionalidadAccionesModificar",
    "javascript:testFuncionalidad('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestFuncionalidadAccionesModificar",
    "cabeceraAccionesFuncionalidadModificar",
    "cuerpoAccionesFuncionalidadModificar",
  ];
  let arraySubAccordionNueve = [
    "collapseFuncionalidadcAcionesBorrar",
    "javascript:testFuncionalidad('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestFuncionalidadAccionesBorrar",
    "cabeceraAccionesFuncionalidadBorrar",
    "cuerpoAccionesFuncionalidadBorrar",
  ];
  let arrayAccordionDos = [
    "accordion11",
    arraySubAccordionSeis,
    arraySubAccordionSiete,
    arraySubAccordionOcho,
    arraySubAccordionNueve,
  ];

  let arrayAccordionTres = [
    "accordion9",
    "collapseFuncionalidadAtributos",
    null,
    "Atributos",
    "iconoTestFuncionalidadAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseFuncionalidadAcciones",
    null,
    "Acciones",
    "iconoTestFuncionalidadAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testFuncionalidad").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Acciones*/
function cargarTestGestionAcciones() {
  $("#testAccion").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarAccion",
    "javascript:testAccion('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestAccionAtributosInsertar",
    "cabeceraAtributosAccionInsertar",
    "cuerpoAtributosAccionInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseAccionAtributoBuscar",
    "javascript:testAccion('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestAccionAtributosBuscar",
    "cabeceraAtributosAccionBuscar",
    "cuerpoAtributosAccionBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseAccionAtributoModificar",
    "javascript:testAccion('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestAccionAtributosModificar",
    "cabeceraAtributosAccionModificar",
    "cuerpoAtributosAccionModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarAccion",
    "javascript:testAccion('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestAccionAtributosBorrar",
    "cabeceraAtributosAccionBorrar",
    "cuerpoAtributosAccionBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseAccionAtributoVerEnDetalle",
    "javascript:testAccion('VerEnDetalle', 'Atributos')",
    "Ver en detalle",
    "iconoTestAccionAtributosVerEnDetalle",
    "cabeceraAtributosAccionVerEnDetalle",
    "cuerpoAtributosAccionVerEnDetalle",
  ];
  let arrayAccordionUno = [
    "accordion13",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
  ];

  let arraySubAccordionSeis = [
    "collapseAccionAccionesInsertar",
    "javascript:testAccion('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestAccionAccionesInsertar",
    "cabeceraAccionesAccionInsertar",
    "cuerpoAccionesAccionInsertar",
  ];
  let arraySubAccordionSiete = [
    "collapseAccionAccionesBuscar",
    "javascript:testAccion('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestAccionAccionesBuscar",
    "cabeceraAccionesAccionBuscar",
    "cuerpoAccionesAccionBuscar",
  ];
  let arraySubAccordionOcho = [
    "collapseAccionAccionesModificar",
    "javascript:testAccion('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestAccionAccionesModificar",
    "cabeceraAccionesAccionModificar",
    "cuerpoAccionesAccionModificar",
  ];
  let arraySubAccordionNueve = [
    "collapseAccionAccionesBorrar",
    "javascript:testAccion('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestAccionAccionesBorrar",
    "cabeceraAccionesAccionBorrar",
    "cuerpoAccionesAccionBorrar",
  ];
  let arrayAccordionDos = [
    "accordion14",
    arraySubAccordionSeis,
    arraySubAccordionSiete,
    arraySubAccordionOcho,
    arraySubAccordionNueve,
  ];

  let arrayAccordionTres = [
    "accordion12",
    "collapseAccionAtributos",
    null,
    "Atributos",
    "iconoTestAccionAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseAccionAcciones",
    null,
    "Acciones",
    "iconoTestAccionAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testAccion").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Permisos*/
function cargarTestGestionRolAccionFuncionalidad() {
  $("#testRolAccionFuncionalidad").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarRolAccionFuncionalidad",
    "javascript:testRolAccionFuncionalidad('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestRolAccionFuncionalidadAtributosInsertar",
    "cabeceraAtributosRolAccionFuncionalidadInsertar",
    "cuerpoAtributosRolAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseRolAccionFuncionalidadAtributoBuscar",
    "javascript:testRolAccionFuncionalidad('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestRolAccionFuncionalidadAtributosBuscar",
    "cabeceraAtributosRolAccionFuncionalidadBuscar",
    "cuerpoAtributosRolAccionFuncionalidadBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseAtributosBorrarRolAccionFuncionalidad",
    "javascript:testRolAccionFuncionalidad('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestRolAccionFuncionalidadAtributosBorrar",
    "cabeceraAtributosRolAccionFuncionalidadBorrar",
    "cuerpoAtributosRolAccionFuncionalidadBorrar",
  ];
  let arrayAccordionUno = [
    "accordion16",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
  ];

  let arraySubAccordionCuatro = [
    "collapseRolAccionFuncionalidadAccionesInsertar",
    "javascript:testRolAccionFuncionalidad('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestRolAccionFuncionalidadAccionesInsertar",
    "cabeceraAccionesRolAccionFuncionalidadInsertar",
    "cuerpoAccionesRolAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionCinco = [
    "collapseRolAccionFuncionalidadAccionesBorrar",
    "javascript:testRolAccionFuncionalidad('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestAccionAccionesBorrar",
    "cabeceraAccionesRolAccionFuncionalidadBorrar",
    "cuerpoAccionesRolAccionFuncionalidadBorrar",
  ];
  let arrayAccordionDos = [
    "accordion17",
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
  ];

  let arrayAccordionTres = [
    "accordion15",
    "collapseRolAccionFuncionalidadAtributos",
    null,
    "Atributos",
    "iconoTestAccionAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseRolAccionFuncionalidadAcciones",
    null,
    "Acciones",
    "iconoTestRolAccionFuncionalidadAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testRolAccionFuncionalidad").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Usuarios*/
function loadUserManagementTest() {
  $("#testUsuario").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarUsuario",
    "javascript:testUsuario('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestUsuarioAtributosInsertar",
    "cabeceraAtributosUsuarioInsertar",
    "cuerpoAtributosUsuarioInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseUsuarioAtributoBuscar",
    "javascript:testUsuario('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestUsuarioAtributosBuscar",
    "cabeceraAtributosUsuarioBuscar",
    "cuerpoAtributosUsuarioBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseUsuarioAtributoModificar",
    "javascript:testUsuario('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestUsuarioAtributosModificar",
    "cabeceraAtributosUsuarioModificar",
    "cuerpoAtributosUsuarioModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarUsuario",
    "javascript:testUsuario('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestUsuarioAtributosBorrar",
    "cabeceraAtributosUsuarioBorrar",
    "cuerpoAtributosUsuarioBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseUsuarioAtributoVerEnDetalle",
    "javascript:testUsuario('VerEnDetalle', 'Atributos')",
    "Ver en detalle",
    "iconoTestUsuarioAtributosVerEnDetalle",
    "cabeceraAtributosUsuarioVerEnDetalle",
    "cuerpoAtributosUsuarioVerEnDetalle",
  ];
  let arraySubAccordionSeis = [
    "collapseUsuarioAtributoEditarContrasena",
    "javascript:testUsuario('EditarContrasena', 'Atributos')",
    "EditarContrasena",
    "iconoTestUsuarioAtributosEditarContrasena",
    "cabeceraAtributosUsuarioEditarContrasena",
    "cuerpoAtributosUsuarioEditarContrasena",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
    arraySubAccordionSeis
  ];

  let arraySubAccordionOcho = [
    "collapseUsuarioAccionesInsertar",
    "javascript:testUsuario('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestUsuarioAccionesInsertar",
    "cabeceraAccionesUsuarioInsertar",
    "cuerpoAccionesUsuarioInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseUsuarioAccionesBuscar",
    "javascript:testUsuario('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestUsuarioAccionesBuscar",
    "cabeceraAccionesUsuarioBuscar",
    "cuerpoAccionesUsuarioBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseUsuarioAccionesModificar",
    "javascript:testUsuario('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestUsuarioAccionesModificar",
    "cabeceraAccionesUsuarioModificar",
    "cuerpoAccionesUsuarioModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseUsuarioAccionesBorrar",
    "javascript:testUsuario('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestUsuarioAccionesBorrar",
    "cabeceraAccionesUsuarioBorrar",
    "cuerpoAccionesUsuarioBorrar",
  ];
  let arraySubAccordionDoce = [
    "collapseUsuarioAccionesVerEnDetalle",
    "javascript:testUsuario('VerEnDetalle', 'Acciones')",
    "Ver en detalle",
    "iconoTestUsuarioAccionesVerEnDetalle",
    "cabeceraAccionesUsuarioVerEnDetalle",
    "cuerpoAccionesUsuarioVerEnDetalle",
  ];
  let arraySubAccordionTrece = [
    "collapseUsuarioAccionesEditarContrasena",
    "javascript:testUsuario('EditarContrasena', 'Acciones')",
    "EditarContrasena",
    "iconoTestUsuarioAccionesEditarContrasena",
    "cabeceraAccionesUsuarioEditarContrasena",
    "cuerpoAccionesUsuarioEditarContrasena",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
    arraySubAccordionDoce,
    arraySubAccordionTrece
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseUsuarioAtributos",
    null,
    "Atributos",
    "iconoTestUsuarioAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseUsuarioAcciones",
    null,
    "Acciones",
    "iconoTestUsuarioAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testUsuario").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de RolAccionFuncionalidads*/
function cargarTestGestionRolAccionFuncionalidad() {
  $("#testRolAccionFuncionalidad").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarRolAccionFuncionalidad",
    "javascript:testRolAccionFuncionalidad('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestRolAccionFuncionalidadAtributosInsertar",
    "cabeceraAtributosRolAccionFuncionalidadInsertar",
    "cuerpoAtributosRolAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseRolAccionFuncionalidadAtributoBuscar",
    "javascript:testRolAccionFuncionalidad('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestRolAccionFuncionalidadAtributosBuscar",
    "cabeceraAtributosRolAccionFuncionalidadBuscar",
    "cuerpoAtributosRolAccionFuncionalidadBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseAtributosBorrarRolAccionFuncionalidad",
    "javascript:testRolAccionFuncionalidad('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestRolAccionFuncionalidadAtributosBorrar",
    "cabeceraAtributosRolAccionFuncionalidadBorrar",
    "cuerpoAtributosRolAccionFuncionalidadBorrar",
  ];
  let arrayAccordionUno = [
    "accordion22",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
  ];

  let arraySubAccordionOcho = [
    "collapseRolAccionFuncionalidadAccionesInsertar",
    "javascript:testRolAccionFuncionalidad('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestRolAccionFuncionalidadAccionesInsertar",
    "cabeceraAccionesRolAccionFuncionalidadInsertar",
    "cuerpoAccionesRolAccionFuncionalidadInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseRolAccionFuncionalidadAccionesBuscar",
    "javascript:testRolAccionFuncionalidad('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestRolAccionFuncionalidadAccionesBuscar",
    "cabeceraAccionesRolAccionFuncionalidadBuscar",
    "cuerpoAccionesRolAccionFuncionalidadBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseRolAccionFuncionalidadAccionesBorrar",
    "javascript:testRolAccionFuncionalidad('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestRolAccionFuncionalidadAccionesBorrar",
    "cabeceraAccionesRolAccionFuncionalidadBorrar",
    "cuerpoAccionesRolAccionFuncionalidadBorrar",
  ];
  let arrayAccordionDos = [
    "accordion23",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
  ];

  let arrayAccordionTres = [
    "accordion21",
    "collapseRolAccionFuncionalidadAtributos",
    null,
    "Atributos",
    "iconoTestRolAccionFuncionalidadAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseRolAccionFuncionalidadAcciones",
    null,
    "Acciones",
    "iconoTestRolAccionFuncionalidadAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testRolAccionFuncionalidad").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Materias*/
function cargarTestGestionMaterias() {
  $("#testMaterias").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarMaterias",
    "javascript:testMaterias('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestMateriasAtributosInsertar",
    "cabeceraAtributosMateriasInsertar",
    "cuerpoAtributosMateriasInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseMateriasAtributoBuscar",
    "javascript:testMaterias('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestMateriasAtributosBuscar",
    "cabeceraAtributosMateriasBuscar",
    "cuerpoAtributosMateriasBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseMateriasAtributoModificar",
    "javascript:testMaterias('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestMateriasAtributosModificar",
    "cabeceraAtributosMateriasModificar",
    "cuerpoAtributosMateriasModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarMaterias",
    "javascript:testMaterias('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestMateriasAtributosBorrar",
    "cabeceraAtributosMateriasBorrar",
    "cuerpoAtributosMateriasBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosSolicitarImpartirMaterias",
    "javascript:testMaterias('SolicitarImpartir', 'Atributos')",
    "SolicitarImpartir",
    "iconoTestMateriasAtributosSolicitarImpartir",
    "cabeceraAtributosMateriasSolicitarImpartir",
    "cuerpoAtributosMateriasSolicitarImpartir",
  ];
  let arraySubAccordionSeis = [
    "collapseAtributosEliminarSolicitarImpartirMaterias",
    "javascript:testMaterias('EliminarSolicitarImpartir', 'Atributos')",
    "EliminarSolicitarImpartir",
    "iconoTestMateriasAtributosEliminarSolicitarImpartir",
    "cabeceraAtributosMateriasEliminarSolicitarImpartir",
    "cuerpoAtributosMateriasEliminarSolicitarImpartir",
  ];
  let arraySubAccordionSiete = [
    "collapseAtributosBuscarSolicitarImpartirMaterias",
    "javascript:testMaterias('BuscarSolicitarImpartir', 'Atributos')",
    "BuscarSolicitarImpartir",
    "iconoTestMateriasAtributosBuscarSolicitarImpartir",
    "cabeceraAtributosMateriasBuscarSolicitarImpartir",
    "cuerpoAtributosMateriasBuscarSolicitarImpartir",
  ];
  let arraySubAccordionOcho1 = [
    "collapseAtributosInsertarSolicitarCursarMaterias",
    "javascript:testMaterias('InsertarSolicitarCursar', 'Atributos')",
    "InsertarSolicitarCursar",
    "iconoTestMateriasAtributosInsertarSolicitarCursar",
    "cabeceraAtributosMateriasInsertarSolicitarCursar",
    "cuerpoAtributosMateriasInsertarSolicitarCursar",
  ];
  let arraySubAccordionOcho2 = [
    "collapseAtributosBuscarSolicitarCursarMaterias",
    "javascript:testMaterias('BuscarSolicitarCursar', 'Atributos')",
    "BuscarSolicitarCursar",
    "iconoTestMateriasAtributosBuscarSolicitarCursar",
    "cabeceraAtributosMateriasBuscarSolicitarCursar",
    "cuerpoAtributosMateriasBuscarSolicitarCursar",
  ];
  let arraySubAccordionOcho3 = [
    "collapseAtributosEliminarSolicitarCursarMaterias",
    "javascript:testMaterias('EliminarSolicitarCursar', 'Atributos')",
    "EliminarSolicitarCursar",
    "iconoTestMateriasAtributosEliminarSolicitarCursar",
    "cabeceraAtributosMateriasEliminarSolicitarCursar",
    "cuerpoAtributosMateriasEliminarSolicitarCursar",
  ];
  let arraySubAccordionOcho4 = [
    "collapseAtributosEditarSolicitarCursarMaterias",
    "javascript:testMaterias('EditarSolicitarCursar', 'Atributos')",
    "EditarSolicitarCursar",
    "iconoTestMateriasAtributosEditarSolicitarCursar",
    "cabeceraAtributosMateriasEditarSolicitarCursar",
    "cuerpoAtributosMateriasEditarSolicitarCursar",
  ];
  let arraySubAccordionOcho5 = [
    "collapseAtributosAceptarSolicitarImpartir",
    "javascript:testMaterias('AceptarSolicitarImpartir', 'Atributos')",
    "AceptarSolicitarImpartir",
    "iconoTestMateriasAtributosAceptarSolicitarImpartir",
    "cabeceraAtributosMateriasAceptarSolicitarImpartir",
    "cuerpoAtributosMateriasAceptarSolicitarImpartir",
  ];
  let arraySubAccordionOcho6 = [
    "collapseAtributosAceptarSolicitarImpartirSecundarioMaterias",
    "javascript:testMaterias('AceptarSolicitarImpartirSecundario', 'Atributos')",
    "AceptarSolicitarImpartirSecundario",
    "iconoTestMateriasAtributosAceptarSolicitarImpartirSecundario",
    "cabeceraAtributosMateriasAceptarSolicitarImpartirSecundario",
    "cuerpoAtributosMateriasAceptarSolicitarImpartirSecundario",
  ];
  let arrayAccordionUno = [
    "accordion22",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
    arraySubAccordionSeis,
    arraySubAccordionSiete,
    arraySubAccordionOcho1,
    arraySubAccordionOcho2,
    arraySubAccordionOcho3,
    arraySubAccordionOcho4,
    arraySubAccordionOcho5,
    arraySubAccordionOcho6,
  ];

  let arraySubAccordionOcho = [
    "collapseMateriasAccionesInsertar",
    "javascript:testMaterias('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestMateriasAccionesInsertar",
    "cabeceraAccionesMateriasInsertar",
    "cuerpoAccionesMateriasInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseMateriasAccionesBuscar",
    "javascript:testMaterias('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestMateriasAccionesBuscar",
    "cabeceraAccionesMateriasBuscar",
    "cuerpoAccionesMateriasBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseMateriasAccionesModificar",
    "javascript:testMaterias('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestMateriasAccionesModificar",
    "cabeceraAccionesMateriasModificar",
    "cuerpoAccionesMateriasModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseMateriasAccionesBorrar",
    "javascript:testMaterias('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestMateriasAccionesBorrar",
    "cabeceraAccionesMateriasBorrar",
    "cuerpoAccionesMateriasBorrar",
  ];
  let arraySubAccordionDoce = [
    "collapseMateriasAccionesSolicitarImpartir",
    "javascript:testMaterias('SolicitarImpartir', 'Acciones')",
    "SolicitarImpartir",
    "iconoTestMateriasAccionesSolicitarImpartir",
    "cabeceraAccionesMateriasSolicitarImpartir",
    "cuerpoAccionesMateriasSolicitarImpartir",
  ];
 let arraySubAccordionTrece = [
    "collapseMateriasAccionesEliminarSolicitarImpartir",
    "javascript:testMaterias('EliminarSolicitarImpartir', 'Acciones')",
    "EliminarSolicitarImpartir",
    "iconoTestMateriasAccionesEliminarSolicitarImpartir",
    "cabeceraAccionesMateriasEliminarSolicitarImpartir",
    "cuerpoAccionesMateriasEliminarSolicitarImpartir",
  ];
  let arraySubAccordionCatorce = [
    "collapseMateriasAccionesBuscarSolicitarImpartir",
    "javascript:testMaterias('BuscarSolicitarImpartir', 'Acciones')",
    "BuscarSolicitarImpartir",
    "iconoTestMateriasAccionesBuscarSolicitarImpartir",
    "cabeceraAccionesMateriasBuscarSolicitarImpartir",
    "cuerpoAccionesMateriasBuscarSolicitarImpartir",
  ];
  let arraySubAccordionQuince = [
    "collapseMateriasAccioneInsertarSolicitarCursar",
    "javascript:testMaterias('InsertarSolicitarCursar', 'Acciones')",
    "InsertarSolicitarCursar",
    "iconoTestMateriasAccionesInsertarSolicitarCursar",
    "cabeceraAccionesMateriasInsertarSolicitarCursar",
    "cuerpoAccionesMateriasInsertarSolicitarCursar",
  ];
  let arraySubAccordionDieciseis = [
    "collapseMateriasAccioneBuscarSolicitarCursar",
    "javascript:testMaterias('BuscarSolicitarCursar', 'Acciones')",
    "BuscarSolicitarCursar",
    "iconoTestMateriasAccionesBuscarSolicitarCursar",
    "cabeceraAccionesMateriasBuscarSolicitarCursar",
    "cuerpoAccionesMateriasBuscarSolicitarCursar",
  ];
  let arraySubAccordionDiecisiete= [
    "collapseMateriasAccioneEliminarSolicitarCursar",
    "javascript:testMaterias('EliminarSolicitarCursar', 'Acciones')",
    "EliminarSolicitarCursar",
    "iconoTestMateriasAccionesEliminarSolicitarCursar",
    "cabeceraAccionesMateriasEliminarSolicitarCursar",
    "cuerpoAccionesMateriasEliminarSolicitarCursar",
  ];
  let arraySubAccordionDieciocho= [
    "collapseMateriasAccioneEditarSolicitarCursar",
    "javascript:testMaterias('EditarSolicitarCursar', 'Acciones')",
    "EditarSolicitarCursar",
    "iconoTestMateriasAccionesEditarSolicitarCursar",
    "cabeceraAccionesMateriasEditarSolicitarCursar",
    "cuerpoAccionesMateriasEditarSolicitarCursar",
  ];
 let arraySubAccordionDiecinueve = [
    "collapseMateriasAccionesAceptarSolicitarImpartir",
    "javascript:testMaterias('AceptarSolicitarImpartir', 'Acciones')",
    "AceptarSolicitarImpartir",
    "iconoTestMateriasAccionesAceptarSolicitarImpartir",
    "cabeceraAccionesMateriasAceptarSolicitarImpartir",
    "cuerpoAccionesMateriasAceptarSolicitarImpartir",
  ];
  let arraySubAccordionVeinte= [
    "collapseMateriasAccioneAceptarSolicitarImpartirSecundario",
    "javascript:testMaterias('AceptarSolicitarImpartirSecundario', 'Acciones')",
    "AceptarSolicitarImpartirSecundario",
    "iconoTestMateriasAccionesAceptarSolicitarImpartirSecundario",
    "cabeceraAccionesMateriasAceptarSolicitarImpartirSecundario",
    "cuerpoAccionesMateriasAceptarSolicitarImpartirSecundario",
  ];
  let arrayAccordionDos = [
    "accordion23",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
    arraySubAccordionDoce,
    arraySubAccordionTrece,
    arraySubAccordionCatorce,
    arraySubAccordionQuince,
    arraySubAccordionDieciseis,
    arraySubAccordionDiecisiete,
    arraySubAccordionDieciocho,
    arraySubAccordionDiecinueve,
    arraySubAccordionVeinte,
  ];

  let arrayAccordionTres = [
    "accordion21",
    "collapseMateriasAtributos",
    null,
    "Atributos",
    "iconoTestMateriasAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseMateriasAcciones",
    null,
    "Acciones",
    "iconoTestMateriasAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testMaterias").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Usuario*/
function cargarTestGestionProcesosUsuario() {
  $("#testProcesoUsuario").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarProcesoUsuario",
    "javascript:testProcesoUsuario('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestProcesoUsuarioAtributosInsertar",
    "cabeceraAtributosProcesoUsuarioInsertar",
    "cuerpoAtributosProcesoUsuarioInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseProcesoUsuarioAtributoBuscar",
    "javascript:testProcesoUsuario('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestProcesoUsuarioAtributosBuscar",
    "cabeceraAtributosProcesoUsuarioBuscar",
    "cuerpoAtributosProcesoUsuarioBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseProcesoUsuarioAtributoModificar",
    "javascript:testProcesoUsuario('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestProcesoUsuarioAtributosModificar",
    "cabeceraAtributosProcesoUsuarioModificar",
    "cuerpoAtributosProcesoUsuarioModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarProcesoUsuario",
    "javascript:testProcesoUsuario('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestProcesoUsuarioAtributosBorrar",
    "cabeceraAtributosProcesoUsuarioBorrar",
    "cuerpoAtributosProcesoUsuarioBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseProcesoUsuarioAtributoVerEnDetalle",
    "javascript:testProcesoUsuario('VerEnDetalle', 'Atributos')",
    "Ver en detalle",
    "iconoTestProcesoUsuarioAtributosVerEnDetalle",
    "cabeceraAtributosProcesoUsuarioVerEnDetalle",
    "cuerpoAtributosProcesoUsuarioVerEnDetalle",
  ];
  let arrayAccordionUno = [
    "accordion22",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
  ];

  let arraySubAccordionOcho = [
    "collapseProcesoUsuarioAccionesInsertar",
    "javascript:testProcesoUsuario('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestProcesoUsuarioAccionesInsertar",
    "cabeceraAccionesProcesoUsuarioInsertar",
    "cuerpoAccionesProcesoUsuarioInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseProcesoUsuarioAccionesBuscar",
    "javascript:testProcesoUsuario('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestProcesoUsuarioAccionesBuscar",
    "cabeceraAccionesProcesoUsuarioBuscar",
    "cuerpoAccionesProcesoUsuarioBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseProcesoUsuarioAccionesModificar",
    "javascript:testProcesoUsuario('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestProcesoUsuarioAccionesModificar",
    "cabeceraAccionesProcesoUsuarioModificar",
    "cuerpoAccionesProcesoUsuarioModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseProcesoUsuarioAccionesBorrar",
    "javascript:testProcesoUsuario('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestProcesoUsuarioAccionesBorrar",
    "cabeceraAccionesProcesoUsuarioBorrar",
    "cuerpoAccionesProcesoUsuarioBorrar",
  ];
  let arrayAccordionDos = [
    "accordion23",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion21",
    "collapseProcesoUsuarioAtributos",
    null,
    "Atributos",
    "iconoTestProcesoUsuarioAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseProcesoUsuarioAcciones",
    null,
    "Acciones",
    "iconoTestProcesoUsuarioAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testProcesoUsuario").append(contenidoTest);
}

/* Función para cargar las opciones de Tests de Curso Académico */
function cargarTestCursoAcademico() {
  $("#testCursoAcademico").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarCursoAcademico",
    "javascript:testCursoAcademico('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestCursoAcademicoAtributosInsertar",
    "cabeceraAtributosCursoAcademicoInsertar",
    "cuerpoAtributosCursoAcademicoInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseCursoAcademicoAtributoBuscar",
    "javascript:testCursoAcademico('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCursoAcademicoAtributosBuscar",
    "cabeceraAtributosCursoAcademicoBuscar",
    "cuerpoAtributosCursoAcademicoBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseCursoAcademicoAtributoModificar",
    "javascript:testCursoAcademico('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestCursoAcademicoAtributosModificar",
    "cabeceraAtributosCursoAcademicoModificar",
    "cuerpoAtributosCursoAcademicoModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarCursoAcademico",
    "javascript:testCursoAcademico('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestCursoAcademicoAtributosBorrar",
    "cabeceraAtributosCursoAcademicoBorrar",
    "cuerpoAtributosCursoAcademicoBorrar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
  ];

  let arraySubAccordionOcho = [
    "collapseCursoAcademicoAccionesInsertar",
    "javascript:testCursoAcademico('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestCursoAcademicoAccionesInsertar",
    "cabeceraAccionesCursoAcademicoInsertar",
    "cuerpoAccionesCursoAcademicoInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseCursoAcademicoAccionesBuscar",
    "javascript:testCursoAcademico('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCursoAcademicoAccionesBuscar",
    "cabeceraAccionesCursoAcademicoBuscar",
    "cuerpoAccionesCursoAcademicoBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseCursoAcademicoAccionesModificar",
    "javascript:testCursoAcademico('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestCursoAcademicoAccionesModificar",
    "cabeceraAccionesCursoAcademicoModificar",
    "cuerpoAccionesCursoAcademicoModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseCursoAcademicoAccionesBorrar",
    "javascript:testCursoAcademico('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestCursoAcademicoAccionesBorrar",
    "cabeceraAccionesCursoAcademicoBorrar",
    "cuerpoAccionesCursoAcademicoBorrar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCursoAcademicoAtributos",
    null,
    "Atributos",
    "iconoTestCursoAcademicoAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCursoAcademicoAcciones",
    null,
    "Acciones",
    "iconoTestCursoAcademicoAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCursoAcademico").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Trabajos*/
function cargarTestGestionTrabajos() {
  $("#testTrabajos").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarTrabajos",
    "javascript:testTrabajos('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestTrabajosAtributosInsertar",
    "cabeceraAtributosTrabajosInsertar",
    "cuerpoAtributosTrabajosInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseTrabajosAtributoBuscar",
    "javascript:testTrabajos('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestTrabajosAtributosBuscar",
    "cabeceraAtributosTrabajosBuscar",
    "cuerpoAtributosTrabajosBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseTrabajosAtributoModificar",
    "javascript:testTrabajos('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestTrabajosAtributosModificar",
    "cabeceraAtributosTrabajosModificar",
    "cuerpoAtributosTrabajosModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarTrabajos",
    "javascript:testTrabajos('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestTrabajosAtributosBorrar",
    "cabeceraAtributosTrabajosBorrar",
    "cuerpoAtributosTrabajosBorrar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
  ];

  let arraySubAccordionOcho = [
    "collapseTrabajosAccionesInsertar",
    "javascript:testTrabajos('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestTrabajosAccionesInsertar",
    "cabeceraAccionesTrabajosInsertar",
    "cuerpoAccionesTrabajosInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseTrabajosAccionesBuscar",
    "javascript:testTrabajos('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestTrabajosAccionesBuscar",
    "cabeceraAccionesTrabajosBuscar",
    "cuerpoAccionesTrabajosBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseTrabajosAccionesModificar",
    "javascript:testTrabajos('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestTrabajosAccionesModificar",
    "cabeceraAccionesTrabajosModificar",
    "cuerpoAccionesTrabajosModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseTrabajosAccionesBorrar",
    "javascript:testTrabajos('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestTrabajosAccionesBorrar",
    "cabeceraAccionesTrabajosBorrar",
    "cuerpoAccionesTrabajosBorrar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseTrabajosAtributos",
    null,
    "Atributos",
    "iconoTestTrabajosAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseTrabajosAcciones",
    null,
    "Acciones",
    "iconoTestTrabajosAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testTrabajos").append(contenidoTest);
}


/*Función para cargar las opciones de Tests de Competencias*/
function cargarTestGestionCompetencias() {
  $("#testCompetencias").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarCompetencias",
    "javascript:testCompetencias('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestCompetenciasAtributosInsertar",
    "cabeceraAtributosCompetenciasInsertar",
    "cuerpoAtributosCompetenciasInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseCompetenciasAtributoBuscar",
    "javascript:testCompetencias('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCompetenciasAtributosBuscar",
    "cabeceraAtributosCompetenciasBuscar",
    "cuerpoAtributosCompetenciasBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseCompetenciasAtributoModificar",
    "javascript:testCompetencias('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestCompetenciasAtributosModificar",
    "cabeceraAtributosCompetenciasModificar",
    "cuerpoAtributosCompetenciasModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarCompetencias",
    "javascript:testCompetencias('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestCompetenciasAtributosBorrar",
    "cabeceraAtributosCompetenciasBorrar",
    "cuerpoAtributosCompetenciasBorrar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosAsignarCompetencias",
    "javascript:testCompetencias('Asignar', 'Atributos')",
    "Asignar",
    "iconoTestCompetenciasAtributosAsignar",
    "cabeceraAtributosCompetenciasAsignar",
    "cuerpoAtributosCompetenciasAsignar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
    arraySubAccordionCinco,
  ];

  let arraySubAccordionOcho = [
    "collapseCompetenciasAccionesInsertar",
    "javascript:testCompetencias('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestCompetenciasAccionesInsertar",
    "cabeceraAccionesCompetenciasInsertar",
    "cuerpoAccionesCompetenciasInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseCompetenciasAccionesBuscar",
    "javascript:testCompetencias('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCompetenciasAccionesBuscar",
    "cabeceraAccionesCompetenciasBuscar",
    "cuerpoAccionesCompetenciasBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseCompetenciasAccionesModificar",
    "javascript:testCompetencias('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestCompetenciasAccionesModificar",
    "cabeceraAccionesCompetenciasModificar",
    "cuerpoAccionesCompetenciasModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseCompetenciasAccionesBorrar",
    "javascript:testCompetencias('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestCompetenciasAccionesBorrar",
    "cabeceraAccionesCompetenciasBorrar",
    "cuerpoAccionesCompetenciasBorrar",
  ];
  let arraySubAccordionDoce = [
    "collapseCompetenciasAccionesAsignar",
    "javascript:testCompetencias('Asignar', 'Acciones')",
    "Asignar",
    "iconoTestCompetenciasAccionesAsignar",
    "cabeceraAccionesCompetenciasAsignar",
    "cuerpoAccionesCompetenciasAsignar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
    arraySubAccordionDoce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCompetenciasAtributos",
    null,
    "Atributos",
    "iconoTestCompetenciasAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCompetenciasAcciones",
    null,
    "Acciones",
    "iconoTestCompetenciasAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCompetencias").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Entregas*/
function cargarTestGestionEntrega() {
  $("#testEntrega").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarEntrega",
    "javascript:testEntrega('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestEntregaAtributosInsertar",
    "cabeceraAtributosEntregaInsertar",
    "cuerpoAtributosEntregaInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseEntregaAtributoBuscar",
    "javascript:testEntrega('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestEntregaAtributosBuscar",
    "cabeceraAtributosEntregaBuscar",
    "cuerpoAtributosEntregaBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseEntregaAtributoModificar",
    "javascript:testEntrega('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestEntregaAtributosModificar",
    "cabeceraAtributosEntregaModificar",
    "cuerpoAtributosEntregaModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarEntrega",
    "javascript:testEntrega('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestEntregaAtributosBorrar",
    "cabeceraAtributosEntregaBorrar",
    "cuerpoAtributosEntregaBorrar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
  ];

  let arraySubAccordionOcho = [
    "collapseEntregaAccionesInsertar",
    "javascript:testEntrega('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestEntregaAccionesInsertar",
    "cabeceraAccionesEntregaInsertar",
    "cuerpoAccionesEntregaInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseEntregaAccionesBuscar",
    "javascript:testEntrega('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestEntregaAccionesBuscar",
    "cabeceraAccionesEntregaBuscar",
    "cuerpoAccionesEntregaBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseEntregaAccionesModificar",
    "javascript:testEntrega('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestEntregaAccionesModificar",
    "cabeceraAccionesEntregaModificar",
    "cuerpoAccionesEntregaModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseEntregaAccionesBorrar",
    "javascript:testEntrega('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestEntregaAccionesBorrar",
    "cabeceraAccionesEntregaBorrar",
    "cuerpoAccionesEntregaBorrar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseEntregaAtributos",
    null,
    "Atributos",
    "iconoTestEntregaAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseEntregaAcciones",
    null,
    "Acciones",
    "iconoTestEntregaAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testEntrega").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Criterios*/
function cargarTestGestionCriterio() {
  $("#testCriterio").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarCriterio",
    "javascript:testCriterio('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestCriterioAtributosInsertar",
    "cabeceraAtributosCriterioInsertar",
    "cuerpoAtributosCriterioInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseCriterioAtributoBuscar",
    "javascript:testCriterio('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCriterioAtributosBuscar",
    "cabeceraAtributosCriterioBuscar",
    "cuerpoAtributosCriterioBuscar",
  ];
  let arraySubAccordionTres = [
    "collapseCriterioAtributoModificar",
    "javascript:testCriterio('Modificar', 'Atributos')",
    "Modificar",
    "iconoTestCriterioAtributosModificar",
    "cabeceraAtributosCriterioModificar",
    "cuerpoAtributosCriterioModificar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarCriterio",
    "javascript:testCriterio('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestCriterioAtributosBorrar",
    "cabeceraAtributosCriterioBorrar",
    "cuerpoAtributosCriterioBorrar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionTres,
    arraySubAccordionCuatro,
  ];

  let arraySubAccordionOcho = [
    "collapseCriterioAccionesInsertar",
    "javascript:testCriterio('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestCriterioAccionesInsertar",
    "cabeceraAccionesCriterioInsertar",
    "cuerpoAccionesCriterioInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseCriterioAccionesBuscar",
    "javascript:testCriterio('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCriterioAccionesBuscar",
    "cabeceraAccionesCriterioBuscar",
    "cuerpoAccionesCriterioBuscar",
  ];
  let arraySubAccordionDiez = [
    "collapseCriterioAccionesModificar",
    "javascript:testCriterio('Modificar', 'Acciones')",
    "Modificar",
    "iconoTestCriterioAccionesModificar",
    "cabeceraAccionesCriterioModificar",
    "cuerpoAccionesCriterioModificar",
  ];
  let arraySubAccordionOnce = [
    "collapseCriterioAccionesBorrar",
    "javascript:testCriterio('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestCriterioAccionesBorrar",
    "cabeceraAccionesCriterioBorrar",
    "cuerpoAccionesCriterioBorrar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDiez,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCriterioAtributos",
    null,
    "Atributos",
    "iconoTestCriterioAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCriterioAcciones",
    null,
    "Acciones",
    "iconoTestCriterioAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCriterio").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Criterio-Competencia*/
function cargarTestGestionCriterioCompetencia() {
  $("#testCriterioCompetencia").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarCriterioCompetencia",
    "javascript:testCriterioCompetencia('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestCriterioCompetenciaAtributosInsertar",
    "cabeceraAtributosCriterioCompetenciaInsertar",
    "cuerpoAtributosCriterioCompetenciaInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseCriterioCompetenciaAtributoBuscar",
    "javascript:testCriterioCompetencia('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCriterioCompetenciaAtributosBuscar",
    "cabeceraAtributosCriterioCompetenciaBuscar",
    "cuerpoAtributosCriterioCompetenciaBuscar",
  ];
  let arraySubAccordionCuatro = [
    "collapseAtributosBorrarCriterioCompetencia",
    "javascript:testCriterioCompetencia('Borrar', 'Atributos')",
    "Borrar",
    "iconoTestCriterioCompetenciaAtributosBorrar",
    "cabeceraAtributosCriterioCompetenciaBorrar",
    "cuerpoAtributosCriterioCompetenciaBorrar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionCuatro,
  ];

  let arraySubAccordionOcho = [
    "collapseCriterioCompetenciaAccionesInsertar",
    "javascript:testCriterioCompetencia('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestCriterioCompetenciaAccionesInsertar",
    "cabeceraAccionesCriterioCompetenciaInsertar",
    "cuerpoAccionesCriterioCompetenciaInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseCriterioCompetenciaAccionesBuscar",
    "javascript:testCriterioCompetencia('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCriterioCompetenciaAccionesBuscar",
    "cabeceraAccionesCriterioCompetenciaBuscar",
    "cuerpoAccionesCriterioCompetenciaBuscar",
  ];
  let arraySubAccordionOnce = [
    "collapseCriterioCompetenciaAccionesBorrar",
    "javascript:testCriterioCompetencia('Borrar', 'Acciones')",
    "Borrar",
    "iconoTestCriterioCompetenciaAccionesBorrar",
    "cabeceraAccionesCriterioCompetenciaBorrar",
    "cuerpoAccionesCriterioCompetenciaBorrar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionOnce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCriterioCompetenciaAtributos",
    null,
    "Atributos",
    "iconoTestCriterioCompetenciaAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCriterioCompetenciaAcciones",
    null,
    "Acciones",
    "iconoTestCriterioCompetenciaAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCriterioCompetencia").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Corrección Criterio*/
function cargarTestGestionCorreccionCriterio() {
  $("#testCorreccionCriterio").html("");

  let arraySubAccordionUno = [
    "collapseAtributosInsertarCorreccionCriterio",
    "javascript:testCorreccionCriterio('Insertar', 'Atributos')",
    "Añadir",
    "iconoTestCorreccionCriterioAtributosInsertar",
    "cabeceraAtributosCorreccionCriterioInsertar",
    "cuerpoAtributosCorreccionCriterioInsertar",
  ];
  let arraySubAccordionDos = [
    "collapseCorreccionCriterioAtributoBuscar",
    "javascript:testCorreccionCriterio('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCorreccionCriterioAtributosBuscar",
    "cabeceraAtributosCorreccionCriterioBuscar",
    "cuerpoAtributosCorreccionCriterioBuscar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosAsignarAleatorioCorreccionCriterio",
    "javascript:testCorreccionCriterio('AsignarAleatorio', 'Atributos')",
    "AsignarAleatorio",
    "iconoTestCorreccionCriterioAtributosAsignarAleatorio",
    "cabeceraAtributosCorreccionCriterioAsignarAleatorio",
    "cuerpoAtributosCorreccionCriterioAsignarAleatorio",
  ];
  let arraySubAccordionSeis = [
    "collapseAtributosEditarCorreccionCriterio",
    "javascript:testCorreccionCriterio('Editar', 'Atributos')",
    "Editar",
    "iconoTestCorreccionCriterioAtributosEditar",
    "cabeceraAtributosCorreccionCriterioEditar",
    "cuerpoAtributosCorreccionCriterioEditar",
  ];
  let arraySubAccordionSiete = [
    "collapseAtributosEditarDocenteCorreccionCriterio",
    "javascript:testCorreccionCriterio('EditarDocente', 'Atributos')",
    "EditarDocente",
    "iconoTestCorreccionCriterioAtributosEditarDocente",
    "cabeceraAtributosCorreccionCriterioEditarDocente",
    "cuerpoAtributosCorreccionCriterioEditarDocente",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionUno,
    arraySubAccordionDos,
    arraySubAccordionCinco,
    arraySubAccordionSeis,
    arraySubAccordionSiete,
  ];

  let arraySubAccordionOcho = [
    "collapseCorreccionCriterioAccionesInsertar",
    "javascript:testCorreccionCriterio('Insertar', 'Acciones')",
    "Añadir",
    "iconoTestCorreccionCriterioAccionesInsertar",
    "cabeceraAccionesCorreccionCriterioInsertar",
    "cuerpoAccionesCorreccionCriterioInsertar",
  ];
  let arraySubAccordionNueve = [
    "collapseCorreccionCriterioAccionesBuscar",
    "javascript:testCorreccionCriterio('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCorreccionCriterioAccionesBuscar",
    "cabeceraAccionesCorreccionCriterioBuscar",
    "cuerpoAccionesCorreccionCriterioBuscar",
  ];
  let arraySubAccordionDoce = [
    "collapseCorreccionCriterioAccionesAsignarAleatorio",
    "javascript:testCorreccionCriterio('AsignarAleatorio', 'Acciones')",
    "AsignarAleatorio",
    "iconoTestCorreccionCriterioAccionesAsignarAleatorio",
    "cabeceraAccionesCorreccionCriterioAsignarAleatorio",
    "cuerpoAccionesCorreccionCriterioAsignarAleatorio",
  ];
  let arraySubAccordionTrece = [
    "collapseCorreccionCriterioAccionesEditar",
    "javascript:testCorreccionCriterio('Editar', 'Acciones')",
    "Editar",
    "iconoTestCorreccionCriterioAccionesEditar",
    "cabeceraAccionesCorreccionCriterioEditar",
    "cuerpoAccionesCorreccionCriterioEditar",
  ];
  let arraySubAccordionCatorce = [
    "collapseCorreccionCriterioAccionesEditarDocente",
    "javascript:testCorreccionCriterio('EditarDocente', 'Acciones')",
    "EditarDocente",
    "iconoTestCorreccionCriterioAccionesEditarDocente",
    "cabeceraAccionesCorreccionCriterioEditarDocente",
    "cuerpoAccionesCorreccionCriterioEditarDocente",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionOcho,
    arraySubAccordionNueve,
    arraySubAccordionDoce,
    arraySubAccordionTrece,
    arraySubAccordionCatorce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCorreccionCriterioAtributos",
    null,
    "Atributos",
    "iconoTestCorreccionCriterioAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCorreccionCriterioAcciones",
    null,
    "Acciones",
    "iconoTestCorreccionCriterioAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCorreccionCriterio").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Corrección Docente*/
function cargarTestGestionCorreccionDocente() {
  $("#testCorreccionDocente").html("");

  let arraySubAccordionDos = [
    "collapseCorreccionDocenteAtributoBuscar",
    "javascript:testCorreccionDocente('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestCorreccionDocenteAtributosBuscar",
    "cabeceraAtributosCorreccionDocenteBuscar",
    "cuerpoAtributosCorreccionDocenteBuscar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosEliminarCorreccionDocente",
    "javascript:testCorreccionDocente('Eliminar', 'Atributos')",
    "Eliminar",
    "iconoTestCorreccionDocenteAtributosEliminar",
    "cabeceraAtributosCorreccionDocenteEliminar",
    "cuerpoAtributosCorreccionDocenteEliminar",
  ];
  let arraySubAccordionSeis = [
    "collapseAtributosEditarCorreccionDocente",
    "javascript:testCorreccionDocente('Editar', 'Atributos')",
    "Editar",
    "iconoTestCorreccionDocenteAtributosEditar",
    "cabeceraAtributosCorreccionDocenteEditar",
    "cuerpoAtributosCorreccionDocenteEditar",
  ];
  let arraySubAccordionSiete = [
    "collapseAtributosMostrarCorreccionCorreccionDocente",
    "javascript:testCorreccionDocente('MostrarCorreccion', 'Atributos')",
    "MostrarCorreccion",
    "iconoTestCorreccionDocenteAtributosMostrarCorreccion",
    "cabeceraAtributosCorreccionDocenteMostrarCorreccion",
    "cuerpoAtributosCorreccionDocenteMostrarCorreccion",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionDos,
    arraySubAccordionCinco,
    arraySubAccordionSeis,
    arraySubAccordionSiete,
  ];

  let arraySubAccordionNueve = [
    "collapseCorreccionDocenteAccionesBuscar",
    "javascript:testCorreccionDocente('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestCorreccionDocenteAccionesBuscar",
    "cabeceraAccionesCorreccionDocenteBuscar",
    "cuerpoAccionesCorreccionDocenteBuscar",
  ];
  let arraySubAccordionDoce = [
    "collapseCorreccionDocenteAccionesEliminar",
    "javascript:testCorreccionDocente('Eliminar', 'Acciones')",
    "Eliminar",
    "iconoTestCorreccionDocenteAccionesEliminar",
    "cabeceraAccionesCorreccionDocenteEliminar",
    "cuerpoAccionesCorreccionDocenteEliminar",
  ];
  let arraySubAccordionTrece = [
    "collapseCorreccionDocenteAccionesEditar",
    "javascript:testCorreccionDocente('Editar', 'Acciones')",
    "Editar",
    "iconoTestCorreccionDocenteAccionesEditar",
    "cabeceraAccionesCorreccionDocenteEditar",
    "cuerpoAccionesCorreccionDocenteEditar",
  ];
  let arraySubAccordionCatorce = [
    "collapseCorreccionDocenteAccionesMostrarCorreccion",
    "javascript:testCorreccionDocente('MostrarCorreccion', 'Acciones')",
    "MostrarCorreccion",
    "iconoTestCorreccionDocenteAccionesMostrarCorreccion",
    "cabeceraAccionesCorreccionDocenteMostrarCorreccion",
    "cuerpoAccionesCorreccionDocenteMostrarCorreccion",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionNueve,
    arraySubAccordionDoce,
    arraySubAccordionTrece,
    arraySubAccordionCatorce,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseCorreccionDocenteAtributos",
    null,
    "Atributos",
    "iconoTestCorreccionDocenteAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseCorreccionDocenteAcciones",
    null,
    "Acciones",
    "iconoTestCorreccionDocenteAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testCorreccionDocente").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Notas criterio*/
function cargarTestGestionNotasCriterio() {
  $("#testNotasCriterio").html("");

  let arraySubAccordionDos = [
    "collapseNotasCriterioAtributoBuscar",
    "javascript:testNotasCriterio('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestNotasCriterioAtributosBuscar",
    "cabeceraAtributosNotasCriterioBuscar",
    "cuerpoAtributosNotasCriterioBuscar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosEliminarNotasAnadir",
    "javascript:testNotasCriterio('Anadir', 'Atributos')",
    "Insertar",
    "iconoTestNotasCriterioAtributosAnadir",
    "cabeceraAtributosNotasCriterioAnadir",
    "cuerpoAtributosNotasCriterioAnadir",
  ];
  let arraySubAccordionSeis = [
    "collapseAtributosEditarNotasCriterio",
    "javascript:testNotasCriterio('Editar', 'Atributos')",
    "Editar",
    "iconoTestNotasCriterioAtributosEditar",
    "cabeceraAtributosNotasCriterioEditar",
    "cuerpoAtributosNotasCriterioEditar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionDos,
    arraySubAccordionCinco,
    arraySubAccordionSeis,
  ];

  let arraySubAccordionNueve = [
    "collapseNotasCriterioAccionesBuscar",
    "javascript:testNotasCriterio('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestNotasCriterioAccionesBuscar",
    "cabeceraAccionesNotasCriterioBuscar",
    "cuerpoAccionesNotasCriterioBuscar",
  ];
  let arraySubAccordionDoce = [
    "collapseNotasCriterioAccionesAnadir",
    "javascript:testNotasCriterio('Anadir', 'Acciones')",
    "Anadir",
    "iconoTestNotasCriterioAccionesAnadir",
    "cabeceraAccionesNotasCriterioAnadir",
    "cuerpoAccionesNotasCriterioAnadir",
  ];
  let arraySubAccordionTrece = [
    "collapseNotasCriterioAccionesEditar",
    "javascript:testNotasCriterio('Editar', 'Acciones')",
    "Editar",
    "iconoTestNotasCriterioAccionesEditar",
    "cabeceraAccionesNotasCriterioEditar",
    "cuerpoAccionesNotasCriterioEditar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionNueve,
    arraySubAccordionDoce,
    arraySubAccordionTrece,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseNotasCriterioAtributos",
    null,
    "Atributos",
    "iconoTestNotasCriterioAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseNotasCriterioAcciones",
    null,
    "Acciones",
    "iconoTestNotasCriterioAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testNotasCriterio").append(contenidoTest);
}

/*Función para cargar las opciones de Tests de Notas competencia*/
function cargarTestGestionNotasCompetencia() {
  $("#testNotasCompetencia").html("");

  let arraySubAccordionDos = [
    "collapseNotasCompetenciaAtributoBuscar",
    "javascript:testNotasCompetencia('Buscar', 'Atributos')",
    "Buscar",
    "iconoTestNotasCompetenciaAtributosBuscar",
    "cabeceraAtributosNotasCompetenciaBuscar",
    "cuerpoAtributosNotasCompetenciaBuscar",
  ];
  let arraySubAccordionCinco = [
    "collapseAtributosVisualizarNotasCompetencia",
    "javascript:testNotasCompetencia('Visualizar', 'Atributos')",
    "Visualizar",
    "iconoTestNotasCompetenciaAtributosVisualizar",
    "cabeceraAtributosNotasCompetenciaVisualizar",
    "cuerpoAtributosNotasCompetenciaVisualizar",
  ];
  let arraySubAccordionSeis = [
    "collapseAtributosEditarNotasCompetencia",
    "javascript:testNotasCompetencia('Editar', 'Atributos')",
    "Editar",
    "iconoTestNotasCompetenciaAtributosEditar",
    "cabeceraAtributosNotasCompetenciaEditar",
    "cuerpoAtributosNotasCompetenciaEditar",
  ];
  let arrayAccordionUno = [
    "accordion19",
    arraySubAccordionDos,
    arraySubAccordionCinco,
    arraySubAccordionSeis,
  ];

  let arraySubAccordionNueve = [
    "collapseNotasCompetenciaAccionesBuscar",
    "javascript:testNotasCompetencia('Buscar', 'Acciones')",
    "Buscar",
    "iconoTestNotasCompetenciaAccionesBuscar",
    "cabeceraAccionesNotasCompetenciaBuscar",
    "cuerpoAccionesNotasCompetenciaBuscar",
  ];
  let arraySubAccordionDoce = [
    "collapseNotasCompetenciaAccionesVisualizar",
    "javascript:testNotasCompetencia('Visualizar', 'Acciones')",
    "Visualizar",
    "iconoTestNotasCompetenciaAccionesVisualizar",
    "cabeceraAccionesNotasCompetenciaVisualizar",
    "cuerpoAccionesNotasCompetenciaVisualizar",
  ];
  let arraySubAccordionTrece = [
    "collapseNotasCompetenciaAccionesEditar",
    "javascript:testNotasCompetencia('Editar', 'Acciones')",
    "Editar",
    "iconoTestNotasCompetenciaAccionesEditar",
    "cabeceraAccionesNotasCompetenciaEditar",
    "cuerpoAccionesNotasCompetenciaEditar",
  ];
  let arrayAccordionDos = [
    "accordion20",
    arraySubAccordionNueve,
    arraySubAccordionDoce,
    arraySubAccordionTrece,
  ];

  let arrayAccordionTres = [
    "accordion18",
    "collapseNotasCompetenciaAtributos",
    null,
    "Atributos",
    "iconoTestNotasCompetenciaAtributos",
    null,
    null,
    arrayAccordionUno,
    "collapseNotasCompetenciaAcciones",
    null,
    "Acciones",
    "iconoTestNotasCompetenciaAcciones",
    null,
    null,
    arrayAccordionDos,
  ];

  var contenidoTest = createTest(arrayAccordionTres);

  $("#testNotasCompetencia").append(contenidoTest);
}
