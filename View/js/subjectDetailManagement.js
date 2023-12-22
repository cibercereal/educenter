var x;
var subject;
var projects = new Map();

async function loadProject() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("GESTION_MATERIAS") + ": " + getCookie("subjectName");
    createHideForm("formSubjectDetail");
    insertField(document.formSubjectDetail, "id_materia", getCookie('subject'));
    addActionControler(document.formSubjectDetail, "search", "project");

    await loadProjectAjaxPromise()
        .then(async (res) => {
            for (var i = 0; i < res['resource'].length; i++) {
                var projectId = res['resource'][i].id_trabajo;
                // Usamos "await" dentro de un bloque "async" para esperar la ejecución de loadDeliveryAjaxPromise()
                const res2 = await loadDeliveryAjaxPromise(projectId);
                projects.set(projectId, res2['resource']);
            }
            loadData(res);
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

async function loadDeliveryAjaxPromise(id_trabajo) {
    var lang = getCookie("lang");
    var token = getCookie("token");

    createHideForm("formDeliveyDetail");
    insertField(document.formDeliveyDetail, "id_trabajo", id_trabajo);
    if (getCookie('userRole') == 'usuario') {
        insertField(document.formDeliveyDetail, "dni", getCookie('userSystem'));
    }
    addActionControler(document.formDeliveyDetail, "search", "delivery");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: "../Backend/index.php",
                data: $("#formDeliveyDetail").serialize(),
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

function loadProjectAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formSubjectDetail").serialize(),
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
            fecha_ini: new Date(item.fecha_ini).toLocaleDateString('es-ES', options),
            fecha_fin: new Date(item.fecha_fin).toLocaleDateString('es-ES', options)
        };
    });
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", res.total);
        pager("subject");
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

function addButton() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success ANADIR_TRABAJO mb-3 mr-3" data-toggle="modal" data-target="#trabajo-modal" class="tooltip"></button>' : '';

    document.getElementById("btnAdd").innerHTML += showBtn;
}

function addCompetence() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success ANADIR_COMPETENCIA mb-3 mr-3" data-toggle="modal" data-target="#competencia-modal" class="tooltip"></button>' : '';

    document.getElementById("btnAddCompetence").innerHTML += showBtn;
}

function assignCompetence() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-warning ASIGNAR_COMPETENCIA mb-3 mr-3" data-toggle="modal" data-target="#asignarCompetencia-modal" class="tooltip" onclick="loadCompetences()"></button>' : '';

    document.getElementById("btnAssignCompetence").innerHTML += showBtn;
}

function btnShowGrades() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-info VER_NOTAS_ALUMNOS mb-3 ml-3" onclick="loadGradesStudents(' + getCookie('subject') + ')"></button>' : '';

    document.getElementById("btnShowGrades").innerHTML += showBtn;
}

function makeRow(row) {
    if (row != null) {
        atributosFunciones = [
            "'" + row.id_trabajo + "'",
            "'" + row.nombre_trabajo + "'",
            "'" + row.correccion_nota + "'",
            "'" + row.porcentaje_nota + "'",
            "'" + row.fecha_ini + "'",
            "'" + row.fecha_fin + "'",
            "'" + row.id_materia.id_materia + "'",
            "'" + row.descripcion_trabajo + "'",
        ];
        var today = new Date(Date.now()).getTime();
        partesFecha = row.fecha_fin.split('/');
        fechaFormateada = `${partesFecha[2]}-${partesFecha[1]}-${partesFecha[0]}`;
        const fechaFinMs = new Date(fechaFormateada).getTime();
        partesFecha2 = row.fecha_ini.split('/');
        fechaFormateada2 = `${partesFecha2[2]}-${partesFecha2[1]}-${partesFecha2[0]}`;
        const fechaIniMs = new Date(fechaFormateada2).getTime();
        var elem = today < fechaFinMs && today > fechaIniMs ? "ABIERTO" : "CERRADO";
        celdaAccionesDetalle =
            '<div class="tooltip6"><img class="detalle ICONO_DETALLE pointer" src="Resources/detail3.png" onclick="showDetail(' +
            atributosFunciones +
            ')" alt="Detalle"/><span class="tooltiptext ICONO_DETALLE pointer"></span></div>';
        celdaAccionesEditar =
            '<div class="tooltip6"><img class="editar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="showEdit(' +
            atributosFunciones +
            ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT pointer"></span></div>';
        celdaAccionesEntrega =
            elem == "ABIERTO" && projects.get(row.id_trabajo).length == 0 ? '<div class="tooltip6"><img class="entregar ICONO_ENTREGAR pointer" src="Resources/delivery.png" onclick="makeDelivery(' +
            atributosFunciones +
            ')" alt="Entregar"/><span class="tooltiptext ICONO_ENTREGAR pointer"></span></div>' : '';
        celdaAccionesModificarEntrega =
            elem == "ABIERTO" && projects.get(row.id_trabajo).length != 0 ? '<div class="tooltip6"><img class="editar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="editDelivery(' +
            atributosFunciones +
            ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT pointer"></span></div>' : '';
        celdaAccionesDetalleEntrega =
            projects.get(row.id_trabajo).length != 0 ? '<div class="tooltip6"><img class="detalle ICONO_DETALLE pointer" src="Resources/detail3.png" onclick="showDeliveryDetail(' +
            atributosFunciones +
            ')" alt="Detalle"/><span class="tooltiptext ICONO_DETALLE pointer"></span></div>' : '<p class="NO_ENTREGADO"></p>';
        celdaAccionesEliminar =
            '<div class="tooltip6"><img class="eliminar ICONO_ELIMINAR pointer" src="Resources/delete3.png" id='+atributosFunciones[0]+' onclick="showDelete(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>';
        celdaAccionesEliminarEntrega =
            elem == "ABIERTO" && projects.get(row.id_trabajo).length != 0 ? '<div class="tooltip6"><img class="eliminar ICONO_ELIMINAR pointer" src="Resources/delete3.png" id='+atributosFunciones[0]+' onclick="showDeliveryDelete(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>' : '';
        celdaAccionesVerDocumentos = getCookie('userRole') == 'docente'
            ? '<div class="tooltip6"><img class="eliminar ICONO_DOCUMENTO pointer" src="Resources/archivo.png" onclick="showDocs(' +
              atributosFunciones[6] + ", " + atributosFunciones[0] + ", " + atributosFunciones[1] +
              ')" alt="Ver criterios"/><span class="tooltiptext ICONO_DOCUMENTO pointer"></span></div>'
            : '';
        celdaAccionesCriterios = getCookie('userRole') == 'docente'
            ? '<div class="tooltip6"><img data-toggle="modal" class="eliminar ICONO_CRITERIOS pointer" src="Resources/criterios.png" onclick="viewCriteria(' +
              atributosFunciones[0] + ", " + atributosFunciones[1] +
              ')" alt="Ver documentos"/><span class="tooltiptext ICONO_CRITERIOS pointer"></span></div>'
            : '';
        celdaAccionesCorreccionesAsignadas = getCookie('userRole') == 'usuario' && elem != "ABIERTO"
            ? '<div class="tooltip6"><img data-toggle="modal" class="eliminar ICONO_CORRECCION_ASIGNADA pointer" src="Resources/corregir.png" onclick="correctionsAssigned(' +
              atributosFunciones[0] + ", " + atributosFunciones[1] +
              ')" alt="Correcciones asignadas"/><span class="tooltiptext ICONO_CORRECCION_ASIGNADA pointer"></span></div>'
            : '';
            celdaAccionesCalcularNota = getCookie('userRole') == 'docente' && elem != "ABIERTO"
            ? '<div class="tooltip6"><img data-toggle="modal" class="eliminar ICONO_CALCULAR_NOTA pointer" src="Resources/calculadora.png" onclick="calculateGrades(' +
              atributosFunciones[0] +
              ')" alt="Calcular nota"/><span class="tooltiptext ICONO_CALCULAR_NOTA pointer"></span></div>'
            : '';
            celdaAccionesVerNotas = getCookie('userRole') == 'docente' && elem != "ABIERTO"
            ? '<div class="tooltip6"><img data-toggle="modal" class="eliminar ICONO_VER_NOTA pointer" src="Resources/calificacion.png" onclick="showGrades(' +
              atributosFunciones[0] + ", " + atributosFunciones[1] + ", " + atributosFunciones[6] +
              ')" alt="Ver notas"/><span class="tooltiptext ICONO_VER_NOTA pointer"></span></div>'
            : '';
            celdaAccionesVerNotaAlumno = getCookie('userRole') == 'usuario' && elem != "ABIERTO"
            ? '<div class="tooltip6"><img data-toggle="modal" class="eliminar ICONO_VER_NOTA pointer" src="Resources/calificacion.png" onclick="showProjectGrade(' +
              atributosFunciones[0] + ", " + atributosFunciones[1] + ", " + atributosFunciones[6] +
              ')" alt="Ver notas"/><span class="tooltiptext ICONO_VER_NOTA pointer"></span></div>'
            : '';
        if (getCookie('userRole') == 'administrador') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar + celdaAccionesEliminar;
        } else if (getCookie('userRole') == 'usuario') {
            celdaAcciones = celdaAccionesDetalleEntrega + celdaAccionesEntrega + celdaAccionesModificarEntrega + celdaAccionesEliminarEntrega + celdaAccionesCorreccionesAsignadas + celdaAccionesVerNotaAlumno;
        } else if (getCookie('userRole') == 'docente') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar + celdaAccionesEliminar + celdaAccionesVerDocumentos + celdaAccionesCriterios + celdaAccionesCalcularNota + celdaAccionesVerNotas;
        } else {
            celdaAcciones = '';
        }
        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.nombre_trabajo +
            "</td> <td>" +
            row.porcentaje_nota +
            "</td> <td>" +
            row.fecha_ini +
            "</td> <td>" +
            row.fecha_fin +
            "</td> <td class='" +
            elem +
            "'></td>" +
            "<td class='text-nowrap'>" +
            celdaAcciones
        "</td> </tr>";

        return rowTable;
    }
}

async function addProject() {
    insertField(document.formularioAnadirTrabajo, "id_materia", getCookie('subject'));
    await ajaxPromise(document.formularioAnadirTrabajo, "add", "project", "ANADIR_TRABAJO_OK", false)
        .then((res) => {
            $("#trabajo-modal").modal("toggle");

            ajaxResponseOK("ANADIR_TRABAJO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#trabajo-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "nombreT",
                "descripcionT",
                "porcentajeNotaT",
                "porcentajeCorreccionT",
                "fechaIniT",
                "fechaFinT",
                "descripcionT",
            ];
            resetForm("formularioAnadirTrabajo", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
        deleteFieldId("id_materia");
}

async function addCompetenceBD() {
    await ajaxPromise(document.formularioAnadirCompetencia, "add", "competence", "ANADIR_COMPETENCIA_OK", false)
        .then((res) => {
            $("#competencia-modal").modal("toggle");
            ajaxResponseOK("ANADIR_COMPETENCIA_OK", res.code);

            let idElementoList = [
                "tituloC",
                "descripcionC",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAnadirCompetencia", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#competencia-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "tituloC",
                "descripcionC",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAnadirCompetencia", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

async function deliveryEntity() {

   const archivo = document.getElementById("input_datos").files[0];

   var token = getCookie("token");
   return new Promise((resolve, reject) => {
           const formData = new FormData(document.formularioGenerico);
           formData.append("action", "add");
           formData.append("controller", "delivery");

           // Aquí utilizamos fetch para realizar la solicitud AJAX
           fetch(URL_REST, {
               method: "POST",
               body: formData,
               headers: token != null ? { Authorization: token } : "",
           })
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("ANADIR_ENTREGA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_datos",
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
        });
}

async function editDeliveryEntity() {
    var token = getCookie("token");
    insertField(document.formularioGenerico, "datos", document.getElementById("input_datos").files[0]);
    return new Promise((resolve, reject) => {
               const formData = new FormData(document.formularioGenerico);
               formData.append("action", "edit");
               formData.append("controller", "delivery");

               // Aquí utilizamos fetch para realizar la solicitud AJAX
               fetch(URL_REST, {
                   method: "POST",
                   body: formData,
                   headers: token != null ? { Authorization: token } : "",
               })

            .then((res) => {
                $("#formularioAcciones").modal("toggle");

                ajaxResponseOK("EDITAR_ENTREGA_OK", res.code);

                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
            })
            .catch((res) => {
                $("#formularioAcciones").modal("toggle");
                ajaxResponseKO(res.code);
                let idElementoList = [
                    "input_datos",
                ];

                resetForm("formularioGenerico", idElementoList);
                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
            });
            });
}

async function editProject(id_materia, id_trabajo) {
    insertField(document.formularioGenerico, "id_trabajo", id_trabajo);
    insertField(document.formularioGenerico, "id_materia", id_materia);
    await ajaxPromise(document.formularioGenerico, "edit", "project", "EDITAR_TRABAJO_OK", false)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_TRABAJO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_nombre_trabajo",
                "input_porcentaje_nota",
                "input_correccion_nota",
                "input_fecha_ini",
                "input_fecha_fin",
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDeliveryDelete(id_trabajo, nombre) {
    $('#myModalDel').modal('show');
        document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
        document.getElementById("btnDelete").addEventListener('click', () => {
        deleteDelivery(projects.get(parseInt(id_trabajo))[0].id_entrega);
    });
}

function showDelete(id_trabajo, nombre) {
    $('#myModalDel').modal('show');
        document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
        document.getElementById("btnDelete").addEventListener('click', () => {
        deleteProject(id_trabajo);
    });
}

async function deleteDelivery(id) {
    data = {
        "action": "delete",
        "controller": "delivery",
        "id_entrega": id
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_ENTREGA_OK", false)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_ENTREGA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

async function deleteProject(id) {
    data = {
        "action": "delete",
        "controller": "project",
        "id_trabajo": id
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_TRABAJO_OK", false)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_TRABAJO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
            loadProject();
        })
        .catch((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function editDelivery(id_trabajo, nombre_trabajo, porcentaje_nota, fecha_ini, fecha_fin, id_materia) {
   var lang = getCookie("lang");
       var fields = [
           "input_datos",
       ];
       makeDeliveryStructure();
       changeForm(
           "entregaForm",
           "javascript:editDeliveryEntity();",
           "return checkDelivery();"
       );
       insertField(document.formularioGenerico, "id_entrega", projects.get(parseInt(id_trabajo))[0].id_entrega);
       changeOnBlurFields(
           "return checkData('input_datos', 'errorFormatData', 'data')",
       );
       changeIcon("Resources/delivery.png", "ICONO_ENTREGAR", "iconoEditarRol", "Entregar");
       if (getCookie('userRole') != 'usuario') {
           disableFields(fields);
       }

       var link = document.getElementById('descargarEnlace');
       var date = document.getElementById('input_fecha_entrega');
       hideElements(link, date, document.getElementById('input_descripcion_trabajo'));
       disableFields(["input_nombre_trabajo", "input_porcentaje_nota", "input_correccion_nota", "input_fecha_ini", "input_fecha_fin", "input_descripcion_trabajo"]);
       $("#formularioAcciones").modal("show");
       setLang(lang);
}

function showEdit(id_trabajo, nombre_trabajo, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, id_materia, descripcion_trabajo) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + nombre_trabajo;
    var lang = getCookie("lang");
    var campos = ["input_nombre_trabajo", "input_correccion_nota", "input_porcentaje_nota", "input_fecha_ini", "input_fecha_fin"];
    editProjectStructure();
    changeForm("editForm", "javascript:editProject("+id_materia+","+id_trabajo+");", "return checkEditProject();");
    changeOnBlurProjectFields(
        "return checkName('input_nombre_trabajo', 'errorFormatNombreTrabajo', 'nameProject')",
        "return checkNotePercent('input_porcentaje_nota', 'errorFormatPorcentajeNota', 'notePercentProject')",
        "return checkCorrectionPercent('input_correccion_nota', 'errorFormatCorreccionNota', 'correctionPercentProject')",
        "return checkInitDate('input_fecha_ini', 'errorFormatFechaIni', 'correctionInitDateProject')",
        "return checkEndDate('input_fecha_fin', 'errorFormatFechaFin', 'correctionEndDateProject')",
        "return checkDescription('input_descripcion_trabajo', 'errorFormatDescripcionTrabajo', 'correctionDescriptionProject')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillFormProject(nombre_trabajo, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, descripcion_trabajo);
    disableFields(["input_datos", "input_fecha_entrega"]);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function hideElements(link, date, projectDescription) {
    if (link) {
        link.style.display = 'none';
    }
    if(date) {
        date.style.display = 'none';
    }
    if(projectDescription) {
        $("#label_descripcion_trabajo").attr("style", "display: none");
        projectDescription.style.display = 'none';
    }
}

function hideElementsStudent(input_nombre_trabajo, input_porcentaje_nota, input_correccion_nota, input_fecha_ini, input_fecha_fin) {
    document.getElementById(input_nombre_trabajo).style.display = 'none';
    document.getElementById(input_porcentaje_nota).style.display = 'none';
    document.getElementById(input_correccion_nota).style.display = 'none';
    document.getElementById(input_fecha_ini).style.display = 'none';
    document.getElementById(input_fecha_fin).style.display = 'none';
}

function descargarArchivo(id_trabajo) {
    return new Promise((resolve, reject) => {
        // Realizar una solicitud AJAX al servidor para obtener el archivo
        var xhr = new XMLHttpRequest();
        const jsonData = JSON.parse(projects.get(parseInt(id_trabajo))[0].datos);
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

function showDeliveryDetail(id_trabajo, nombre_trabajo, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, id_materia, descripcion_trabajo) {
    var idioma = getCookie("lang");
    var campos = [
        "input_datos",
        "input_fecha_entrega",
        "input_nombre_trabajo",
        "input_porcentaje_nota",
        "input_correccion_nota",
        "input_fecha_ini",
        "input_fecha_fin",
        "input_descripcion_trabajo"
    ];
    seeInDetailTeacherStructure();
    changeForm("deliveryDetailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(id_trabajo, descripcion_trabajo);
    disableFields(campos);
    var input = document.getElementById('label_datos');
    hideElements(input);
    if (getCookie('userRole') == 'usuario') {
        hideElementsStudent("input_nombre_trabajo", "input_porcentaje_nota", "input_correccion_nota", "input_fecha_ini", "input_fecha_fin");
    }
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

function showDetail(id_trabajo, nombre_trabajo, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, id_materia, descripcion_trabajo) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_VER") + " " + nombre_trabajo;
    var idioma = getCookie("lang");
    var campos = ["input_nombre_trabajo", "input_descripcion_trabajo", "input_correccion_nota", "input_porcentaje_nota", "input_fecha_ini", "input_fecha_fin"];
    seeInDetailTeacherStructure();
    changeForm("detailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillFormProject(nombre_trabajo, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, descripcion_trabajo);
    disableFields(campos);
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

function editProjectStructure() {
     clearModalErrors();
     activateFieldsBlockTeacherDetail();
     hideTeacherRequired();
     showLabelsTeacherDetail();
}

function fillFormProject(nombre, correccion_nota, porcentaje_nota, fecha_ini, fecha_fin, descripcion_trabajo) {
    $("#input_nombre_trabajo").val(nombre);
    $("#input_correccion_nota").val(correccion_nota);
    $("#input_porcentaje_nota").val(porcentaje_nota);
    $("#input_fecha_ini").val(convertirFecha(fecha_ini));
    $("#input_fecha_fin").val(convertirFecha(fecha_fin));
    $("#input_descripcion_trabajo").val(descripcion_trabajo);
}

function fillForm(id_trabajo, descripcion_trabajo) {
    const elem = projects.get(parseInt(id_trabajo))[0];
    const deliveryDate = elem['fecha_entrega'];

    $("#input_fecha_entrega").val(deliveryDate);
    $("#input_descripcion_trabajo").val(descripcion_trabajo);
    $("#descargarEnlace").click(function() {
        descargarArchivo(id_trabajo);
    });
}

function makeDelivery(id_trabajo, nombre_trabajo, porcentaje_nota, fecha_ini, fecha_fin, id_materia) {
   var lang = getCookie("lang");
    var fields = [
        "input_datos",
    ];
    makeDeliveryStructure();
    changeForm(
        "entregaForm",
        "javascript:deliveryEntity();",
        "return checkDelivery();"
    );
    insertField(document.formularioGenerico, "id_trabajo", id_trabajo);
    insertField(document.formularioGenerico, "dni", getCookie('userSystem'));

    changeOnBlurFields(
        "return checkData('input_datos', 'errorFormatData', 'data')",
    );
    changeIcon("Resources/delivery.png", "ICONO_ENTREGAR", "iconoEditarRol", "Entregar");
    if (getCookie('userRole') != 'usuario') {
        disableFields(fields);
    }
    var link = document.getElementById('descargarEnlace');
    var date = document.getElementById('input_fecha_entrega');
    hideElements(link, date);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function changeOnBlurFields(
    onBlurDatos
) {
    if (onBlurDatos != "") {
        $("#input_datos").attr("onblur", onBlurDatos);
    }
}

function changeOnBlurProjectFields(onBlurName, onBlurNotePercent, onBlurCorrectionNote, onBlurInitDate, onBlurEndDate, onBlurDescription) {
    $("#input_nombre_trabajo").attr("onblur", onBlurName);
    $("#input_porcentaje_nota").attr("onblur", onBlurNotePercent);
    $("#input_correccion_nota").attr("onblur", onBlurCorrectionNote);
    $("#input_fecha_ini").attr("onblur", onBlurInitDate);
    $("#input_fecha_fin").attr("onblur", onBlurEndDate);
    $("#input_descripcion_trabajo").attr("onblur", onBlurDescription);
}

function makeDeliveryStructure() {
    clearModalErrors();
    activateFieldsBlock();
    hideRequired();
    showLabels();
}

function seeInDetailStructure() {
     clearModalErrors();
     activateFieldsBlockDetail();
     hideRequired();
     showLabelsDetail();
}

function seeInDetailTeacherStructure() {
     clearModalErrors();
     activateFieldsBlockTeacherDetail();
     hideTeacherRequired();
     showLabelsTeacherDetail();
     if (getCookie('userRole') == 'usuario') {
        $("#label_fecha_entrega").attr("style", "display: block");
        $("#label_descripcion_trabajo").attr("style", "display: block");
        $("#input_datos").attr("style", "display: none");
        activateFieldsBlockDetail();
     }
}

function showLabelsDetail() {
    $("#label_fecha_entrega").attr("style", "display: block");
    $("#label_descripcion_trabajo").attr("style", "display: block");
    $("#label_correccion_nota").attr("style", "display: block");
    $("#label_porcentaje_nota").attr("style", "display: block");
    $("#label_fecha_ini").attr("style", "display: block");
    $("#label_fecha_fin").attr("style", "display: block");
}

function showLabelsTeacherDetail() {
    if (getCookie('userRole') == 'docente') {
        $("#label_nombre_trabajo").attr("style", "display: block");
        $("#label_correccion_nota").attr("style", "display: block");
        $("#label_porcentaje_nota").attr("style", "display: block");
        $("#label_fecha_ini").attr("style", "display: block");
        $("#label_fecha_fin").attr("style", "display: block");
        $("#label_descripcion_trabajo").attr("style", "display: block");
        $("#label_competence_info").attr("style", "display: block");
    }
}

function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}

function clearModalErrors() {
    let errores = [
        "errorFormatData",
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlockDetail() {
    $("#input_fecha_entrega").attr("style", "display: block");
    $("#input_descripcion_trabajo").attr("style", "display: block");
    $("#descargarEnlace").attr("style", "display: block");

    enableFields([
        "input_fecha_entrega",
        "descargarEnlace"
    ]);
}

function activateFieldsBlockTeacherDetail() {
    if (getCookie('userRole') == 'docente') {
        $("#input_nombre_trabajo").attr("style", "display: block");
        $("#input_porcentaje_nota").attr("style", "display: block");
        $("#input_correccion_nota").attr("style", "display: block");
        $("#input_fecha_ini").attr("style", "display: block");
        $("#input_fecha_fin").attr("style", "display: block");
        $("#input_descripcion_trabajo").attr("style", "display: block");

        enableFields([
            "input_nombre_trabajo",
            "input_porcentaje_nota",
            "input_correccion_nota",
            "input_fecha_ini",
            "input_fecha_fin",
            "input_descripcion_trabajo",
        ]);
    }
}

function activateFieldsBlock() {
    $("#input_datos").attr("style", "display: block");
    $("#input_fecha_entrega").attr("style", "display: block");

    enableFields([
        "input_datos",
        "input_fecha_entrega",
    ]);
}

function hideRequired() {
    $("#obligatorio_datos").attr("style", "display: none");
}

function hideTeacherRequired() {
    $("#obligatorio_nombre_entrega").attr("style", "display: none");
    $("#obligatorio_porcentaje_nota").attr("style", "display: none");
    $("#obligatorio_correccion_nota").attr("style", "display: none");
    $("#obligatorio_fecha_ini").attr("style", "display: none");
    $("#obligatorio_fecha_fin").attr("style", "display: none");
}

function showLabels() {
    $("#label_datos").attr("style", "display: block");
    $("#label_fecha_entrega").attr("style", "display: none");
}

function showDocs(id_materia, id_trabajo, nombre_trabajo) {
    setCookie("subject", id_materia);
    setCookie("project", id_trabajo);
    setCookie("projectName", nombre_trabajo);
    window.location.href = "./subjectDeliveriesManagement.html";
}

async function loadCompetences() {
    var select = $("#select_id_competencia");

    select.empty();

    var option1 = document.createElement("option");
    option1.setAttribute("value", "");
    option1.setAttribute("label", "-----");
    option1.setAttribute("class", "-----");
    option1.setAttribute("selected", "true");
    select.append(option1);

    var lang = getCookie("lang");
    createHideForm("formCompetences", "javascript:competences()");
    await ajaxPromise(document.formCompetences, "search", "competence", "RECORDSET_DATOS", true)
        .then((res) => {
            for (var i = 0; i < res.total; i++) {
                if (res['resource'][i] != null && res['resource'][i].id_materia == null) {
                  var option = document.createElement("option");
                  option.setAttribute("value", res['resource'][i].id_competencia);
                  option.setAttribute("name", "id_competencia");
                  optionTexto = document.createTextNode(res['resource'][i].titulo);
                  option.appendChild(optionTexto);
                  select.append(option);
                }
            }
        });
}

async function assignCompetenceBD() {
    insertField(document.formularioAsignarCompetencia, "id_materia", getCookie("subject"));
    await ajaxPromise(document.formularioAsignarCompetencia, "assignCompetence", "competence", "ASIGNAR_COMPETENCIA_OK", true)
        .then((res) => {
            $("#asignarCompetencia-modal").modal("toggle");
            ajaxResponseOK("ASIGNAR_COMPETENCIA_OK", res.code);

            let idElementoList = [
                "select_id_competencia",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAsignarCompetencia", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#asignarCompetencia-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "select_id_competencia",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAsignarCompetencia", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function competenceInfo() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-info COMPETENCIAS mb-3" data-toggle="modal" class="tooltip"></button>' : '';
    document.getElementById("btnCompetenceInfo").addEventListener("click", function() {
        window.location.href = "./competenceDetail.html";
    });
    document.getElementById("btnCompetenceInfo").innerHTML += showBtn;
}

function viewCriteria(id_trabajo, nombre_trabajo) {
    setCookie("project", id_trabajo);
    setCookie("projectName", nombre_trabajo);
    window.location.href = "./criteriaDetail.html";
}

function correctionsAssigned(id_trabajo, nombre_trabajo) {
    setCookie("project", id_trabajo);
    setCookie("projectName", nombre_trabajo);
    window.location.href = "./assignedCorrections.html";
}

async function calculateGrades(id_trabajo) {
    for (delivery of projects.get(parseInt(id_trabajo))) {
        createHideForm("formCalculateGrades");
        insertField(document.formCalculateGrades, "id_trabajo", id_trabajo);
        insertField(document.formCalculateGrades, "id_entrega", delivery.id_entrega);
        insertField(document.formCalculateGrades, "visible", "0");

        await ajaxPromise(document.formCalculateGrades, "edit", "gradeProject", "EDITAR_CALCULAR_NOTA_OK", true)
            .then((res) => {
                ajaxResponseOK("EDITAR_CALCULAR_NOTA_OK", res.code);

                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
            })
            .catch((res) => {
                ajaxResponseKO(res.code);

                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
        });
        document.formCalculateGrades.remove();
    }
}

function showGrades(id_trabajo, nombre_trabajo, id_materia) {
    setCookie("subject", id_materia);
    setCookie("project", id_trabajo);
    setCookie("projectName", nombre_trabajo);
    window.location.href = "./projectGradeManagement.html";
}

function loadGradesStudents(id_materia) {
    setCookie("subject", id_materia);
    setCookie("subjectName", getCookie("subjectName"));
    window.location.href = "./projectAllGrades.html";
}

function showProjectGrade(id_trabajo, nombre_trabajo, id_materia) {
    setCookie("subject", id_materia);
    setCookie("project", id_trabajo);
    setCookie("projectName", nombre_trabajo);
    window.location.href = "./projectGrade.html";
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'docente' || getCookie('userRole') == 'usuario' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';


    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bnombre");
    displayBlock("bporcentajenota");
    displayBlock("bfechaini");
    displayBlock("bfechafin");
    displayBlock("bestado");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bporcentajenota");
    valueNullAndDisplayNone("bfechaini");
    valueNullAndDisplayNone("bfechafin");
    valueNullAndDisplayNone("bestado");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadProject();
}

function filtrar() {
    x.resource = originalUsers;
    filterElement(x, "nombre_trabajo", "bnombre");
    filterElement(x, "porcentaje_nota", "bporcentajenota");
    filterElement(x, "fecha_ini", "bfechaini");
    filterElement(x, "fecha_fin", "bfechafin");

    const state = document.getElementById("bestado").value;
    if (state != null && state != "") {
        var today = new Date(Date.now()).getTime();
            x.resource = x.resource.filter(function (value) {
            actState = today < new Date(value.fecha_fin).getTime() && today > new Date(value.fecha_ini).getTime() ? "ABIERTO" : "CERRADO";
            return actState.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(state.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

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

