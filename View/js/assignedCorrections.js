var x;
var mapaAgrupadoPorEntrega = new Map();
var criteriaMap = new Map();
var projects = new Map();
var correctionTeacher = null;

async function loadAssignedCorrections() {
    var lang = getCookie("lang");
    mapaAgrupadoPorEntrega = new Map();
    criteriaMap = new Map();
    document.getElementById("assignedCorrection").textContent = translateWord("ICONO_CORRECCION_ASIGNADA") + ": " + getCookie("subjectName");
    createHideForm("formAssignedCorrections");
    insertField(document.formAssignedCorrections, "dni_alumno", getCookie('userSystem'));
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
            createHideForm("formDelivery");
            insertField(document.formDelivery, "id_trabajo", getCookie('project'));
            await ajaxPromise(document.formDelivery, "search", "delivery", "RECORDSET_DATOS", true)
            .then(async (res2) => {
                document.getElementById("assignedProject").textContent = translateWord("NOMBRE_TRABAJO") + ": " + res2['resource'][0].id_trabajo.nombre_trabajo;
                deliveries = [];
                for (const item of res2['resource']) {
                    if (mapaAgrupadoPorEntrega.has(item.id_entrega)) {
                        deliveries.push(item);
                    }
                }
                loadData(deliveries);
            })
            .catch((res3)=> {
                ajaxResponseKO(res2.code);
            });
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function loadData(res) {
    x = res;
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", res.length);
        pager("documents");
    }
    setCookie("totalElements", res.length);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
}

function getList(start, end) {
    $("#datosEntidades").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeRow(x[i]);
        $("#datosEntidades").append(tr);
        setLang(getCookie('lang'));
    }
}

function makeRow(row) {
    if (row != null) {
        const datosObjeto = JSON.parse(row.datos);
        projects.set(row.id_entrega, row.datos)

        celdaAccionesDescargar = '<div class="tooltip6"><img class="eliminar ICONO_DESCARGAR pointer" src="Resources/descargar.png" onclick="download(' +
             row.id_entrega +
             ')" alt="Descargar"/><span class="tooltiptext ICONO_DESCARGAR"></span></div>';
        var endCorrectionDate = mapaAgrupadoPorEntrega.has(row.id_entrega) ? mapaAgrupadoPorEntrega.get(row.id_entrega)[0].fecha_fin_correccion : '';
        var today = new Date(Date.now()).getTime();
        celdaAccionesCorregir = today < new Date(endCorrectionDate).getTime() ? '<div class="tooltip6"><img class="eliminar ICONO_CORREGIR pointer" src="Resources/corregir.png" onclick="correction(' +
             row.id_entrega +
             ')" alt="Corregir"/><span class="tooltiptext ICONO_CORREGIR"></span></div>' : '';
        celdaAccionesVerCorreccion = today > new Date(endCorrectionDate).getTime() ? '<div class="tooltip6"><img class="eliminar ICONO_VER_CORREGIR pointer" src="Resources/verCorreccion.png" onclick="showCorrection(' +
             row.id_entrega +
             ')" alt="Ver Corrección"/><span class="tooltiptext ICONO_VER_CORREGIR"></span></div>' : '';
        if (getCookie('userRole') == 'usuario') {
            celdaAcciones = celdaAccionesDescargar + celdaAccionesCorregir + celdaAccionesVerCorreccion;
        } else {
            celdaAcciones = '';
        }

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "<td class='fixed-column'>" +
            datosObjeto.name +
            "</td> <td class='text-nowrap'>" +
            celdaAcciones +
            "</td> </tr>";

        return rowTable;
    }
}

function download(id_entrega) {
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

function showCorrection(id_entrega) {
    deliveries = mapaAgrupadoPorEntrega.get(id_entrega);
    changeForm("correctionForm", "javascript:closeEntityModal(); loadAssignedCorrections();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(id_entrega, true);
    $("#formularioAcciones").modal("show");
    setLang(getCookie("lang"));
}

function correction(id_entrega) {
    deliveries = mapaAgrupadoPorEntrega.get(id_entrega);
    changeForm("correctionForm", "javascript:closeEntityModal(); loadAssignedCorrections();", "");
    document.getElementById('formularioGenerico').addEventListener('submit', function(event) {
         if(!checkAssignedCorrections(id_entrega, deliveries)) {
             event.preventDefault();
             return false;
         }
         return true;
    });
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(id_entrega, false);
    $("#formularioAcciones").modal("show");
    setLang(getCookie("lang"));
}

function clearModalErrors(selectedDelivery) {
    for (const delivery of selectedDelivery) {
        if (document.getElementById('select' + delivery['id_criterio'])) {
            deleteFieldId('select' + delivery['id_criterio']);
        }
        if (document.getElementById('textarea' + delivery['id_criterio'])) {
            deleteFieldId('textarea' + delivery['id_criterio']);
        }
    }
}

async function fillForm(id_entrega, readonly) {
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
                makeForm(id_entrega, selectedDelivery, readonly);
            })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
   }
   setLang(getCookie('lang'));
   document.formCriteria.remove();
}

async function makeForm(id_entrega, selectedDelivery, readonly) {
     // Iterar sobre el array de valores
     for (const delivery of selectedDelivery) {
         if (readonly) {
            createHideForm("formCorrectionTeacher");
            insertField(document.formCorrectionTeacher, "id_trabajo", delivery['id_trabajo']);
            insertField(document.formCorrectionTeacher, "id_criterio", delivery['id_criterio']);
            insertField(document.formCorrectionTeacher, "id_entrega", id_entrega);
            await ajaxPromise(document.formCorrectionTeacher, "search", "correctionTeacher", "RECORDSET_DATOS", true)
                .then(async (res) => {
                    correctionTeacher = res['resource'][0];
                })
            .catch((res) => {
                // Do nothing
            });
         }
       // Crear elementos HTML
       const divFormGroup = document.createElement('div');
       divFormGroup.classList.add('form-group');

       const label = document.createElement('label');
       label.textContent = criteriaMap.get(delivery['id_criterio']).descripcion;

       const p = document.createElement('p');
       p.textContent = translateWord("CORRECTO");

       const selectElement = document.createElement('select');
       selectElement.disabled = readonly;
       selectElement.classList.add("form-control");
       selectElement.id = 'select' + delivery['id_criterio'];
       selectElement.name = 'correccion_alumno' + '-' + delivery['id_criterio'];
       const option1 = document.createElement('option');
       option1.value = '3';
       option1.text = '----';
       option1.selected = delivery['correccion_alumno'] == '3' ? "selected" : "";
       const option2 = document.createElement('option');
       option2.value = '1';
       option2.text = translateWord("SI");
       option2.selected = delivery['correccion_alumno'] == '1' ? "selected" : "";
       const option3 = document.createElement('option');
       option3.value = '0';
       option3.text = translateWord("NO");
       option3.selected = delivery['correccion_alumno'] == '0' ? "selected" : "";

       if (!readonly) {
           selectElement.addEventListener('change', function(event) {

                correctionEntity(id_entrega, delivery['id_criterio']);
                const selectedOption = event.target.value;
                if (selectedOption == '1') {
                   textArea = document.getElementById('textarea' + delivery['id_criterio']);
                   errorTxtFormat = document.getElementById('errorTextFormat' + delivery['id_criterio']);
                   if (textArea) {
                     textArea.parentNode.removeChild(textArea);
                     divFormGroup.removeChild(errorTxtFormat);
                   }
                } else if (selectedOption == '0') {
                   textareaElement = document.createElement('textarea');
                   textareaElement.disabled = readonly;
                   textareaElement.id = 'textarea' + delivery['id_criterio'];
                   textareaElement.name = 'comentario_alumno' + '-' + delivery['id_criterio'];
                   textareaElement.rows = 4;
                   textareaElement.cols = 50;
                   textareaElement.classList.add("form-control");
                   textareaElement.addEventListener('blur', function() {
                        x1 = checkText('textarea' + delivery['id_criterio'], 'errorTextFormat' + delivery['id_criterio'], 'comentarioCorreccionCriterio');
                        if (x1) {
                            correctionEntity(id_entrega, delivery['id_criterio']);
                        } else {
                            return x1;
                        }
                   });
                   divFormGroup.appendChild(textareaElement);
                   const divErrorTextFormat = document.createElement('div');
                   divErrorTextFormat.id = 'errorTextFormat' + delivery['id_criterio'];
                   divErrorTextFormat.style.display = 'none';
                   divFormGroup.appendChild(divErrorTextFormat);
                }
           });
       }

       selectElement.appendChild(option1);
       selectElement.appendChild(option2);
       selectElement.appendChild(option3);
       selectElement.addEventListener('blur', function() {
         return checkSelectElement('select' + delivery['id_criterio'], 'errorFormat' + delivery['id_criterio'], 'correccionCriterio', ['0', '1', '3'], selectElement.value);
       });

       const divErrorFormat = document.createElement('div');
       divErrorFormat.id = 'errorFormat' + delivery['id_criterio'];
       divErrorFormat.style.display = 'none';

       // Agregar los elementos al div form-group
       divFormGroup.appendChild(label);
       divFormGroup.appendChild(p);
       divFormGroup.appendChild(selectElement);
       divFormGroup.appendChild(divErrorFormat);
       selectedOption = delivery['correccion_alumno'];
      if (selectedOption == '1') {
         textArea = document.getElementById('textarea' + delivery['id_criterio']);
         errorTxtFormat = document.getElementById('errorTextFormat' + delivery['id_criterio']);
         if (textArea) {
           textArea.parentNode.removeChild(textArea);
           divFormGroup.removeChild(errorTxtFormat);
         }
      } else if (selectedOption == '0') {
         textareaElement = document.createElement('textarea');
         textareaElement.disabled = readonly;
         textareaElement.id = 'textarea' + delivery['id_criterio'];
         textareaElement.name = 'comentario_alumno' + '-' + delivery['id_criterio'];
         textareaElement.rows = 4;
         textareaElement.cols = 50;
         textareaElement.classList.add("form-control");
         textareaElement.placeholder = translateWord("INDICAR_MOTIVO");
         textareaElement.value = delivery['comentario_alumno'];
         if (!readonly) {
             textareaElement.addEventListener('blur', function() {
                 x2 = checkText('textarea' + delivery['id_criterio'], 'errorTextFormat' + delivery['id_criterio'], 'comentarioCorreccionCriterio');
                 if (x2) {
                     correctionEntity(id_entrega, delivery['id_criterio']);
                 } else {
                     return x2;
                 }
             });
         }
         divFormGroup.appendChild(textareaElement);
         const divErrorTextFormat = document.createElement('div');
         divErrorTextFormat.id = 'errorTextFormat' + delivery['id_criterio'];
         divErrorTextFormat.style.display = 'none';
         divFormGroup.appendChild(divErrorTextFormat);
         divFormGroup.appendChild(document.createElement('br'));
      }

       // Resp. docente
       if (correctionTeacher && correctionTeacher['visible'] == '1') {
          const row = document.createElement('div');
          row.classList.add('form-group');
          row.classList.add('row');
          const col = document.createElement('div');
          col.classList.add('form-group');
          col.classList.add('col-12');
          const p = document.createElement('p');
          p.textContent = translateWord("CORRECCION_PROFESOR");
          const p2 = document.createElement('p');
          p2.textContent = translateWord("CORRECTO");
          const selectElementTeacher = document.createElement('select');
          selectElementTeacher.disabled = readonly;
          selectElementTeacher.classList.add("form-control");
          const option2 = document.createElement('option');
          option2.value = '1';
          option2.text = translateWord("SI");
          option2.selected = correctionTeacher['correccion_docente'] == '1' ? "selected" : "";
          const option3 = document.createElement('option');
          option3.value = '0';
          option3.text = translateWord("NO");
          option3.selected = correctionTeacher['correccion_docente'] == '0' ? "selected" : "";

          selectElementTeacher.appendChild(option2);
          selectElementTeacher.appendChild(option3);
          col.appendChild(p);
          col.appendChild(p2);
          col.appendChild(selectElementTeacher);

          // Comentario docente
          if (correctionTeacher['comentario_docente'] != null && correctionTeacher['comentario_docente'] != "") {
                textareaTeacherElement = document.createElement('textarea');
                textareaTeacherElement.disabled = readonly;
                textareaTeacherElement.value = correctionTeacher['comentario_docente'];
                textareaTeacherElement.rows = 4;
                textareaTeacherElement.cols = 50;
                textareaTeacherElement.classList.add("form-control");
                col.appendChild(textareaTeacherElement);
          }

          const p3 = document.createElement('p');
          result = delivery['correccion_alumno'] == delivery['correccion_docente'] || (delivery['comentario_docente'] != null && delivery['comentario_docente'] != "") ? translateWord("OK") : translateWord("KO");
          p3.textContent = translateWord("RESULTADO_CORRECCION") + result;
          p3.classList.add("mt-2");
          col.appendChild(p3);
          if (delivery['comentario_docente'] != null && delivery['comentario_docente'] != "") {
                const p4 = document.createElement('p');
                p4.textContent = translateWord("MOTIVO") + delivery['comentario_docente'];
                col.appendChild(p4);
          }
          row.appendChild(col);
          divFormGroup.appendChild(row);
       }

       const contenedor = document.getElementById('datosMateria');

       // Agregar el div form-group al contenedor
       contenedor.appendChild(divFormGroup);
     }
}

function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}

async function correctionEntity(id_entrega, id_criterio) {
    correccionAlumno = document.getElementById('select' + id_criterio) ? document.getElementById('select' + id_criterio).value : '';
    const comentarioAlumno = document.getElementById('textarea' + id_criterio) ? document.getElementById('textarea' + id_criterio).value : '';

    createHideForm('editCorrectionCriteria');
    insertField(document.editCorrectionCriteria, "correccion_alumno", correccionAlumno);
    insertField(document.editCorrectionCriteria, "comentario_alumno", comentarioAlumno);
    const id_correccion_criterio = mapaAgrupadoPorEntrega.get(parseInt(id_entrega)).find(item2 => item2.id_criterio === id_criterio).id_correccion_criterio;
    insertField(document.editCorrectionCriteria, "id_correccion_criterio", id_correccion_criterio);
    await ajaxPromise(document.editCorrectionCriteria, "edit", "correctionCriteria", "EDITAR_CORRECCION_CRITERIO_OK", true)
    .then((res) => {
        // Do nothing
    })
    .catch((res) => {
        // Do nothing
    });
    document.editCorrectionCriteria.remove();
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'usuario' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x;

    displayBlock("bnombre");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bnombre");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadAssignedCorrections();
}

function filtrar() {
    x = originalUsers;

    nombre = document.getElementById("bnombre").value;
    if (nombre != null && nombre != "") {
        x = x.filter(function (value) {
            const datosObjeto = JSON.parse(value.datos);
            return datosObjeto.name.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(nombre.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

    x.total = x.length;
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