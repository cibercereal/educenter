var x;
var subject;
var projects = new Map();
var mapaAgrupadoPorEntrega = new Map();
var mapaCorreccionPorEntrega = new Map();
var criteriaMap = new Map();

async function loadDeliveries() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("DETALLE_ENTREGA") + ": " + getCookie("projectName");
    createHideForm("formDeliveryDetail");
    insertField(document.formDeliveryDetail, "id_trabajo", getCookie('project'));
    addActionControler(document.formDeliveryDetail, "search", "delivery");

    await loadDeliveryAjaxPromise()
        .then(async (res) => {
            for (var i = 0; i < res['resource'].length; i++) {
                var projectId = res['resource'][i].id_trabajo.id_trabajo;
                projects.set(res['resource'][i].id_entrega, res['resource'][i].datos);
            }

            mapaCorreccionPorEntrega = new Map();
            createHideForm('searchCorrectionTeacher');
            insertField(document.searchCorrectionTeacher, "id_trabajo", getCookie('project'));
            await ajaxPromise(document.searchCorrectionTeacher, "search", "correctionTeacher", "RECORDSET_DATOS", true)
            .then((res2) => {
                for (const item of res2['resource']) {
                  const idEntrega = item.id_entrega['id_entrega'];

                  if (mapaCorreccionPorEntrega.has(idEntrega)) {
                    mapaCorreccionPorEntrega.get(idEntrega).push(item);
                  } else {
                    mapaCorreccionPorEntrega.set(idEntrega, [item]);
                  }
                }
            })
            .catch((res2) => {

            });
            loadData(res);
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function loadDeliveryAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formDeliveryDetail").serialize(),
                headers: { Authorization: token },
            })
            .done((res) => {
                if (res.code != "RECORDSET_DATOS" && res.code != "RECORDSET_VACIO") {
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

function loadData(res) {
    x = res;
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    x.resource = res.resource.map(function (item) {
        return {
            ...item,
            fecha_entrega: new Date(item.fecha_entrega).toLocaleDateString('es-ES', options)
        };
    });
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", res.total);
        pager("delivery");
    }
    setCookie("totalElements", res.total);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
}

function getList(start, end) {
    $("#datosEntidades").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeRow(x.resource[i]);
        $("#datosEntidades").append(tr);
        setLang(getCookie('lang'));
    }
}

function makeRow(row) {
    atributosFunciones = [
        "'" + row.id_entrega + "'",
        "'" + row.fecha_entrega + "'",
        "'" + row.id_trabajo.nombre_trabajo + "'",
        "'" + row.id_trabajo.descripcion_trabajo + "'",
        "'" + row.id_trabajo.id_trabajo + "'",
    ];

    celdaAccionesVerEntrega = '<div class="tooltip6"><img class="detalle ICONO_DETALLE pointer" src="Resources/detail3.png" onclick="showDetail(' +
          atributosFunciones +
          ')" alt="Ver"/><span class="tooltiptext ICONO_DETALLE pointer"></span></div>';

    celdaAccionesAsignarCorreccion = "";
    celdaAccionesCorregirCorreccion = "";
    var today = new Date(Date.now()).getTime();
    if (today > new Date(row.id_trabajo.fecha_fin).getTime()) {
        if (mapaAgrupadoPorEntrega.has(row.id_entrega) && mapaAgrupadoPorEntrega.get(row.id_entrega)[0].fecha_fin_correccion != null && today > new Date(mapaAgrupadoPorEntrega.get(row.id_entrega)[0].fecha_fin_correccion).getTime()) {
            celdaAccionesCorregirCorreccion = '<div class="tooltip6"><img class="detalle ICONO_CORREGIR_CORRECCION pointer" src="Resources/corregirCorreccion.png" onclick="correctCorrection(' +
                atributosFunciones[0] +
                ')" alt="Corregir Corrección"/><span class="tooltiptext ICONO_CORREGIR_CORRECCION pointer"></span></div>';
        } else {
            if(document.getElementById("btnAssignRandom").querySelector('button') == null) {
                assignButton();
            }
            celdaAccionesAsignarCorreccion = '<div class="tooltip6"><img class="detalle ICONO_ASIGNAR_CORRECCION pointer" src="Resources/corregir.png" onclick="assignCorrectionManually(' +
                  row.id_trabajo.id_materia + ", " + atributosFunciones[0] + ", '" + row.dni.dni + "'" + ", " + atributosFunciones[4] +
                  ')" alt="Asignar"/><span class="tooltiptext ICONO_ASIGNAR_CORRECCION pointer"></span></div>';
        }
    }

    celdaAcciones = '';
    if (getCookie('userRole') == 'docente') {
        celdaAcciones = celdaAccionesVerEntrega + celdaAccionesAsignarCorreccion + celdaAccionesCorregirCorreccion;
    }

    var rowTable =
        '<tr class="impar" id="datoEntidad">' +
        "</td> <td>" +
        row.dni.dni +
        "</td> <td>" +
        row.dni.nombre +
        "</td> <td>" +
        row.dni.apellidos_usuario +
        "</td> <td>" +
        row.fecha_entrega +
        "</td>" +
        "<td class='text-nowrap'>" +
        celdaAcciones
    "</td> </tr>";
    return rowTable;
}

function assignCorrectionManually(id_materia, id_entrega, dni, id_trabajo) {
    var idioma = getCookie("lang");
    var campos = [
        "descargarEnlace",
        "input_fecha_entrega",
        "input_nombre_trabajo",
        "input_descripcion_trabajo"
    ];
    assignCorrectionStructure();
    changeForm("assignCorrectionForm", "javascript:assignCorrection('"+ id_entrega + "', '" + id_trabajo +"');", "return checkAssignCorrection();");
    changeOnBlurProjectFields(
        "return checkAssignCorrectionManually('input_alumno', 'errorFormatAlumno', 'assignCorrection');",
        "return checkEndDateCorrection('input_fecha_fin_correccion', 'errorFormatFechaFinCorreccion', 'endDateCorrection');"
    );
    changeIcon("Resources/corregir.png", "ICONO_ASIGNAR_CORRECCION", "iconoEditarRol", "Asignar");
    disableFields(campos);
    fillFormAssignCorrection(id_materia, id_entrega, dni, id_trabajo);
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

function changeOnBlurProjectFields(onBlurDescription, onBlurEndDateCorrection) {
    $("#input_alumno").attr("onblur", onBlurDescription);
    $("#input_fecha_fin_correccion").attr("onblur", onBlurEndDateCorrection);
}

function showDetail(id_entrega, fecha_entrega, nombre_trabajo, descripcion_trabajo, id_trabajo) {
    var idioma = getCookie("lang");
    var campos = [
        "descargarEnlace",
        "input_fecha_entrega",
        "input_nombre_trabajo",
        "input_descripcion_trabajo",
    ];
    seeInDetailStructure();
    changeForm("detailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(id_entrega, fecha_entrega, nombre_trabajo, descripcion_trabajo, id_trabajo);
    disableFields(campos);
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

function seeInDetailStructure() {
     clearModalErrors();
     activateFieldsBlockDetail();
     hideRequired();
     showLabelsDetail();
}

function assignCorrectionStructure() {
    clearModalErrors();
    activateFieldsBlockAssignCorrection();
    showLabelsAssignCorrection();
}

function hideRequired() {
    $("#obligatorio_datos").attr("style", "display: none");
}

function clearModalErrors() {
    let errores = [
        "errorFormatFechaEntrega",
        "errorFormatNombreTrabajo",
        "errorFormatDescripcionTrabajo",
        "errorFormatAlumno",
        "errorFormatFechaFinCorreccion",
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlockDetail() {
    $("#input_nombre_trabajo").attr("style", "display: block");
    $("#input_descripcion_trabajo").attr("style", "display: block");
    $("#input_fecha_entrega").attr("style", "display: block");
    $("#descargarEnlace").attr("style", "display: block");
    $("#input_alumno").attr("style", "display: none");
    $("#input_fecha_fin_correccion").attr("style", "display: none");
    $("#icon").attr("style", "display: none");
}

function activateFieldsBlockAssignCorrection() {
    $("#input_nombre_trabajo").attr("style", "display: none");
    $("#input_descripcion_trabajo").attr("style", "display: none");
    $("#input_fecha_entrega").attr("style", "display: none");
    $("#descargarEnlace").attr("style", "display: none");
    $("#icon").attr("style", "display: block");
    $("#input_alumno").attr("style", "display: block");
    $("#input_fecha_fin_correccion").attr("style", "display: block");
}

function fillForm(id_entrega, fecha_entrega, nombre_trabajo, descripcion_trabajo, id_trabajo) {
    $("#input_nombre_trabajo").val(nombre_trabajo);
    $("#input_descripcion_trabajo").val(descripcion_trabajo);
    $("#input_fecha_entrega").val(convertirFecha(fecha_entrega));
    $("#descargarEnlace").off('click').click(function() {
        descargarArchivo(id_entrega);
    });
}

async function fillFormAssignCorrection(id_materia, id_entrega, dni, id_trabajo) {
    createHideForm("formSubjectStudent");
    insertField(document.formSubjectStudent, "id_materia", id_materia);
    await ajaxPromise(document.formSubjectStudent, "search", "subjectStudent", "RECORDSET_DATOS", true)
    .then(async (res) => {
        createHideForm("formCorrectionCriteria");
        insertField(document.formCorrectionCriteria, "id_entrega", id_entrega);
        insertField(document.formCorrectionCriteria, "id_trabajo", id_trabajo);
        $studentsWithAssignCorrection = Array();
        await ajaxPromise(document.formCorrectionCriteria, "search", "correctionCriteria", "RECORDSET_DATOS", true)
        .then(async (res2) => {
            $correctionCriteria = res2['resource'];
            for (var i = 0; i < $correctionCriteria.length; i++) {
                if (!$studentsWithAssignCorrection.includes($correctionCriteria[i].dni_alumno)) {
                    $studentsWithAssignCorrection.push($correctionCriteria[i].dni_alumno);
                }
            }
        })
        .catch((res2) => {
            ajaxResponseKO(res2.code);
        });
        var select = $("#input_alumno");

        select.empty();

        var option1 = document.createElement("option");
        option1.setAttribute("value", "");
        option1.setAttribute("label", "-----");
        option1.setAttribute("class", "-----");
        option1.setAttribute("selected", "true");
        select.append(option1);

        for (var i = 0; i < res['resource'].length; i++) {
            if (res['resource'][i].dni != "" && res['resource'][i].dni.dni != dni && !$studentsWithAssignCorrection.includes(res['resource'][i].dni.dni)) {
                option = document.createElement("option");
                option.setAttribute("value", res['resource'][i].dni.dni);
                option.setAttribute("name", res['resource'][i].dni.dni);
                option.appendChild(document.createTextNode(res['resource'][i].dni.nombre + " " + res['resource'][i].dni.apellidos_usuario));
                select.append(option);
            }
        }
    })
    .catch((res) => {
        ajaxResponseKO(res.code);
    });
}

function showLabelsDetail() {
    $("#label_fecha_entrega").attr("style", "display: block");
    $("#label_descripcion_trabajo").attr("style", "display: block");
    $("#label_nombre_trabajo").attr("style", "display: block");
    $("#label_alumno").attr("style", "display: none");
    $("#label_fecha_fin_correccion").attr("style", "display: none");
}

function showLabelsAssignCorrection() {
    $("#label_fecha_entrega").attr("style", "display: none");
    $("#label_descripcion_trabajo").attr("style", "display: none");
    $("#label_nombre_trabajo").attr("style", "display: none");
    $("#label_alumno").attr("style", "display: block");
    $("#label_fecha_fin_correccion").attr("style", "display: block");
}

function descargarArchivo(id_entrega) {
    return new Promise((resolve, reject) => {
        // Realizar una solicitud AJAX al servidor para obtener el archivo
        var xhr = new XMLHttpRequest();
        const jsonData = JSON.parse(projects.get(parseInt(id_entrega)));
        jsonData.tmp_name = jsonData.tmp_name.replace(/[^\\\/]+$/, jsonData.name);

        var url = URL_REST;

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json'); // Establecer el encabezado Content-Type
        xhr.setRequestHeader('Authorization', getCookie('token')); // Establecer el encabezado Content-Type
        xhr.responseType = 'blob';

        xhr.onload = function () {
            // Verificar que la solicitud se haya completado correctamente
            if (xhr.status === 200) {
                // Crear un enlace temporal para descargar el archivo
                var blob = new Blob([xhr.response], { type: 'application/octet-stream' });
                var downloadUrl = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = downloadUrl;
                a.download = jsonData.name; // Nombre del archivo a descargar

                // Hacer clic en el enlace para iniciar la descarga
                a.click();

                // Limpiar el enlace temporal después de un breve retraso
                setTimeout(function () {
                    window.URL.revokeObjectURL(downloadUrl);
                    resolve();
                }, 100);
            } else {
                reject(new Error('Error al descargar el archivo.'));
            }
        };

        xhr.onerror = function () {
            reject(new Error('Error en la solicitud AJAX.'));
        };

        jsonData.controller = "delivery";
        jsonData.action = "download";
        // Convertir el objeto JSON en una cadena y enviarlo en el cuerpo de la solicitud
        xhr.send(JSON.stringify({ document: jsonData }));
    });
}

function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}
function closeCorregirCorrecciones() {
    $("#formularioCorregirCorrecciones").modal("hide");
    closeModal("formularioCorregirCorrecciones", "", "");
    closeEntityModal();
}

async function assignCorrection(id_entrega, id_trabajo) {
    insertField(document.getElementById('formularioGenerico'), "id_entrega", id_entrega);
    insertField(document.getElementById('formularioGenerico'), "id_trabajo", id_trabajo);
    await ajaxPromise(document.getElementById('formularioGenerico'), "add", "correctionCriteria", "ANADIR_CORRECCION_OK", true)
        .then(async (res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseOK("ANADIR_CORRECCION_OK", res.code);

            let idElementoList = [
                "input_alumno",
                "input_fecha_fin_correccion"
            ];
            cleanForm(idElementoList);
            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "input_alumno",
                "input_fecha_fin_correccion"
            ];
            cleanForm(idElementoList);
            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function assignButton() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success ASIGNAR_AUTOMATICO mb-3" data-toggle="modal" data-target="#assignRandom-modal" class="tooltip"></button>' : '';

    document.getElementById("btnAssignRandom").innerHTML += showBtn;
}

async function assignRandomCorrection() {
    insertField(document.formAssignRandomCorrection, "id_trabajo", getCookie("project"));
    await ajaxPromise(document.formAssignRandomCorrection, "assignRandom", "correctionCriteria", "ANADIR_CORRECCION_OK", true)
        .then((res) => {
            $("#assignRandom-modal").modal("toggle");
            ajaxResponseOK("ANADIR_CORRECCION_OK", res.code);

            let idElementoList = [
                "numeroAlumnos",
            ];
            cleanForm(idElementoList);
            resetForm("formAssignRandomCorrection", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#assignRandom-modal").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "numeroAlumnos",
            ];
            cleanForm(idElementoList);
            resetForm("formAssignRandomCorrection", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

async function loadAssignedCorrections() {
    var lang = getCookie("lang");
    mapaAgrupadoPorEntrega = new Map();
    createHideForm("formAssignedCorrections");
    insertField(document.formAssignedCorrections, "id_trabajo", getCookie('project'));
    await ajaxPromise(document.formAssignedCorrections, "search", "correctionCriteria", "RECORDSET_DATOS", true)
        .then(async (res) => {
            for (const item of res['resource']) {
              const idEntrega = item.id_entrega;

              // Si la clave ya existe, agregamos el objeto al array existente
              if (mapaAgrupadoPorEntrega.has(idEntrega)) {
                mapaAgrupadoPorEntrega.get(idEntrega).push(item);
              } else {
                // Si la clave no existe, creamos un nuevo array con el objeto
                mapaAgrupadoPorEntrega.set(idEntrega, [item]);
              }
            }
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

async function correctCorrection(id_entrega) {
    changeForm1("correctionForm", "javascript:closeCorregirCorrecciones(); loadAssignedCorrections(); loadDeliveries();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillCorrectionForm(parseInt(id_entrega), false);
    $("#formularioCorregirCorrecciones").modal("show");
    setLang(getCookie("lang"));
}

async function fillCorrectionForm(id_entrega, readonly) {
    contenedor = document.getElementById('datosMateria');
    if (contenedor) {
        contenedor.innerHTML = ''
    }
    if (mapaAgrupadoPorEntrega.has(id_entrega)) {
        selectedDelivery = mapaAgrupadoPorEntrega.get(id_entrega);
        clearModalErrors(selectedDelivery);
        createHideForm("formCriteria");
        insertField(document.formCriteria, "id_trabajo", selectedDelivery[0]['id_trabajo']);
        await ajaxPromise(document.formCriteria, "search", "criteria", "RECORDSET_DATOS", true)
            .then(async (res) => {
                for (const item of res['resource']) {
                    criteriaMap.set(item.id_criterio, item);
                }
                makeCorrectionForm(id_entrega, selectedDelivery, readonly);
            })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
        document.formCriteria.remove();
    }
   setLang(getCookie('lang'));
}

function makeCorrectionForm(id_entrega, selectedDelivery, readonly) {
     existCriteria = [];
     const div1 = document.createElement('div');
     div1.classList.add('form-group');
     const checkbox = document.createElement('input');
     checkbox.type = 'checkbox';
     checkbox.id = 'checkbox';
     checkbox.name = 'visible';
     checkbox.checked = mapaCorreccionPorEntrega.get(id_entrega)[0]['visible'] == 1;
     checkbox.addEventListener('change', function () {
         showCorrection(id_entrega, this.checked);
     });
     div1.appendChild(checkbox);
     const labelMostrarAlumnos = document.createElement('label');
     labelMostrarAlumnos.classList.add('ml-3');
     labelMostrarAlumnos.textContent = translateWord("MOSTRAR_CORRECCION_ALUMNOS");
     div1.appendChild(labelMostrarAlumnos);
     const contenedorPadre = document.getElementById('datosMateria');
     contenedorPadre.appendChild(div1);


     // Iterar sobre el array de valores
     for (const delivery of selectedDelivery) {
         criteria = delivery['id_criterio'];
         if (!existCriteria.includes(criteria)) {
             existCriteria.push(criteria);
             // Crear elementos HTML
             const divFormGroup = document.createElement('div');
             divFormGroup.classList.add('form-group');

             const label = document.createElement('label');
             label.textContent = criteriaMap.get(delivery['id_criterio']).descripcion;

             const p = document.createElement('p');
             p.textContent = translateWord("CORRECTO");
             p.setAttribute('id', 'p' + delivery['id_criterio']);

             const selectElement = document.createElement('select');
             selectElement.disabled = readonly;
             selectElement.classList.add("form-control");
             selectElement.id = 'select' + delivery['id_criterio'];
             selectElement.name = 'correccion_docente' + '-' + delivery['id_criterio'];
             const option1 = document.createElement('option');
             option1.value = '';
             option1.text = '----';
             option1.selected = delivery['correccion_docente'] == '3' ? "selected" : "";
             const option2 = document.createElement('option');
             option2.value = '1';
             option2.text = translateWord("SI");
             option2.selected = delivery['correccion_docente'] == '1' ? "selected" : "";
             const option3 = document.createElement('option');
             option3.value = '0';
             option3.text = translateWord("NO");
             option3.selected = delivery['correccion_docente'] == '0' ? "selected" : "";

             selectElement.appendChild(option1);
             selectElement.appendChild(option2);
             selectElement.appendChild(option3);
             selectElement.addEventListener('blur', function() {
                return checkSelectElement('select' + delivery['id_criterio'], 'errorFormat' + delivery['id_criterio'], 'correccionCriterio', ['0', '1', '3'], selectElement.value);
             });

             selectedOptionTeacher = delivery['correccion_docente'];
             if (!readonly) {
                selectElement.addEventListener('change', function(event) {
                    correctionEntity(id_entrega, delivery['id_criterio']);
                    selectedOptionTeacher = event.target.value;
                    if (selectedOptionTeacher != '0') {
                       textArea = document.getElementById('textareaTeacher' + delivery['id_criterio']);
                       errorTxtFormat = document.getElementById('errorTextTeacherFormat' + delivery['id_criterio']);
                       if (textArea) {
                         textArea.parentNode.removeChild(textArea);
                         divFormGroup.removeChild(errorTxtFormat);
                       }
                    } else {
                        textareaElement = document.createElement('textarea');
                        textareaElement.disabled = readonly;
                        textareaElement.id = 'textareaTeacher' + delivery['id_criterio'];
                        textareaElement.name = 'comentarioCorreccion_docente' + '-' + delivery['id_criterio'];
                        textareaElement.rows = 4;
                        textareaElement.cols = 50;
                        textareaElement.classList.add("form-control");
                        textareaElement.addEventListener('blur', function() {
                            x = checkText('textareaTeacher' + delivery['id_criterio'], 'errorTextTeacherFormat' + delivery['id_criterio'], 'comentarioCorreccionCriterio');
                            if (x) {
                                correctionEntity(id_entrega, delivery['id_criterio']);
                            } else {
                                return x;
                            }
                        });
                        pElem = document.getElementById('p' + delivery['id_criterio'] + delivery['dni_alumno']);
                        pElem.parentNode.insertBefore(textareaElement, pElem);
                        const divErrorTextFormat = document.createElement('div');
                        divErrorTextFormat.id = 'errorTextTeacherFormat' + delivery['id_criterio'];
                        divErrorTextFormat.style.display = 'none';
                        pElem.parentNode.insertBefore(divErrorTextFormat, pElem);
                    }

                    for (const delivery2 of selectedDelivery) {
                        if (delivery2['id_criterio'] == delivery['id_criterio']) {
                            if (selectedOptionTeacher != null && selectedOptionTeacher != delivery2['correccion_alumno'] && (selectedOptionTeacher == '0' || selectedOptionTeacher == '1')) {
                                col3 = document.getElementById('col3' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                let img = document.createElement('img');
                                img.src = "Resources/cambiar.png";
                                img.alt = "Corregir";
                                img.id = 'img' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                img.classList.add("eliminar");
                                img.classList.add("ICONO_CAMBIAR");
                                img.classList.add("pointer");
                                img.classList.add("mx-auto");
                                col3.appendChild(img);
                                span = document.createElement('span');
                                span.id = "span" + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                span.classList.add("tooltiptext");
                                span.classList.add("ICONO_CAMBIAR");
                                col3.appendChild(span);

                                img.addEventListener('click', function(event) {
                                    textArea = document.getElementById('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                    row = document.getElementById('row' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                    if (textArea) {
                                        errorTxtFormat = document.getElementById('errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                        textArea.parentNode.removeChild(errorTxtFormat);
                                        textArea.parentNode.removeChild(textArea);
                                        correctionEntity(id_entrega, delivery2['id_criterio']);
                                        delivery2['comentario_docente'] = "";
                                    } else {
                                        divClass = document.createElement('div');
                                        divClass.classList.add("col-12");
                                        textareaElement = document.createElement('textarea');
                                        textareaElement.disabled = readonly;
                                        textareaElement.id = 'textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                        textareaElement.name = 'comentario_docente' + '-' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                        textareaElement.rows = 4;
                                        textareaElement.cols = 50;
                                        textareaElement.classList.add("form-control");
                                        textareaElement.classList.add("mt-2");
                                        textareaElement.addEventListener('blur', function() {
                                            delivery2['comentario_docente'] = textareaElement.value;
                                            x = checkText('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'comentarioCorreccionCriterioProfesor');
                                            if (x) {
                                                correctionEntity(id_entrega, delivery2['id_criterio']);
                                            } else {
                                                return x;
                                            }
                                        });
                                        divClass.appendChild(textareaElement);
                                        const divErrorTextFormat = document.createElement('div');
                                        divErrorTextFormat.id = 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                        divErrorTextFormat.style.display = 'none';
                                        divClass.appendChild(divErrorTextFormat);
                                        row.appendChild(divClass);
                                    }
                                });
                            } else {
                                img = document.getElementById('img' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                if (img) {
                                    img.parentNode.removeChild(img);
                                }
                                span = document.getElementById('span' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                if (span) {
                                    span.parentNode.removeChild(span);
                                }
                                textArea = document.getElementById('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                if (textArea) {
                                    textArea.parentNode.removeChild(textArea);
                                }
                            }
                        }
                    }
                });
             }

             const divErrorFormat = document.createElement('div');
             divErrorFormat.id = 'errorFormat' + delivery['id_criterio'];
             divErrorFormat.style.display = 'none';

             // Agregar los elementos al div form-group
             divFormGroup.appendChild(label);
             divFormGroup.appendChild(p);
             divFormGroup.appendChild(selectElement);
             divFormGroup.appendChild(divErrorFormat);

            if (delivery['correccion_docente'] != '0') {
                textArea = document.getElementById('textareaTeacher' + delivery['id_criterio']);
                errorTxtFormat = document.getElementById('errorTextTeacherFormat' + delivery['id_criterio']);
                if (textArea) {
                  textArea.parentNode.removeChild(textArea);
                  divFormGroup.removeChild(errorTxtFormat);
                }
            } else {
                textareaElement = document.createElement('textarea');
                textareaElement.disabled = readonly;
                textareaElement.id = 'textareaTeacher' + delivery['id_criterio'];
                textareaElement.name = 'comentarioCorreccion_docente' + '-' + delivery['id_criterio'];
                textareaElement.rows = 4;
                textareaElement.cols = 50;
                textareaElement.value = mapaCorreccionPorEntrega.get(parseInt(id_entrega)).find(item2 => item2.id_criterio.id_criterio === delivery['id_criterio']).comentario_docente;
                textareaElement.classList.add("form-control");
                textareaElement.addEventListener('blur', function() {
                    x = checkText('textareaTeacher' + delivery['id_criterio'], 'errorTextTeacherFormat' + delivery['id_criterio'], 'comentarioCorreccionCriterio');
                    if (x) {
                        correctionEntity(id_entrega, delivery['id_criterio']);
                    } else {
                        return x;
                    }
                });
                divFormGroup.appendChild(textareaElement);
                const divErrorTextFormat = document.createElement('div');
                divErrorTextFormat.id = 'errorTextTeacherFormat' + delivery['id_criterio'];
                divErrorTextFormat.style.display = 'none';
                divFormGroup.appendChild(divErrorTextFormat);
            }

             /** Parte alumnos */
             for (const delivery2 of selectedDelivery) {
                if (delivery2['id_criterio'] == delivery['id_criterio']) {
                    const p = document.createElement('p');
                    p.classList.add('ml-3');
                    p.textContent = delivery2['dni_alumno'];
                    p.setAttribute('id', 'p' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                    divFormGroup.appendChild(p);

                    const row = document.createElement('div');
                    row.classList.add('row');
                    row.classList.add('text-center');
                    row.id = 'row' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                    const col = document.createElement('div');
                    col.classList.add('col-4');
                    const col2 = document.createElement('div');
                    col2.classList.add('col-6');
                    const col3 = document.createElement('div');
                    col3.id = 'col3' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                    col3.classList.add('col-2');
                    col3.classList.add('tooltip6');
                    row.appendChild(col);
                    row.appendChild(col2);
                    row.appendChild(col3);
                    const selectElement = document.createElement('select');
                    selectElement.disabled = true;
                    selectElement.classList.add("form-control");
                    selectElement.id = 'select' + delivery2['id_criterio'];
                    selectElement.name = 'correccion_alumno' + '-' + delivery['id_criterio'];
                    const option1 = document.createElement('option');
                    option1.value = '3';
                    option1.text = '----';
                    option1.selected = delivery2['correccion_alumno'] == '3' ? "selected" : "";
                    const option2 = document.createElement('option');
                    option2.value = '1';
                    option2.text = translateWord("SI");
                    option2.selected = delivery2['correccion_alumno'] == '1' ? "selected" : "";
                    const option3 = document.createElement('option');
                    option3.value = '0';
                    option3.text = translateWord("NO");
                    option3.selected = delivery2['correccion_alumno'] == '0' ? "selected" : "";
                    selectElement.appendChild(option1);
                    selectElement.appendChild(option2);
                    selectElement.appendChild(option3);
                    col.appendChild(selectElement);

                    if (delivery2['correccion_alumno'] == '0') {
                        textareaElement = document.createElement('textarea');
                        textareaElement.disabled = true;
                        textareaElement.name = 'comentario_alumno' + '-' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                        textareaElement.classList.add("form-control");
                        textareaElement.value = delivery2['comentario_alumno'];
                        col2.appendChild(textareaElement);
                    }

                    if (selectedOptionTeacher != null && selectedOptionTeacher != delivery2['correccion_alumno']) {
                        let img = document.createElement('img');
                        img.src = "Resources/cambiar.png";
                        img.alt = "Corregir";
                        img.id = 'img' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                        img.classList.add("eliminar");
                        img.classList.add("ICONO_CAMBIAR");
                        img.classList.add("pointer");
                        img.classList.add("mx-auto");
                        col3.appendChild(img);
                        span = document.createElement('span');
                        span.id = "span" + delivery2['id_criterio'];
                        span.classList.add("tooltiptext");
                        span.classList.add("ICONO_CAMBIAR");
                        col3.appendChild(span);

                        if (delivery2['comentario_docente'].length > 0) {
                            divClass = document.createElement('div');
                            divClass.classList.add("col-12");
                            textareaElement = document.createElement('textarea');
                            textareaElement.disabled = readonly;
                            textareaElement.id = 'textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                            textareaElement.name = 'comentario_docente' + '-' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                            textareaElement.value = delivery2['comentario_docente'];
                            textareaElement.rows = 4;
                            textareaElement.cols = 50;
                            textareaElement.classList.add("form-control");
                            textareaElement.classList.add("mt-2");
                            textareaElement.addEventListener('blur', function() {
                            x = checkText('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'comentarioCorreccionCriterioProfesor');
                                if (x) {
                                    correctionEntity(id_entrega, delivery2['id_criterio']);
                                } else {
                                    return x;
                                }
                            });
                            divClass.appendChild(textareaElement);
                            const divErrorTextFormat = document.createElement('div');
                            divErrorTextFormat.id = 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                            divErrorTextFormat.style.display = 'none';
                            divClass.appendChild(divErrorTextFormat);
                            row.appendChild(divClass);
                        }

                        img.addEventListener('click', function(event) {
                            textArea = document.getElementById('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                            if (textArea) {
                                errorTxtFormat = document.getElementById('errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                                textArea.parentNode.removeChild(errorTxtFormat);
                                textArea.parentNode.removeChild(textArea);
                                correctionEntity(id_entrega, delivery2['id_criterio']);
                                delivery['comentario_docente'] = "";
                            } else {
                                divClass = document.createElement('div');
                                divClass.classList.add("col-12");
                                textareaElement = document.createElement('textarea');
                                textareaElement.disabled = readonly;
                                textareaElement.id = 'textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                textareaElement.name = 'comentario_docente' + '-' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                textareaElement.rows = 4;
                                textareaElement.cols = 50;
                                textareaElement.classList.add("form-control");
                                textareaElement.classList.add("mt-2");
                                textareaElement.addEventListener('blur', function() {
                                    delivery['comentario_docente'] = textareaElement.value;
                                    x = checkText('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'], 'comentarioCorreccionCriterioProfesor');
                                    if (x) {
                                        correctionEntity(id_entrega, delivery2['id_criterio']);
                                    } else {
                                        return x;
                                    }
                                });
                                divClass.appendChild(textareaElement);
                                const divErrorTextFormat = document.createElement('div');
                                divErrorTextFormat.id = 'errorTextFormat' + delivery2['id_criterio'] + delivery2['dni_alumno'];
                                divErrorTextFormat.style.display = 'none';
                                divClass.appendChild(divErrorTextFormat);
                                row.appendChild(divClass);
                            }
                        });
                    } else {
                        img = document.getElementById('img' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                        if (img) {
                            img.parentNode.removeChild(img);
                        }
                        span = document.getElementById('span' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                        if (span) {
                            span.parentNode.removeChild(span);
                        }
                        textArea = document.getElementById('textarea' + delivery2['id_criterio'] + delivery2['dni_alumno']);
                        if (textArea) {
                            textArea.parentNode.removeChild(textArea);
                        }
                    }
                    divFormGroup.appendChild(row);
                }
             }

            const contenedor = document.getElementById('datosMateria');

            // Agregar el div form-group al contenedor
            contenedor.appendChild(divFormGroup);
        }
    }
}

async function correctionEntity(id_entrega, id_criterio) {
    for (const delivery of selectedDelivery) {
        if (delivery['id_entrega'] == id_entrega && id_criterio == delivery['id_criterio']) {
            correccionProfesor = document.getElementById('select' + id_criterio) ? document.getElementById('select' + id_criterio).value : '';
            const comentarioProfesor = document.getElementById('textarea' + id_criterio + delivery['dni_alumno']) ? document.getElementById('textarea' + id_criterio + delivery['dni_alumno']).value : '';

            createHideForm('editCorrectionCriteria');
            insertField(document.editCorrectionCriteria, "correccion_docente", correccionProfesor);
            insertField(document.editCorrectionCriteria, "comentario_docente", comentarioProfesor);
            insertField(document.editCorrectionCriteria, "id_correccion_criterio", delivery['id_correccion_criterio']);
            await ajaxPromise(document.editCorrectionCriteria, "editTeacher", "correctionCriteria", "EDITAR_CORRECCION_CRITERIO_OK", true)
            .then(async (res) => {
                await editCorrectionTeacher(id_entrega, id_criterio);
            })
            .catch((res) => {
                // Do nothing
            });
            document.editCorrectionCriteria.remove();
        }
    }
}

async function editCorrectionTeacher(id_entrega, id_criterio) {
    for (const delivery of mapaCorreccionPorEntrega.get(id_entrega)) {
        if (delivery['id_entrega'].id_entrega == id_entrega && id_criterio == delivery['id_criterio'].id_criterio) {
            correccionDocente = document.getElementById('select' + id_criterio) ? document.getElementById('select' + id_criterio).value : '';
            const comentarioDocente = document.getElementById('textareaTeacher' + id_criterio) ? document.getElementById('textareaTeacher' + id_criterio).value : '';

            createHideForm('editCorrectionTeacher');
            insertField(document.editCorrectionTeacher, "comentario_docente", comentarioDocente);
            insertField(document.editCorrectionTeacher, "correccion_docente", correccionDocente);
            insertField(document.editCorrectionTeacher, "id_correccion_profesor", delivery['id_correccion_profesor']);
            await ajaxPromise(document.editCorrectionTeacher, "edit", "correctionTeacher", "EDITAR_CORRECCION_DOCENTE_OK", true)
            .then((res) => {
                // Do nothing
            })
            .catch((res) => {
                // Do nothing
            });
            document.editCorrectionTeacher.remove();
        }
    }
}

async function showCorrection(id_entrega, checked) {
    // Recorrer todas las correcciones de profesor
    for (delivery of mapaCorreccionPorEntrega.get(id_entrega)) {
        createHideForm('showCorrections');
        insertField(document.showCorrections, "visible", checked);
        insertField(document.showCorrections, "id_correccion_profesor", delivery['id_correccion_profesor']);
        await ajaxPromise(document.showCorrections, "showCorrection", "correctionTeacher", "MOSTRAR_CORRECCION_DOCENTE_OK", true)
        .then((res) => {
            // Do nothing
        })
        .catch((res) => {
             // Do nothing
        });
    }
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'docente' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bdni");
    displayBlock("bnombre");
    displayBlock("bapellidos");
    displayBlock("bfechaentrega");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bapellidos");
    valueNullAndDisplayNone("bfechaentrega");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadDeliveries();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "dni.dni", "bdni");
    filterElement(x, "dni.nombre", "bnombre");
    filterElement(x, "dni.apellidos_usuario", "bapellidos");
    filterElement(x, "fecha_entrega", "bfechaentrega");

    x.total = x.resource.length;
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", x.total);
        pager("user");
    }
    setCookie("totalElements", x.total);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
}