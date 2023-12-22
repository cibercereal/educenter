function pager(entity) {
    setCookie("paintPager", "no");
    setCookie("entity", entity);
    createArrayPager(entity);
    $("#paginacion").html("");
    var previousPager =
    '<nav aria-label="Page navigation example">' +
    '<ul class="pagination">' +
    '<li id="anterior" class="page-item disabled tooltip pointer">' +
    '<a class="page-link" href="#" onclick="loadPreviousPosition();" aria-label="Previous">' +
    '<span aria-hidden="true">&laquo;</span>' +
    '<span class="sr-only">Previous</span>' +
    '<span class="tooltiptext ANTERIOR"></span>' +
    "</a>" +
    "</li>";
    
    var pages = generatePagerButtons(entity);
    
    var nextPager =
    '<li id = "siguiente" class="page-item navegacion tooltip pointer">' +
    '<a class="page-link" href="#" onclick="loadNextPosition();" aria-label="Next">' +
    '<span aria-hidden="true">&raquo;</span>' +
    '<span class="sr-only">Next</span>' +
    '<span class="tooltiptext SIGUIENTE"></span>' +
    "</a>" +
    "</li>" +
    "</ul>" +
    "</nav>";
    
    var pag = previousPager + pages + nextPager;
    
    $("#paginacion").append(pag);

    stateFirstBlockButtons();
}

function loadPreviousPosition() {
  /*Pongo todo a block porque para atrás siempre van a existir todos*/
  var element = document.getElementsByClassName("page-item boton2")[0];
  element.style.display = "block";
  var elementTwo = document.getElementsByClassName("page-item boton3")[0];
  elementTwo.style.display = "block";

  var pagerArray = transformCookieInArray();
  var actualPos = parseInt(getCookie("actualPos")); // 1
  var previousPositions = pagerArray[actualPos]; //[4,30,10] , [5,40,10] , [6,50,10]
  var previousIds = [];
  var nextIds = [];
  var nextInits = [];
  var nextPagesSizes = [];

  for (var i = 0; i < previousPositions.length; i++) {
    previousIds.push(previousPositions[i][0]); //[4,5,6]
  }

  var actualPositions = pagerArray[actualPos - 1]; //[1,0,10] , [2,10,10] , [3,20,10]

  for (var i = 0; i < actualPositions.length; i++) {
    nextIds.push(actualPositions[i][0]); //[1,2,3]
    nextInits.push(actualPositions[i][1]); //[0,10,20]
    nextPagesSizes.push(actualPositions[i][2]); //[10,10,10]
  }

  for (var i = 0; i < nextIds.length; i++) {
    $("#" + previousIds[i]).removeClass("active"); //[4]
    var actualPage = getCookie("actualPage");
    //[1]
    var onclick =
      "searchEntities(" +
      nextIds[i] +
      ");" +
      "activatePage(" +
      nextIds[i] +
      ");";
    $("#" + previousIds[i] + " a").attr("onclick", onclick);
    //[4] Metemos un nuevo onclick

    //Cambiamos textos e ids
    $("#" + previousIds[i] + " a").text(nextIds[i]); //Cambiamos texto por -> 1
    $("#" + previousIds[i]).attr("id", nextIds[i]); //Cambiamos id -> 4 por -> 1

    if (nextIds.includes(actualPage)) {
      $("#" + actualPage).addClass("active");
    }
  }

  actualPosition = parseInt(getCookie("actualPos"));
  actualPosition--;
  setCookie("actualPos", actualPosition.toString());

  var actual = parseInt(getCookie("actualPos"));
  var posArray = parseInt(getCookie("numPositionsArray"));

  //Al final de todo
  if (posArray - 1 == actual) {
    $("#siguiente").removeClass("navegacion");
    $("#siguiente").addClass("disabled");
    $("#anterior").removeClass("disabled");
    $("#anterior").addClass("navegacion");
  }
  //Al principio de todo
  else if (actual == 0) {
    $("#anterior").removeClass("navegacion");
    $("#anterior").addClass("disabled");
    $("#siguiente").addClass("navegacion");
    $("#siguiente").removeClass("disabled");
  }
  //Estamos en un bloque de tres paginas del medio
  else if (actual != posArray - 1) {
    $("#siguiente").addClass("navegacion");
    $("#siguiente").removeClass("disabled");
    $("#anterior").removeClass("disabled");
    $("#anterior").addClass("navegacion");
  }
  //var activo = parseInt(getCookie('active'));
  //$('#' + activo).addClass('active')
}

function transformCookieInArray() {
    var cookie = getCookie("paginacion").split(",");
    pagesArray = [];
    elementsArrays = [];
    element = [];
  
    for (var i = 0; i < cookie.length; i++) {
      element.push(cookie[i]);
      if (element.length == 3) {
        elementsArrays.push(element);
        element = [];
  
        if (elementsArrays.length == 3) {
          pagesArray.push(elementsArrays);
          elementsArrays = [];
        }
      }
    }
  
    if (elementsArrays.length != 0) {
      pagesArray.push(elementsArrays);
    }
  
    return pagesArray;
}

function activatePage(id) {
    var element = getCookie("actualPage");
    $("#" + element).removeClass("active");
    $("#" + id).addClass("active");
    setCookie("actualPage", id);
    fileTableMessage();
}

function stateFirstBlockButtons() {
    activatePage(1);
    $("#1").addClass("active");

    var pagerArray = transformCookieInArray();
    /*Si tengo menos elements que capacidad tengo en los 3 bloques iniciales oculto los que no hagan falta.*/
    //Oculto botón 1, 2 y 3
    if (pagerArray.length == 0) {
        var element = document.getElementsByClassName("page-item boton1");
        var element2 = document.getElementsByClassName("page-item boton2");
        var element3 = document.getElementsByClassName("page-item boton3");
        element[0].style.display = "none";
        element2[0].style.display = "none";
        element3[0].style.display = "none";
        $("#siguiente").removeClass("navegacion");
        $("#siguiente").addClass("disabled");
        $("#anterior").removeClass("navegacion");
        $("#anterior").addClass("disabled");
    }
    //Oculto botón 2 y 3
    else if (pagerArray[0].length == 1) {
        var element = document.getElementsByClassName("page-item boton2");
        var element2 = document.getElementsByClassName("page-item boton3");
        element[0].style.display = "none";
        element2[0].style.display = "none";
    }
    //Oculto botón 3
    else if (pagerArray[0].length == 2) {
        var element2 = document.getElementsByClassName("page-item boton3");
        element2[0].style.display = "none";
    }
    
    /*En caso de que tenga en el primero grupo de bloques <1|2|3> menos de 3 bloques o en caso de que
                  tenga el bloque <1|2|3> completo pero no haya <4>:
                  Deshabilito el botón >*/
    if (pagerArray.length != 0) {
      if (
        pagerArray[0].length < 3 ||
        (pagerArray[0].length == 3 &&
          typeof pagerArray[1] === "undefined")
      ) {
        $("#siguiente").removeClass("navegacion");
        $("#siguiente").addClass("disabled");
      }
    }
  }

/*Función que crea los botones 1,2,3*/
function generatePagerButtons() {
    var pages = "";
  
    for (var i = 0; i < 3; i++) {
      pages +=
        '<li id ="' +
        (i + 1) +
        '" class="page-item boton' +
        (i + 1) +
        '" style = "display:block">' +
        '<a class="page-link" href="#" ' +
        'onclick ="searchEntities(' +
        (i + 1) +
        "); " +
        "activatePage(" +
        (i + 1) +
        ');">' +
        (i + 1) +
        "</a></li>";
    }
  
    return pages;
  }

function createArrayPager(entidad) {
    var totalResults = parseInt(getCookie("totalElements"));
    setCookie("paintPager", "no");
    var size = selectSize(entidad);
    var numberPages = Math.ceil(totalResults / size);
    var pagesArray = [];

    //Bloque entero con tres paginas
    if (numberPages % 3 == 0) {
      loop = numberPages;
      pagesArray = ThreePageBlocks(loop, pagesArray, size);
    } //Bloque entero con tres paginas y bloque no entero
    else if (numberPages > 3) {
      loop = numberPages - (numberPages % 3);
      pagesArray = ThreePageBlocks(loop, pagesArray, size);
      loop = numberPages % 3;
      pagesArray = LessThanThreePageBlocks(loop, pagesArray, size);
    } //Bloque no entero
    else {
      loop = numberPages % 3;
      pagesArray = LessThanThreePageBlocks(loop, pagesArray, size);
    }
    if (pagesArray != "") {
      setCookie("paginacion", pagesArray);
    } else {
      setCookie("paginacion", [0,1,5]);
    }
    setCookie("numPositionsArray", pagesArray.length);
}

function ThreePageBlocks(loop, pagesArray, size) {
    var numElements = 0;
    var elementsArrays = [];
  
    for (var i = 0; i <= loop; i++) {
      var elementArray = [i + 1, calculateStart(i, size), size];
      if (numElements < 3) {
        elementsArrays.push(elementArray);
        numElements++;
      } else {
        pagesArray.push(elementsArrays);
        elementsArrays = [];
        elementsArrays.push(elementArray);
        numElements = 1;
      }
    }
    return pagesArray;
  }

  function calculateStart($start, $sizePag) {
    return $start * $sizePag;
  }  
  
  function LessThanThreePageBlocks(loop, pagesArray, size) {
    elementsArrays = [];
    var elementsArrays = [];
    var start = pagesArray.length;
    if (start == 0) {
      for (var i = 0; i < loop; i++) {
        var elementArray = [i + 1, calculateStart(i, size), size];
        elementsArrays.push(elementArray);
      }

      pagesArray.push(elementsArrays);
    } else {
      start = start * 3;
      for (var i = 0; i < loop; i++) {
        var elementArray = [
          i + 1 + start,
          calculateStart(start + i, size),
          size,
        ];
        elementsArrays.push(elementArray);
      }

      pagesArray.push(elementsArrays);
    }
    return pagesArray;
  }

/*Función que muestra el mensaje de filas en una tabla*/
function fileTableMessage() {
    var total = parseInt(getCookie("totalElements"));
    var actualPage = getCookie("actualPage");
    var size = selectSize(getCookie("entity"));
    var editPage = Math.ceil(total / size);
    if (actualPage == "undefined" || total == 0 || isNaN(total)) {
      var message = "0 - 0 total 0";
      document.getElementById("contadorPaginas").innerText = message;
    } else if (editPage < parseInt(actualPage)) {
      var message = "0 - 0 total " + total;
      document.getElementById("contadorPaginas").innerText = message;
      //Este caso se produce cuando hacemos una edición sobre el campo
      //de busqueda del último element de la página.
    } else {
      var totalElements = parseInt(getCookie("totalElements"));
      var lastPage = Math.ceil(totalElements / size);
  
      var pageSize = selectSize(getCookie("entity"));
      totalElements = parseInt(getCookie("totalElements"));
      var x = (actualPage - 1) * pageSize + 1;
  
      if (actualPage == lastPage) {
        var y = totalElements;
      } else {
        var y = actualPage * size;
      }

      var message = x + " - " + y + " total " + total;
      var d = document.getElementById("contadorPaginas").innerText = message;
    }
}

/*Función que nos devuelve el tamaño de pagina en función de una entidad.*/
function selectSize(entity) {
    var rowPageNumber = 1;
    switch (entity) {
      case "roleActionFunctionality":
        rowPageNumber = 5;
        break;
      case "actionFunctionality":
        rowPageNumber = 5;
        break;
      case "user":
        rowPageNumber = 5;
        break;
      case "subject":
        rowPageNumber = 15;
        break;
      case "student":
        rowPageNumber = 5;
        break;
      case "teacher":
        rowPageNumber = 5;
        break;
      case "delivery":
        rowPageNumber = 10;
        break;
      case "competence":
        rowPageNumber = 5;
        break;
      case "criteria":
        rowPageNumber = 5;
        break;
      case "documents":
        rowPageNumber = 5;
        break;
    }
    return rowPageNumber;
}

/*Función que ajusta el paginador inicialmente.*/
function adjustPager() {
    setCookie("paintPager", "si"); //Bandera para pintar el paginador, solo se pinta una vez.
    setCookie("actualPage", "1"); //Indica en que pestaña estoy.
    setCookie("actualPos", "0"); //Indica el bloque de tres páginas en el que estoy. <4|5|6> --> actualPos = 1
    setCookie("totalElements", "0"); //Total de elements del paginador.
    setCookie("numPositionsArray", "0"); //Total de grupos de 3 pestañas que tiene el array.
    //[ [ [1, 0,10] , [2,10,10] , [3,20,10] ] ], --> Bloque 1 (número de pagina, start, filasPagina)
    //[ [4,30,10] , [5,40,10] , [6,50,10] ] ], --> Bloque 2
    //[ [7,60,10] ]                            --> Bloque 3
    //]                                        --> numPositionsArray = 3 (pagerArray.length)
}

function loadNextPosition() {
    var pagerArray = transformCookieInArray();
    var actualPosition = parseInt(getCookie("actualPos")); //0
    var previousPositions = pagerArray[actualPosition]; //[1,0,10] , [2,10,10] , [3,20,10]
    var previousIds = [];
    var nextIds = [];
    var nextInits = [];
    var nextPagesSizes = [];
  
    //Capturamos los ids del bloque de paginas anterior. Si queremos cargar <4|5|6> cogemos 1,2,3
    for (var i = 0; i < previousPositions.length; i++) {
      previousIds.push(previousPositions[i][0]); //[1,2,3]
    }
  
    /*Capturamos el bloque de paginas al que queremos pasar.*/
    var actualPositions = pagerArray[actualPosition + 1]; //[4,30,10] , [5,40,10] , [6,50,10]
  
    /*Para cada posición del bloque de páginas al que quiero pasar recogo el id, inicio y tamaño de pagina.*/
    for (var i = 0; i < actualPositions.length; i++) {
      nextIds.push(actualPositions[i][0]); //[4,5,6]
      nextInits.push(actualPositions[i][1]); //[30,40,50]
      nextPagesSizes.push(actualPositions[i][2]); //[10,10,10]
    }
  
    /*Genero un nuevo atributo onClick para los botones.*/
    for (var i = 0; i < nextIds.length; i++) {
      $("#" + previousIds[i]).removeClass("active"); //[1]
      var actualPage = getCookie("actualPage");
      //[4]
      var onclick =
        "searchEntities(" +
        nextIds[i] +
        ");" +
        "activatePage(" +
        nextIds[i] +
        ");";
  
      $("#" + previousIds[i] + " a").attr("onclick", onclick);
      //[1] Metemos un nuevo onclick
      //Cambiamos textos e ids
      $("#" + previousIds[i] + " a").text(nextIds[i]); //Cambiamos texto por -> 4
      $("#" + previousIds[i]).attr("id", nextIds[i]); //Cambiamos id -> 1 por -> 4
  
      if (nextIds.includes(actualPage)) {
        $("#" + actualPage).addClass("active");
      }
    }

    ocultarBloques(nextIds.length);
  
    actualPosition++;
    setCookie("actualPos", actualPosition.toString());
  
    var posArray = parseInt(getCookie("numPositionsArray"));
    //Al final de todo
    if (posArray - 1 == actualPosition) {
      $("#siguiente").removeClass("navegacion");
      $("#siguiente").addClass("disabled");
      $("#anterior").removeClass("disabled");
      $("#anterior").addClass("navegacion");
    }
    //Al principio de todo
    else if (actualPosition == 0) {
      $("#siguiente").removeClass("disabled");
      $("#siguiente").addClass("navegacion");
      $("#anterior").removeClass("navegacion");
      $("#anterior").addClass("disabled");
    }
    //Estamos en un bloque de tres paginas del medio
    else if (actualPosition != posArray - 1) {
      //FALTA ALGO
      $("#siguiente").removeClass("disabled");
      $("#siguiente").addClass("navegacion");
      $("#anterior").removeClass("disabled");
      $("#anterior").addClass("navegacion");
    }
    //var activo = parseInt(getCookie('active'));
    //$('#' + activo).addClass('active');
}

function searchEntities(pag) {
  $(".start").remove();
  $(".filaspagina").remove();
  var pages = [];
  var pagerArray = transformCookieInArray();
  pagerArray.forEach((element) => {
    pages.push(element[0]);
    pages.push(element[1]);
    pages.push(element[2]);
  });
  var page = pages[pag - 1];
  getList(page[1], page[2]);
}

function ocultarBloques(numeroIdCrear) {
    if (numeroIdCrear == 1) {
      var element = document.getElementsByClassName("page-item boton2");
      var element2 = document.getElementsByClassName("page-item boton3");
      element[0].style.display = "none";
      element2[0].style.display = "none";
    } else if (numeroIdCrear == 2) {
      var element = document.getElementsByClassName("page-item boton3");
      element[0].style.display = "none";
    }
}