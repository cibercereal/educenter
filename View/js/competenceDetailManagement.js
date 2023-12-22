var x;

async function loadCompetences() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("GESTION_COMPETENCIAS") + ": " + getCookie("subjectName");
    createHideForm("formCompetenceDetail");
    insertField(document.formCompetenceDetail, "id_materia", getCookie('subject'));
    addActionControler(document.formCompetenceDetail, "search", "competence");

    await loadCompetenceAjaxPromise()
        .then(async (res) => {
            loadData(res);
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function loadCompetenceAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: URL_REST,
                data: $("#formCompetenceDetail").serialize(),
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
        pager("competence");
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
            "'" + row.id_competencia + "'",
            "'" + row.titulo + "'",
            "'" + row.descripcion + "'",
            "'" + row.id_materia.id_materia + "'",
        ];

        celdaAcciones = '';
        if (getCookie('userRole') == 'docente') {
            celdaAccionesEliminar = '<div class="tooltip6"><img class="detalle ICONO_ELIMINAR pointer" src="Resources/delete3.png" onclick="showDelete(' +
                atributosFunciones[0] + ", " + atributosFunciones[1] +
                ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>';
            celdaAccionesModificar = '<div class="tooltip6"><img class="entregar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="showEdit(' +
                atributosFunciones +
                ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT pointer"></span></div>';

            celdaAcciones = celdaAccionesModificar + celdaAccionesEliminar;
        }

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.titulo +
            "</td> <td>" +
            row.descripcion +
            "</td>" +
            "<td class='text-nowrap'>" +
            celdaAcciones +
            "</td> </tr>";

        return rowTable;
    }
}

function showDelete(id_competencia, nombre) {
    $('#myModalDel').modal('show');
    document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteRequest(id_competencia);
    });
}

async function deleteRequest(id) {
    data = {
        "action": "delete",
        "controller": "competence",
        "id_competencia": id
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_COMPETENCIA_OK", true)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_COMPETENCIA_OK", res.code);

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

function showEdit(id_competencia, titulo, descripcion, id_materia) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + titulo;
    var lang = getCookie("lang");
    var campos = ["tituloC", "descripcionC"];
    editStructure();
    changeForm("editForm", "javascript:editCompetence("+id_competencia+","+id_materia+");", "return checkEditProject();");
    changeOnBlurFields(
        "return checkName('tituloC', 'errorFormatCompetenceTitle', 'titleCompetence')",
        "return checkDescriptionCompetence('descripcionC', 'errorFormatCompetenceDescription', 'descriptionCompetence')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillForm(titulo, descripcion);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function fillForm(titulo, descripcion) {
    $("#tituloC").val(titulo);
    $("#descripcionC").val(descripcion);
}

function editStructure() {
     clearModalErrors();
     activateFieldsBlockDetail();
     hideRequired();
}

function clearModalErrors() {
    let errores = [
        "errorFormatCompetenceTitle",
        "errorFormatCompetenceDescription",
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlockDetail() {
    if (getCookie('userRole') == 'docente') {
        $("#tituloC").attr("style", "display: block");
        $("#decripcionC").attr("style", "display: block");

        enableFields([
            "tituloC",
            "descripcionC"
        ]);
    }
}

function changeOnBlurFields(onBlurName, onBlurNotePercent, onBlurCorrectionNote, onBlurInitDate, onBlurEndDate, onBlurDescription) {
    $("#tituloC").attr("onblur", onBlurName);
    $("#descripcionC").attr("onblur", onBlurNotePercent);
}

function hideRequired() {
    $("#obligatorioTitulo").attr("style", "display: none");
    $("#obligatorioDescripcion").attr("style", "display: none");
}

function showLabels() {
    $("#label_datos").attr("style", "display: block");
    $("#label_fecha_entrega").attr("style", "display: none");
}

async function editCompetence(id_competencia, id_materia) {
    insertField(document.formularioGenerico, "id_materia", id_materia);
    insertField(document.formularioGenerico, "id_competencia", id_competencia);
    await ajaxPromise(document.formularioGenerico, "edit", "competence", "EDITAR_COMPETENCIA_OK", true)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_COMPETENCIA_OK", res.code);

            let idElementoList = [
                "tituloC",
                "descripcionC",
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "tituloC",
                "descripcionC",
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'docente' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';


    document.getElementById("btnFiltrar").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("btitulo");
    displayBlock("bdescripcion");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("btitulo");
    valueNullAndDisplayNone("bdescripcion");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadCompetences();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "titulo", "btitulo");
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