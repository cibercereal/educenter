var x;

async function loadStudents() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("GESTION_ALUMNOS_MATERIAS") + ": " + getCookie("subjectName");
    createHideForm("formStudents");
    insertField(document.formStudents, "id_materia", getCookie('subject'));
    insertField(document.formStudents, "aceptado", "");
    addActionControler(document.formStudents, "search", "subjectStudent");

    await loadStudentsAjaxPromise()
        .then(async (res) => {
            loadData(res);
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function loadStudentsAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formStudents").serialize(),
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
        pager("student");
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
        atributosFunciones = [
            "'" + row.dni.dni + "'",
            "'" + row.id_materia.id_materia + "'",
        ];

        aceptar = '';
        rechazar = '';
        if (row.aceptado == null) {
            aceptar = '<div class="tooltip6"><img class="entregar ICONO_ACEPTAR pointer" src="Resources/delivery.png" onclick="accept(' +
                  atributosFunciones +
                  ')" alt="Aceptar"/><span class="tooltiptext ICONO_ACEPTAR pointer"></span></div>';
            rechazar = '<div class="tooltip6"><img class="detalle ICONO_NO_ACEPTAR pointer" src="Resources/delete3.png" onclick="reject(' +
                  atributosFunciones +
                  ')" alt="No aceptar"/><span class="tooltiptext ICONO_NO_ACEPTAR pointer"></span></div>';
        } else if (row.aceptado == 1) {
            rechazar = '<div class="tooltip6"><img class="detalle ICONO_NO_ACEPTAR pointer" src="Resources/delete3.png" onclick="reject(' +
                  atributosFunciones +
                  ')" alt="No aceptar"/><span class="tooltiptext ICONO_NO_ACEPTAR pointer"></span></div>';
        } else if (row.aceptado == 0) {
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

async function accept(dni, id_materia) {
    createHideForm("formularioAnadirAlumno");
    insertField(document.formularioAnadirAlumno, "id_materia", id_materia);
    insertField(document.formularioAnadirAlumno, "dni", dni);
    insertField(document.formularioAnadirAlumno, "aceptado", 1);
    await ajaxPromise(document.formularioAnadirAlumno, "edit", "subjectStudent", "EDITAR_USUARIO_MATERIA_OK", false)
        .then((res) => {
            ajaxResponseOK("EDITAR_USUARIO_MATERIA_OK", res.code);

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
    createHideForm("formularioAnadirAlumno");
    insertField(document.formularioAnadirAlumno, "id_materia", id_materia);
    insertField(document.formularioAnadirAlumno, "dni", dni);
    insertField(document.formularioAnadirAlumno, "aceptado", 0);
    await ajaxPromise(document.formularioAnadirAlumno, "edit", "subjectStudent", "EDITAR_USUARIO_MATERIA_OK", false)
        .then((res) => {
            ajaxResponseOK("EDITAR_USUARIO_MATERIA_OK", res.code);

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

    loadStudents();
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