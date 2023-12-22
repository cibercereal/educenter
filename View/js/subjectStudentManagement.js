var x;
var subjectStudentData;

async function loadSubjects() {
    if (getCookie('userRole') == 'usuario') {
        var lang = getCookie("lang");
        createHideForm("formSubjectManagement");
        insertField(document.formSubjectManagement, "id_curso_academico", getCookie('academicCourse'));
        addActionControler(document.formSubjectManagement, "search", "subject");

        await loadSubjectDataAjaxPromise()
            .then((res) => {
                if (getCookie('userRole') == 'usuario') {
                    loadSubjectStudentData()
                    .then((res2) => {
                        subjectStudentData = res2['resource'];
                        elem = res['resource'];
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
                    .catch((res) => {
                        ajaxResponseKO(res.code);
                    });
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

async function loadSubjectStudentData() {
    var lang = getCookie("lang");
    createHideForm("formSubject2Management");
    insertField(document.formSubject2Management, "dni", getCookie('userSystem'));
    addActionControler(document.formSubject2Management, "search", "subjectStudent");

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
        var addRequest = true;
        for (var i = 0; i < subjectStudentData.length; i++) {
            if (subjectStudentData[i].id_materia.id_materia == row.id_materia && subjectStudentData[i].aceptado != 0 && subjectStudentData[i].aceptado != 1) {
                deleteRequest = true;
                addRequest = false;
                break;
            } else if (subjectStudentData[i].id_materia.id_materia == row.id_materia && subjectStudentData[i].aceptado == 1) {
                addRequest = false;
            }
        }

        celdaAccionesEliminar =
            deleteRequest ? '<div class="tooltip6"><img class="detalle ICONO_ELIMINAR pointer" src="Resources/delete3.png" onclick="showDelete(' +
            atributosFunciones +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>' : '';
        celdaAccionesSolicitar =
            addRequest ? '<div class="tooltip6"><img class="entregar ICONO_SOLICITAR pointer" src="Resources/delivery.png" onclick="makeRequest(' +
            atributosFunciones[0] +
            ')" alt="Solicitar"/><span class="tooltiptext ICONO_SOLICITAR pointer"></span></div>' : '';

        if (getCookie('userRole') == 'usuario') {
            celdaAcciones = celdaAccionesEliminar + celdaAccionesSolicitar;
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
            celdaAcciones +
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
    await ajaxPromise(document.formularioAnadirSolicitud, "add", "subjectStudent", "ANADIR_USUARIO_MATERIA_OK", false)
        .then((res) => {
            ajaxResponseOK("ANADIR_USUARIO_MATERIA_OK", res.code);

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

function showDelete(id_materia) {
    $('#myModalDel').modal('show');
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteRequest(id_materia);
    });
}

async function deleteRequest(id) {
    data = {
        "action": "delete",
        "controller": "subjectStudent",
        "id_materia": id,
        "dni": getCookie('userSystem')
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_USUARIO_MATERIA_OK", true)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_USUARIO_MATERIA_OK", res.code);

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
    var showBtn = getCookie('userRole') == 'usuario' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bnombre");
    displayBlock("bcreditos");
    displayBlock("bprofesor");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bcreditos");
    valueNullAndDisplayNone("bprofesor");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadSubjects();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "nombre_materia", "bnombre");
    filterElement(x, "creditos", "bcreditos");
    filterElement(x, "dni.nombre", "bprofesor");
    filterElement(x, "dni.apellidos_usuario", "bprofesor");

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