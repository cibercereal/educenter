var x;
var subjectTeacherData;

async function loadSubjects() {
    if (getCookie('userRole') == 'docente') {
        var lang = getCookie("lang");
        createHideForm("formSubjectManagement");
        insertField(document.formSubjectManagement, "id_curso_academico", getCookie('academicCourse'));
        addActionControler(document.formSubjectManagement, "search", "subject");

        await loadSubjectDataAjaxPromise()
            .then((res) => {
                if (getCookie('userRole') == 'docente') {
                    loadSubjectTeacherData()
                    .then((res2) => {
                        subjectTeacherData = res2['resource'];
                        elem = [];
                        for (var i = 0; i < res['resource'].length; i++) {
                            elem = res['resource'].filter(item => item.dni == null || item.dni.dni != getCookie('userSystem'));
                        }
                        elem2 = [];
                        for (var i = 0; i < res2['resource'].length; i++) {
                            const id_materia = res2['resource'][i].id_materia;
                            if (elem.some(item => item.id_materia === id_materia)) {
                                elem = elem.filter(item => item.id_materia !== id_materia);
                            }
                        }
                        res2['resource'] = elem;
                        res2['total'] = elem.length;
                        loadData(res2);
                    })
                }
            })
            .catch((res) => {
                ajaxResponseKO(res.code);
            });
        setLang(lang);
        deleteActionController();
    }
}

function loadSubjectDataAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formSubjectManagement").serialize(),
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

async function loadSubjectTeacherData() {
    var lang = getCookie("lang");
    createHideForm("formSubject2Management");
    insertField(document.formSubject2Management, "dni", getCookie('userSystem'));
    addActionControler(document.formSubject2Management, "search", "subjectAssignment");

    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formSubject2Management").serialize(),
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
    setLang(lang);
    deleteActionController();
}

function loadData(res) {
    x = res;
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

function makeRow(row) {
    if (row != null) {
        var profesor = row.dni != null ? row.dni.nombre + " " + row.dni.apellidos_usuario : '';
        atributosFunciones = [
            "'" + row.id_materia + "'",
            "'" + row.nombre_materia + "'",
            "'" + row.creditos + "'",
            "'" + profesor + "'"
        ];

        var deleteRequest = false;
        var addRequest = false;
        var addPpalRequest = true;
        if (row.dni != null) {
            addPpalRequest = false;
            addRequest = true;
        }
        for (var i = 0; i < subjectTeacherData.length; i++) {
            if (subjectTeacherData[i].id_materia.id_materia == row.id_materia && subjectTeacherData[i].secundario != 0 && subjectTeacherData[i].secundario != 1) {
                deleteRequest = true;
                addRequest = false;
                addPpalRequest = false;
                break;
            } else if (subjectTeacherData[i].id_materia.id_materia == row.id_materia && subjectTeacherData[i].secundario != null) {
                addRequest = false;
            }
        }

        celdaAccionesEliminarPpal =
            deleteRequest ? '<div class="tooltip6"><img class="detalle ICONO_ELIMINAR pointer" src="Resources/delete3.png" onclick="showPpalDelete(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>' : '';
        celdaAccionesSolicitar =
            addRequest ? '<div class="tooltip6"><img class="entregar ICONO_SOLICITAR pointer" src="Resources/delivery.png" onclick="makeRequest(' +
            atributosFunciones[0] +
            ')" alt="Solicitar"/><span class="tooltiptext ICONO_SOLICITAR pointer"></span></div>' : '';
        celdaAccionesSolicitarPpal =
            addPpalRequest ? '<div class="tooltip6"><img class="entregar ICONO_SOLICITAR_PPAL pointer" src="Resources/delivery.png" onclick="makeRequest(' +
            atributosFunciones[0] +
            ')" alt="Solicitar"/><span class="tooltiptext ICONO_SOLICITAR_PPAL pointer"></span></div>' : '';


        if (getCookie('userRole') == 'docente') {
            celdaAcciones = celdaAccionesEliminarPpal + celdaAccionesSolicitar + celdaAccionesSolicitarPpal;
        } else {
            celdaAcciones = '';
        }

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.nombre_materia +
            "</td> <td>" +
            row.creditos +
            "</td> <td>" +
            getTeacherData(row) +
            "</td>" +
            "<td class='text-nowrap'>" +
            celdaAcciones
        "</td> </tr>";

        return rowTable;
    }
}

function getTeacherData(row) {
    return row.dni != null ? row.dni.nombre + " " + row.dni.apellidos_usuario : "";
}

async function makeRequest(id_materia, nombre_materia, creditos, profesor) {
    var lang = getCookie("lang");
    createHideForm("formularioAnadirSolicitud");
    insertField(document.formularioAnadirSolicitud, "id_materia", id_materia);
    insertField(document.formularioAnadirSolicitud, "dni", getCookie('userSystem'));
    await ajaxPromise(document.formularioAnadirSolicitud, "add", "subjectAssignment", "SOLICITUD_ASIGNACION_OK", false)
        .then((res) => {
            ajaxResponseOK("SOLICITUD_ASIGNACION_OK", res.code);

            setLang(lang);
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            ajaxResponseKO(res.code);

            setLang(lang);
            document.getElementById("modal").style.display = "block";
        });
    deleteActionController();
}

async function showPpalDelete(id_materia, nombre) {
    $('#myModalDel').modal('show');
    document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteRequest(id_materia);
    });
}

async function deleteRequest(id) {
    data = {
        "action": "delete",
        "controller": "subjectAssignment",
        "id_materia": id,
        "dni": getCookie('userSystem')
      };
    await ajaxPromiseNoSerialize(data, "BORRAR_ASIGNACION_OK", true)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("BORRAR_ASIGNACION_OK", res.code);

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

function filterButton() {
    var showBtn = getCookie('userRole') == 'docente' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';


    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bnombre");
    displayBlock("bcreditos");
    displayBlock("bprofesorppal");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bcreditos");
    valueNullAndDisplayNone("bprofesorppal");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadSubjects();
}

function filtrar() {
    x.resource = originalUsers;
    filterElement(x, "nombre_materia", "bnombre");
    filterElement(x, "creditos", "bcreditos");
    filterElement(x, "dni.nombre", "bprofesorppal");
    filterElement(x, "dni.apellidos_usuario", "bprofesorppal");

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