var x;

async function loadCriteria() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("DETALLE_CRITERIOS") + ": " + getCookie("projectName");
    createHideForm("formCriteria");
    insertField(document.formCriteria, "id_trabajo", getCookie('project'));
    addActionControler(document.formCriteria, "search", "criteria");

    await loadCriteriaAjaxPromise()
        .then(async (res) => {
            loadData(res);
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function loadCriteriaAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formCriteria").serialize(),
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
        pager("criteria");
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
            "'" + row.id_criterio + "'",
            "'" + row.descripcion + "'",
            "'" + row.id_trabajo.id_trabajo + "'",
        ];
        celdaAccionesDetalle = '';
        celdaAccionesEliminar = '';
        celdaAccionesEditar = '';
        if (getCookie('userRole') == 'docente') {
            celdaAccionesDetalle =
                '<div class="tooltip6"><img class="detalle ICONO_DETALLE pointer" src="Resources/detail3.png" onclick="showDetail(' +
                atributosFunciones +
                ')" alt="Detalle"/><span class="tooltiptext ICONO_DETALLE pointer"></span></div>';
            celdaAccionesEliminar =
                '<div class="tooltip6"><img class="eliminar ICONO_ELIMINAR pointer" src="Resources/delete3.png" id='+atributosFunciones[0]+' onclick="showDelete(' +
                atributosFunciones[0] + ", " + atributosFunciones[1] +
                ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>';
            celdaAccionesEditar =
                '<div class="tooltip6"><img class="editar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="showEdit(' +
                atributosFunciones +
                ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT pointer"></span></div>';
        }

        celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar + celdaAccionesEliminar;
        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.descripcion +
            "</td>" +
            "<td class='text-nowrap'>" +
            celdaAcciones +
            "</td> </tr>";
        return rowTable;
    }
}

function showEdit(id_criterio, descripcion, id_trabajo) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + descripcion;
    var lang = getCookie("lang");
    var campos = ["input_descripcion_criterio"];
    editProjectStructure();
    changeForm("editForm", "javascript:editCriteria("+id_criterio+","+id_trabajo+");", "return checkEditCriteria();");
    changeOnBlurProjectFields(
        "return checkDescriptionCriteria('input_descripcion_criterio', 'errorFormatDescripcionCriterio', 'correctionDescriptionCriteria')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillForm(descripcion);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function changeOnBlurProjectFields(onBlurDescription) {
    $("#input_descripcion_criterio").attr("onblur", onBlurDescription);
}

function editProjectStructure() {
     clearModalErrors();
     activateFieldsBlockDetail();
     hideRequired();
     showLabelsDetail();
}

function activateFieldsBlockDetail() {
    $("#input_descripcion_criterio").attr("style", "display: block");
}

function addButton() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success ANADIR_CRITERIO mb-3 mr-3" data-toggle="modal" data-target="#criteria-modal" class="tooltip"></button>' : '';

    document.getElementById("btnAdd").innerHTML += showBtn;
}

function assignButton() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-warning ASIGNAR_CRITERIO mb-3 mr-3" data-toggle="modal" class="tooltip" onclick="assignCompetence()"></button>' : '';

    document.getElementById("btnAssign").innerHTML += showBtn;
}

function assignCompetence() {
    window.location.href = "./assignCompetenceCriteria.html";
}

function showDetail(id_criterio, descripcion, id_trabajo) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_VER") + " " + descripcion;
    var idioma = getCookie("lang");
    var campos = ["input_descripcion_criterio"];
    seeInDetailStructure();
    changeForm("detailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(descripcion);
    disableFields(campos);
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

function fillForm(descripcion) {
    $("#input_descripcion_criterio").val(descripcion);
}

function seeInDetailStructure() {
     clearModalErrors();
     activateFieldsBlockDetail();
     hideRequired();
     showLabelsDetail();
}

function clearModalErrors() {
    let errores = [
        "input_descripcion_criterio",
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlockDetail() {
    $("#input_descripcion_criterio").attr("style", "display: block");

    enableFields([
        "input_descripcion_criterio"
    ]);
}

function hideRequired() {
    $("#obligatorio_datos").attr("style", "display: none");
}

function showLabelsDetail() {
    $("#label_descripcion_criterio").attr("style", "display: block");
}

function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}

async function addCriteria() {
    insertField(document.formularioAnadirCriterio, "id_trabajo", getCookie("project"));
    await ajaxPromise(document.formularioAnadirCriterio, "add", "criteria", "ANADIR_CRITERIO_OK", true)
        .then((res) => {
            $("#criteria-modal").modal("toggle");
            ajaxResponseOK("ANADIR_CRITERIA_OK", res.code);

            let idElementoList = [
                "descripcionC",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAnadirCriterio", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#criteria-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "descripcionC",
            ];
            cleanForm(idElementoList);
            resetForm("formularioAnadirCriterio", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDelete(id_criterio, nombre) {
    $('#myModalDel').modal('show');
        document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
        document.getElementById("btnDelete").addEventListener('click', () => {
        deleteCriteria(id_criterio);
    });
}

async function deleteCriteria(id) {
    data = {
        "action": "delete",
        "controller": "criteria",
        "id_criterio": id
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_CRITERIO_OK", true)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_CRITERIO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
            loadCriteria();
        })
        .catch((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

async function editCriteria(id_criterio, id_trabajo) {
    insertField(document.formularioGenerico, "id_criterio", id_criterio);
    insertField(document.formularioGenerico, "id_trabajo", id_trabajo);
    await ajaxPromise(document.formularioGenerico, "edit", "criteria", "EDITAR_CRITERIO_OK", false)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_CRITERIO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_descripcion_criterio"
            ];
            resetForm("formularioGenerico", idElementoList);
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

    displayBlock("bdescripcion");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdescripcion");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadCriteria();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "descripcion", "bdescripcion");

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