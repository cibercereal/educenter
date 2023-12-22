var x;
var subjects;

async function loadTeachers() {
    document.getElementById("projectDetail").textContent = translateWord("GESTION_PROFESORES_MATERIA") + ": " + getCookie("subjectName");
    if (getCookie('userRole') == 'administrador' || getCookie('userRole') == 'docente') {
        var lang = getCookie("lang");
        createHideForm("formTeachers");
        insertField(document.formTeachers, "id_materia", getCookie('subject'));
        addActionControler(document.formTeachers, "search", "subjectAssignment");

        await loadTeachersAjaxPromise()
            .then(async (res) => {
                await loadSubjects()
                    .then(async (res2) => {
                        subjects = res2['resource'];
                        loadData(res);
                        deleteActionController();
                    })
                    .catch((res) => {
                        ajaxResponseKO(res.code);
                    });
            })
            .catch((res) => {
                ajaxResponseKO(res.code);
            });
        setLang(lang);
        deleteActionController();
    }
}

async function loadSubjects() {
    createHideForm("subjectForm");
    insertField(document.subjectForm, "id_curso_academico", getCookie('academicCourse'));
    return ajaxPromise(document.subjectForm, "search", "subject", "RECORDSET_DATOS", true);
}

function loadTeachersAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formTeachers").serialize(),
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
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", res.total);
        pager("teacher");
    }
    setCookie("totalElements", res.total);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
}

function getList(start, end) {
    $("#datosEntidades").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = getCookie('userRole') == 'administrador' ? makeRow(x.resource[i]) : makeRowTeacher(x.resource[i]);
        $("#datosEntidades").append(tr);
        setLang(getCookie('lang'));
    }
}

function makeRow(row) {
    if (row != null) {
        atributosFunciones = [
            "'" + row.dni.dni + "'",
            "'" + row.id_materia.id_materia + "'",
        ];

        aceptarPpal = true;
        for (var i = 0; i < subjects.length; i++) {
            if (row.id_materia.id_materia == subjects[i].id_materia && subjects[i].dni != null) {
                aceptarPpal = false;
                break;
            }
        }
        rechazar = '';
        aceptar = '';
        if (row.secundario == null && aceptarPpal) {
            aceptar = '<div class="tooltip6"><img class="entregar ICONO_ACEPTAR pointer" src="Resources/delivery.png" onclick="acceptPpal(' +
                  atributosFunciones +
                  ')" alt="Aceptar"/><span class="tooltiptext ICONO_ACEPTAR pointer"></span></div>';
            rechazar = '<div class="tooltip6"><img class="detalle ICONO_NO_ACEPTAR pointer" src="Resources/delete3.png" onclick="reject(' +
                  atributosFunciones +
                  ')" alt="No aceptar"/><span class="tooltiptext ICONO_NO_ACEPTAR pointer"></span></div>';
        }
        celdaAccionesStudent = aceptar + rechazar;
        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.dni.dni +
            "</td> <td>" +
            row.dni.nombre +
            "</td> <td>" +
            row.dni.apellidos_usuario +
            "</td>" +
            "<td class='text-nowrap'>" +
            celdaAccionesStudent +
            "</td> </tr>";
        return rowTable;
    }
}

function makeRowTeacher(row) {
    if (row != null) {
        atributosFunciones = [
            "'" + row.dni.dni + "'",
            "'" + row.id_materia.id_materia + "'",
        ];

        aceptarPpal = true;
        for (var i = 0; i < subjects.length; i++) {
            if (row.id_materia.id_materia == subjects[i].id_materia && subjects[i].dni != null) {
                aceptarPpal = false;
                break;
            }
        }
        rechazar = '';
        aceptar = '';
        if (row.secundario == null && !aceptarPpal) {
            aceptar = '<div class="tooltip6"><img class="entregar ICONO_ACEPTAR pointer" src="Resources/delivery.png" onclick="accept(' +
                  atributosFunciones +
                  ')" alt="Aceptar"/><span class="tooltiptext ICONO_ACEPTAR pointer"></span></div>';
            rechazar = '<div class="tooltip6"><img class="detalle ICONO_NO_ACEPTAR pointer" src="Resources/delete3.png" onclick="reject(' +
                  atributosFunciones +
                  ')" alt="No aceptar"/><span class="tooltiptext ICONO_NO_ACEPTAR pointer"></span></div>';
        } else if (row.secundario == 1) {
            rechazar = '<div class="tooltip6"><img class="detalle ICONO_NO_ACEPTAR pointer" src="Resources/delete3.png" onclick="reject(' +
                  atributosFunciones +
                  ')" alt="No aceptar"/><span class="tooltiptext ICONO_NO_ACEPTAR pointer"></span></div>';
        } else if (row.secundario == 0) {
            aceptar = '<div class="tooltip6"><img class="entregar ICONO_ACEPTAR pointer" src="Resources/delivery.png" onclick="accept(' +
                  atributosFunciones +
                  ')" alt="Aceptar"/><span class="tooltiptext ICONO_ACEPTAR pointer"></span></div>';
        }
        celdaAccionesStudent = aceptar + rechazar;
        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.dni.dni +
            "</td> <td>" +
            row.dni.nombre +
            "</td> <td>" +
            row.dni.apellidos_usuario +
            "</td>" +
            "<td class='text-nowrap'>" +
            celdaAccionesStudent +
            "</td> </tr>";
        return rowTable;
    }
}

async function acceptPpal(dni, id_materia) {
    createHideForm("formularioAnadirProfesor");
    insertField(document.formularioAnadirProfesor, "id_materia", id_materia);
    insertField(document.formularioAnadirProfesor, "dni", dni);
    await ajaxPromise(document.formularioAnadirProfesor, "assignTeacher", "subject", "ASIGNAR_PROFESOR_OK", false)
        .then((res) => {
            ajaxResponseOK("ASIGNAR_PROFESOR_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
        deleteActionController();
}

async function accept(dni, id_materia) {
    createHideForm("formularioAnadirProfesor");
    insertField(document.formularioAnadirProfesor, "id_materia", id_materia);
    insertField(document.formularioAnadirProfesor, "dni", dni);
    insertField(document.formularioAnadirProfesor, "secundario", 1);
    await ajaxPromise(document.formularioAnadirProfesor, "edit", "subjectAssignment", "EDITAR_ASIGNACION_OK", false)
        .then((res) => {
            ajaxResponseOK("EDITAR_ASIGNACION_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
        deleteActionController();
}

async function reject(dni, id_materia) {
    createHideForm("formularioAnadirProfesor");
    insertField(document.formularioAnadirProfesor, "id_materia", id_materia);
    insertField(document.formularioAnadirProfesor, "dni", dni);
    insertField(document.formularioAnadirProfesor, "secundario", 0);
    await ajaxPromise(document.formularioAnadirProfesor, "edit", "subjectAssignment", "EDITAR_ASIGNACION_OK", true)
        .then((res) => {
            ajaxResponseOK("EDITAR_ASIGNACION_OK", res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
        deleteActionController();
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

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bapellidos");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadTeachers();
}

function filtrar() {
    x.resource = originalUsers;
    filterElement(x, "dni.dni", "bdni");
    filterElement(x, "dni.nombre", "bnombre");
    filterElement(x, "dni.apellidos_usuario", "bapellidos");


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