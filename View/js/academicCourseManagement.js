var x;

async function loadAcademicCourses() {
    var lang = getCookie("lang");
    if (getCookie("userRole") == "administrador") {
        createHideForm("formAcademicCourse");
        await ajaxPromise(document.formAcademicCourse, "search", "academicCourse", "RECORDSET_DATOS", true)
            .then(async (res) => {
                loadData(res);
            })
            .catch((res) => {
               ajaxResponseKO(res.code);
               setLang(getCookie("lang"));
               document.getElementById("modal").style.display = "block";
            });

        setLang(lang);
        deleteActionController();
    }
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
        atributosFunciones = [
            "'" + row.id_curso_academico + "'",
            "'" + row.nombre_curso_academico + "'"
        ];

        celdaAccionesEliminar =
            '<div class="tooltip6"><img class="eliminar ICONO_ELIMINAR pointer" src="Resources/delete3.png" id='+atributosFunciones[0]+' onclick="showDelete(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR"></span></div>';
        celdaAccionesEditar =
            '<div class="tooltip6"><img class="editar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="showEdit(' +
            atributosFunciones +
            ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT"></span></div>';
        if (getCookie('userRole') == 'administrador') {
            celdaAcciones = celdaAccionesEditar + celdaAccionesEliminar;
        }else {
            celdaAcciones = "";
        }

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.nombre_curso_academico +
            "</td> <td class='text-nowrap'>" +
            celdaAcciones +
            "</td> </tr>";

         return rowTable;
    }
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'administrador' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bnombre");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bnombre");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadAcademicCourses();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "nombre_curso_academico", "bnombre");

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

function addButton() {
    var showBtn = getCookie('userRole') == 'administrador' ? '<button type="button" class="btn btn-success ANADIR_CURSO_ACADEMICO mb-3" data-toggle="modal" data-target="#curac-modal" class="tooltip"></button>' : '';

    document.getElementById("btnAdd").innerHTML += showBtn;
}

async function addAcademicCourse() {
    await ajaxPromise(document.formularioCursoAcademico, "add", "academicCourse", "ANADIR_CURSO_ACADEMICO_OK", true)
        .then((res) => {
            $("#curac-modal").modal("toggle");

            ajaxResponseOK("ANADIR_CURSO_ACADEMICO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#curac-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "nombreCA"
            ];
            resetForm("formularioCursoAcademico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDelete(id_curso_academico, nombre) {
    $('#myModalDel').modal('show');
    document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteAcademicCourse(id_curso_academico);
    });
}

async function deleteAcademicCourse(id_curso_academico) {
    data = {
        "action": "delete",
        "controller": "academicCourse",
        "id_curso_academico": id_curso_academico
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_CURSO_ACADEMICO_OK", true)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_CURSO_ACADEMICO_OK", res.code);

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

function showEdit(id, nombre) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + nombre;
    var lang = getCookie("lang");
    editStructure();
    changeForm(
        "editForm",
        "javascript:editAcademicCourse("+id+");",
        "return checkEditAcademicCourse();"
    );
    changeOnBlurFields(
         "return checkName('input_nombre_curso_academico', 'errorFormatNombreCursoAcademico', 'academicCourseName')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillForm(id, nombre);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function editStructure() {
    clearModalErrors();
    activateFieldsBlock();
    showLabels();
}

function clearModalErrors() {
    let errores = [
        "errorFormatNombreCursoAcademico"
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlock() {
    $("#input_nombre_curso_academico").attr("style", "display: block");

    enableFields([
        "input_nombre_curso_academico"
    ]);
}

function showLabels() {
    $("#label_nombre_curso_academico").attr("style", "display: block");
}

function changeOnBlurFields(
    onBlurNombre
) {
    if (onBlurNombre != "") {
        $("#input_nombre_curso_academico").attr("onblur", onBlurNombre);
    }
}

function fillForm(
    id,
    nombre
) {
    $("#input_nombre_curso_academico").val(nombre);
}

async function editAcademicCourse(id) {
    insertField(document.formularioGenerico, "id_curso_academico", id);
    await ajaxPromise(document.formularioGenerico, "edit", "academicCourse", "EDITAR_CURSO_ACADEMICO_OK", true)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_CURSO_ACADEMICO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_nombre_curso_academico"
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}