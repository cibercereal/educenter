/*Función para añadir la cabecera de la tabla de atributos*/
function cabeceraTablaAtributosTest() {
  return (
    "<tr>" +
    '<th class="colFirst">Prueba</th>' +
    "<th>Datos</th>" +
    "<th>Valor esperado</th>" +
    "<th>Valor obtenido</th>" +
    "<th>Éxito</th>" +
    "</tr>"
  );
}

/*Función para añadir la cabecera de la tabla de acciones*/
function cabeceraTablaAccionesTest() {
  return (
    "<tr>" +
    '<th class="colFirst">Prueba</th>' +
    "<th>Datos</th>" +
    "<th>Valor esperado</th>" +
    "<th>Valor obtenido</th>" +
    "<th>Éxito</th>" +
    "</tr>"
  );
}

/*Función que rellena las tablas de atributos*/
function cuerpoTablaAtributosTest(fila) {
  if (fila.exito == "TEST_EXITO") {
    filaTabla =
      "<tr> <td>" +
      fila.prueba +
      "</td> <td>" +
      valorAcortado(fila.datos) +
      "</td> <td>" +
      fila.RespEsperada +
      "</td> <td>" +
      fila.RespObtenida +
      "</td> <td>" +
      fila.exito +
      "</td> </tr>";
  } else {
    filaTabla =
      '<tr> <td class="filaTestFracaso">' +
      fila.prueba +
      '</td> <td class="filaTestFracaso">' +
      valorAcortado(fila.datos) +
      '</td> <td class="filaTestFracaso">' +
      fila.RespEsperada +
      '</td> <td class="filaTestFracaso">' +
      fila.RespObtenida +
      '</td> <td class="filaTestFracaso">' +
      fila.exito +
      "</td> </tr>";
  }

  return filaTabla;
}

/*Función que devuelve el valor de la prueba acortado si pasa de un tamaño*/
function valorAcortado(info) {
  var datos = "";

  for (var key in info) {
    datos += "<div>" + key + ": " + info[key] + "</div>";
  }

  return datos;
}

/*Función que rellena las tablas de atributos*/
function cuerpoTablaAccionesTest(fila) {
  if (fila.exito == "TEST_EXITO") {
    filaTabla =
      "<tr> <td>" +
      fila.prueba +
      "</td> <td>" +
      valorAcortado(fila.datos) +
      "</td> <td>" +
      fila.RespEsperada +
      "</td> <td>" +
      fila.RespObtenida +
      "</td> <td>" +
      fila.exito +
      "</td> </tr>";
  } else {
    filaTabla =
      '<tr> <td class="filaTestFracaso">' +
      fila.prueba +
      '</td> <td class="filaTestFracaso">' +
      valorAcortado(fila.datos) +
      '</td> <td class="filaTestFracaso">' +
      fila.RespEsperada +
      '</td> <td class="filaTestFracaso">' +
      fila.RespObtenida +
      '</td> <td class="filaTestFracaso">' +
      fila.exito +
      "</td> </tr>";
  }

  return filaTabla;
}

/*Función para cargar las tablas de test*/
function cargarTablasTest(
  datos,
  idCabecera,
  idCuerpo,
  tipoTest,
  atributosValor,
  entidad
) {
  $("#" + idCabecera).html("");
  $("#" + idCuerpo).html("");
  var trCabecera = "";

  switch (tipoTest) {
    case "acciones":
      trCabecera = cabeceraTablaAccionesTest();

      for (var i = 0; i < datos.length; i++) {
        var tr = cuerpoTablaAccionesTest(datos[i]);
        $("#" + idCuerpo).append(tr);
      }
      break;
    case "atributos":
      trCabecera = cabeceraTablaAtributosTest();

      for (var i = 0; i < datos.length; i++) {
        var tr = cuerpoTablaAtributosTest(datos[i]);
        $("#" + idCuerpo).append(tr);
      }
      break;
  }

  $("#" + idCabecera).append(trCabecera);
}

/*Función para cargar los errores en la modal si falla la petición de los test*/
function cargarModalErroresTest() {
  $("#modal-title").removeClass();
  $("#modal-title").addClass("ERROR");
  document.getElementById("modal-title").style.color = "#a50707";
  $(".imagenAviso").attr("src", "Resources/failed.png");
  $("#modal-mensaje").removeClass();
  $("#modal-mensaje").addClass("ERROR_TEST");
  setLang(getCookie("lang"));
  document.getElementById("modal").style.display = "block";
}

/**Función que valida que no tengamos pruebas de test con valores nulos, en el caso de que los haya muestra un icono de error al lado del tipo de test*/
function validarDatosTabla(datos, idElementoList, tipoTest) {
  var bandera = "noAdvertir";

  for (var i = 0; i < datos.length; i++) {
    switch (tipoTest) {
      case "acciones":
        if (
          datos[i].RespEsperada === null ||
          datos[i].RespObtenida === null ||
          datos[i].accion === null ||
          datos[i].code === null ||
          datos[i].entidad === null ||
          datos[i].prueba === null ||
          datos[i].tipo === null ||
          datos[i].exito === null ||
          datos[i].exito === "TEST_FRACASO"
        ) {
          idElementoList.forEach(function (idElemento) {
            bandera = "advertir";
            $("#" + idElemento).prop("hidden", false);
          });
          break;
        } else {
          idElementoList.forEach(function (idElemento) {
            if (bandera == "noAdvertir") {
              $("#" + idElemento).prop("hidden", true);
            }
          });
          break;
        }
        break;
      case "atributos":
        if (
          datos[i].RespEsperada === null ||
          datos[i].RespObtenida === null ||
          datos[i].accion === null ||
          datos[i].code === null ||
          datos[i].entidad === null ||
          datos[i].prueba === null ||
          datos[i].tipo === null ||
          datos[i].exito === null ||
          datos[i].exito === "TEST_FRACASO"
        ) {
          idElementoList.forEach(function (idElemento) {
            bandera = "advertir";
            $("#" + idElemento).prop("hidden", false);
          });
          break;
        } else {
          idElementoList.forEach(function (idElemento) {
            if (bandera == "noAdvertir") {
              $("#" + idElemento).prop("hidden", true);
            }
          });
          break;
        }
        break;
    }
  }
}

function imagenErrorTestOcultar() {
  $(".iconTab").prop("hidden", false);
  $(".iconTab").prop("hidden", true);
}

function removeFields() {
  removeField("controladorTest");
  removeField("controlador");
  removeField("action");
  removeField("actionTest");
}

/*Función para la respuesta ok de los test*/
function cargarRespuestaOkTest(
  datosPruebaAtributos,
  idCabecera,
  idCuerpo,
  atributosValor,
  entidad,
  idElementoList,
  tipoTest
) {
  cargarTablasTest(
    datosPruebaAtributos,
    idCabecera,
    idCuerpo,
    tipoTest,
    atributosValor,
    entidad
  );
  validarDatosTabla(datosPruebaAtributos, idElementoList, tipoTest);
}
