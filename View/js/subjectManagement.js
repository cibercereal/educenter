var x;
var allTeachers;

async function loadSubjectData() {
    var lang = getCookie("lang");
    createHideForm("formSubjectManagement");
    insertField(document.formSubjectManagement, "id_curso_academico", getCookie('academicCourse'));
    if (getCookie('userRole') == 'docente') {
        insertField(document.formSubjectManagement, "dni", getCookie('userSystem'));
    }
    addActionControler(document.formSubjectManagement, "search", "subject");

    await loadSubjectDataAjaxPromise()
        .then((res) => {
            if (getCookie('userRole') == 'usuario') {
                loadSubjectStudentData()
                .then((res2) => {
                    elem = [];
                    for (var i = 0; i < res2['resource'].length; i++) {
                        teacher = [];
                        for (var j = 0; j < allTeachers.length; j++) {
                            if(allTeachers[j].dni == res2['resource'][i]['id_materia']['dni']) {
                                teacher = allTeachers[j];
                                break;
                            }
                        }
                        res2['resource'][i]['id_materia']['dni'] = teacher;
                        elem.push(res2['resource'][i]['id_materia']);
                    }
                    res2['resource'] = elem;
                    loadData(res2);
                })
                .catch((res) => {
                    ajaxResponseKO(res.code);
                });
            } else if(getCookie('userRole') == 'docente') {
                loadSubjectSecondaryTeacherData()
                    .then((res2) => {
                        res2['total'] = res['total'] + res2['total'];
                        res2['filas'] = res['filas'] + res2['filas'];
                        res2['empieza'] = res['empieza'] + res2['empieza'];
                        elem = [];
                        for (var i = 0; i < res2['resource'].length; i++) {
                            for (var j = 0; j < allTeachers.length; j++) {
                                if(allTeachers[j].dni == res2['resource'][i]['id_materia']['dni']) {
                                    teacher = allTeachers[j];
                                    break;
                                }
                            }
                            res2['resource'][i]['id_materia']['dni'] = teacher;
                            elem.push(res2['resource'][i]['id_materia']);
                        }
                        res2['resource'] = res['resource'].concat(elem);
                        loadData(res2);
                    })
                    .catch((res) => {
                        ajaxResponseKO(res.code);
                    });
                } else {
                   loadData(res);
                }
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
        setCookie("totalElements", res.total);
        pager("subject");
    }
    setCookie("totalElements", res.total);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
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
                url: "../Backend/index.php",
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
    createHideForm("formSubjectManagement");
    insertField(document.formSubjectManagement, "dni", getCookie('userSystem'));
    insertField(document.formSubjectManagement, "aceptado", 1);
    addActionControler(document.formSubjectManagement, "search", "subjectStudent");

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
    setLang(lang);
    deleteActionController();
}

async function loadSubjectSecondaryTeacherData() {
    var lang = getCookie("lang");
    createHideForm("formSubjectManagement");
    if (getCookie('userRole') == 'docente') {
        insertField(document.formSubjectManagement, "dni", getCookie('userSystem'));
        insertField(document.formSubjectManagement, "secundario", "1");
    }
    addActionControler(document.formSubjectManagement, "search", "subjectAssignment");

    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: "../Backend/index.php",
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
    setLang(lang);
    deleteActionController();
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
        var profDni = row.dni != null ? row.dni.dni : '';
        atributosFunciones = [
            "'" + row.id_materia + "'",
            "'" + row.nombre_materia + "'",
            "'" + row.creditos + "'",
            "'" + profesor + "'",
            "'" + profDni + "'",
        ];

        celdaAccionesDetalle =
            '<div class="tooltip6"><img class="detalle ICONO_DETALLE pointer" src="Resources/detail3.png" onclick="showDetail(' +
            atributosFunciones +
            ')" alt="Detalle"/><span class="tooltiptext ICONO_DETALLE pointer"></span></div>';
        celdaAccionesEditar =
            '<div class="tooltip6"><img class="editar ICONO_EDIT pointer" src="Resources/edit3.png" onclick="showEdit(' +
            atributosFunciones +
            ')" alt="Editar"/><span class="tooltiptext ICONO_EDIT pointer"></span></div>';
        celdaAccionesEliminar =
            '<div class="tooltip6"><img class="eliminar ICONO_ELIMINAR pointer" src="Resources/delete3.png" id='+atributosFunciones[0]+' onclick="showDelete(' +
            atributosFunciones[0] +", "+atributosFunciones[1]+
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>';
        celdaAccionesCalcularNota =
            '<div class="tooltip6"><img class="eliminar ICONO_CALCULAR_NOTA_COMP pointer" src="Resources/calculadora.png" onclick="calculateCompetenceGrade(' +
            atributosFunciones[0] +
            ')" alt="Calcular nota competencias"/><span class="tooltiptext ICONO_CALCULAR_NOTA_COMP pointer"></span></div>';
        celdaAccionesVerNotas =
            '<div class="tooltip6"><img class="eliminar ICONO_VER_NOTA_COMP pointer" src="Resources/puntuaciones.png" onclick="showCompetenceGrades(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Ver notas competencias"/><span class="tooltiptext ICONO_VER_NOTA_COMP pointer"></span></div>';
        celdaAccionesVerNotasAlumno =
            '<div class="tooltip6"><img class="eliminar ICONO_VER_NOTA_COMP pointer" src="Resources/puntuaciones.png" onclick="showCompetenceGradesStudent(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Ver notas competencias"/><span class="tooltiptext ICONO_VER_NOTA_COMP pointer"></span></div>';
        celdaAccionesVerNotasFinalesAlumno =
            '<div class="tooltip6"><img class="eliminar ICONO_VER_NOTA_FIN pointer" src="Resources/notasFin.png" onclick="showFinalGradesStudent(' +
            atributosFunciones[0] + ", " + atributosFunciones[1] +
            ')" alt="Ver notas competencias"/><span class="tooltiptext ICONO_VER_NOTA_FIN pointer"></span></div>';

        if (getCookie('userRole') == 'administrador') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar + celdaAccionesEliminar;
        } else if (getCookie('userRole') == 'docente') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesCalcularNota + celdaAccionesVerNotas;
        } else if(getCookie('userRole') == 'usuario') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesVerNotasAlumno + celdaAccionesVerNotasFinalesAlumno;
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

function addButton() {
    var showBtn = getCookie('userRole') == 'administrador' ? '<button type="button" class="btn btn-success ANADIR_MATERIA mb-3" data-toggle="modal" data-target="#materia-modal" class="tooltip"></button>' : '';

    showBtn += getCookie('userRole') == 'administrador' || getCookie('userRole') == 'docente' || getCookie('userRole') == 'usuario' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    getTeachers();

    document.getElementById("btnAdd").innerHTML += showBtn;
}

async function getTeachers() {
  var lang = getCookie("lang");
  createHideForm("formTeachers", "javascript:teachers()");
  insertField(document.formTeachers, "id_rol", "2");

  await ajaxPromise(document.formTeachers, "search", "user", "RECORDSET_DATOS", true)
    .then((res) => {
      allTeachers = res['resource'];
      fillSelectTeachers(res['resource'])
    })
    .catch((res) => {
      actionError(res.code);
      setLang(lang);
    });
  removeField("id_rol");
  deleteActionController();
}

function fillSelectTeachers($teachers) {
  var select = $("#select_dni");

  select.empty();

  var option1 = document.createElement("option");
  option1.setAttribute("value", "");
  option1.setAttribute("class", "SELECCION_PROFESOR_PPAL");
  option1.setAttribute("selected", "true");
  select.append(option1);

  var teachersCookie = ",,";
  var teachersCookie2 = ",,";
  $teachers.forEach( $elem => {
    teachersCookie += $elem.nombre + " " + $elem.apellidos_usuario + ",";
    teachersCookie2 += $elem.dni + ",";
  });

  var teachersArray = teachersCookie.split(",");
  var teachersArray2 = teachersCookie2.split(",");
  var option2 = document.createElement("option");
  var textOption = "";

  for (var i = 0; i < teachersArray.length; i++) {
    if (teachersArray[i] != "") {
      option2 = document.createElement("option");
      option2.setAttribute("value", teachersArray2[i]);
      option2.setAttribute("name", i);
      textOption = document.createTextNode(translateWord(teachersArray[i]));
      option2.appendChild(textOption);
      select.append(option2);
    }
  }

  setLang(getCookie("lang"));
}

async function addSubject() {
    if (document.formularioAnadirMateria.dni.value == "Seleccione un profesor ppal")  {
        document.formularioAnadirMateria.dni.value = null;
    }
    await ajaxPromise(document.formularioAnadirMateria, "add", "subject", "ANADIR_MATERIA_OK", false)
        .then((res) => {
            $("#materia-modal").modal("toggle");

            ajaxResponseOK("ANADIR_MATERIA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#materia-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "nombreM",
                "creditosM",
                "select_dni"
            ];
            resetForm("formularioAnadirMateria", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDetail(id_materia,nombre_materia, creditos, profesor, dni) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_VER") + " " + nombre_materia;
    var idioma = getCookie("lang");
    if (getCookie("userRole") != "administrador") {
        document.getElementById("label_mas_info").style.display = "block";
        document.getElementById("label_mas_info").addEventListener("click", function() {
            setCookie("subjectName", nombre_materia);
            window.location.href = "./subjectDetail.html";
        });
         if (getCookie("userRole") == "docente") {
            if (getCookie("userSystem") == dni) {
                document.getElementById("label_student_info").style.display = "block";
                document.getElementById("label_student_info").addEventListener("click", function() {
                     setCookie("subjectName", nombre_materia);
                     window.location.href = "./studentDetail.html";
                });
                document.getElementById("label_teacher_info").style.display = "block";
                document.getElementById("label_teacher_info").addEventListener("click", function() {
                     setCookie("subjectName", nombre_materia);
                     window.location.href = "./teacherDetail.html";
                });
            } else {
                document.getElementById("label_teacher_info").style.display = "none";
                document.getElementById("label_student_info").style.display = "none";
            }
         } else {
            document.getElementById("label_student_info").style.display = "none";
         }
    } else {
        document.getElementById("label_mas_info").style.display = "none";
        document.getElementById("label_student_info").style.display = "none";
        document.getElementById("label_teacher_info").style.display = "block";
        document.getElementById("label_teacher_info").addEventListener("click", function() {
             setCookie("subjectName", nombre_materia);
             window.location.href = "./teacherDetail.html";
        });
    }
    var campos = [
        "input_nombre_materia",
        "input_creditos",
        "input_select_dni",
    ];
    seeInDetailStructure();
    changeForm("detailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(
        nombre_materia,
        creditos,
        profesor
    );
    disableFields(campos);
    $("#formularioAcciones").modal("show");
    setCookie("subject", id_materia);
    setLang(idioma);
}

function seeInDetailStructure() {
    clearModalErrors();
    activateFieldsBlock();
    hideRequired();
    showLabels();
}

function clearModalErrors() {
    let errores = [
        "errorFormatSubjectName1",
        "errorFormatSubjectCredits1",
        "errorFormatPpalTeacher"
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlock() {
    $("#input_nombre_materia").attr("style", "display: block");
    $("#input_creditos").attr("style", "display: block");
    $("#input_select_dni").attr("style", "display: block");

    enableFields([
        "input_nombre_materia",
        "input_creditos",
        "input_select_dni",
    ]);
}

function hideRequired() {
    $("#obligatorio_nombre_materia").attr("style", "display: none");
    $("#obligatorio_creditos").attr("style", "display: none");
    $("#obligatorio_profesor_ppal").attr("style", "display: none");
}

function showLabels() {
    $("#label_nombre_materia").attr("style", "display: block");
    $("#label_creditos").attr("style", "display: block");
    $("#label_select_dni").attr("style", "display: block");
}

function fillForm(nombre_materia, creditos, profesor) {
    $("#input_nombre_materia").val(nombre_materia);
    $("#input_creditos").val(creditos);
    var select = $("#input_select_dni");

    select.empty();

    var option1 = document.createElement("option");
    option1.setAttribute("value", "");
    option1.setAttribute("class", "");
    option1.setAttribute("selected", "true");
    select.append(option1);

    var teachersCookie = ",,";
    var teachersCookie2 = ",,";
    allTeachers.forEach( $elem => {
      teachersCookie += $elem.nombre + " " + $elem.apellidos_usuario + ",";
      teachersCookie2 += $elem.dni + ",";
    });

    var teachersArray = teachersCookie.split(",");
    var teachersArray2 = teachersCookie2.split(",");
    var option2 = document.createElement("option");
    var textOption = "";

    for (var i = 0; i < teachersArray.length; i++) {
      if (teachersArray[i] != "") {
        option2 = document.createElement("option");
        option2.setAttribute("value", teachersArray2[i]);
        option2.setAttribute("name", i);
        textOption = document.createTextNode(translateWord(teachersArray[i]));
        option2.appendChild(textOption);
        var selected = profesor == teachersArray[i] ? "true" : "false";
        if (selected == "true") {
            option2.setAttribute("selected", selected);
        }
        select.append(option2);
      }
    }
}

async function deleteSubject(id) {
    data = {
        "action": "delete",
        "controller": "subject",
        "id_materia": id
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_MATERIA_OK", false)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_MATERIA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
        console.log(res);
            $('#myModalDel').modal('hide');
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDelete(id, nombre) {
    $('#myModalDel').modal('show');
    document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + nombre + "?";
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteSubject(id);
    });
}

function showEdit(id_materia, nombre_materia, creditos, profesor) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + nombre_materia;
    var lang = getCookie("lang");
    var fields = [
        "input_select_dni",
    ];
    editStructure();
    changeForm(
        "editForm",
        "javascript:editEntity();",
        "return checkEditSubject();"
    );
    insertField(document.formularioGenerico, "id_materia", id_materia);

    changeOnBlurFields(
        "return checkName('input_nombre_materia', 'errorFormatSubjectName1', 'nameSubject')",
        "return checkCredits('input_creditos', 'errorFormatSubjectCredits1', 'creditsSubject')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillForm(
        nombre_materia,
        creditos,
        profesor
    );
    if (getCookie('userRole') != 'administrador') {
        disableFields(fields);
    }
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}

function changeOnBlurFields(
    onBlurNombre,
    onBlurCreditos
) {

    if (onBlurNombre != "") {
        $("#input_nombre_materia").attr("onblur", onBlurNombre);
    }

    if (onBlurCreditos != "") {
        $("#input_creditos").attr("onblur", onBlurCreditos);
    }
}

function editStructure() {
    clearModalErrors();
    activateFieldsBlock();
    hideRequired();
    showLabels();
}

async function editEntity() {
    await ajaxPromise(document.formularioGenerico, "edit", "subject", "EDITAR_MATERIA_OK", true)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_MATERIA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_nombre_materia",
                "input_creditos",
                "input_select_dni",
            ];

            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

async function calculateCompetenceGrade(subjectId) {
    createHideForm('gradeCompetenceForm');
    insertField(document.gradeCompetenceForm, "id_materia", subjectId);

    await ajaxPromise(document.gradeCompetenceForm, "edit", "gradeCompetence", "EDITAR_NOTA_COMPETENCIA_OK", true)
        .then((res) => {
            ajaxResponseOK("EDITAR_NOTA_COMPETENCIA_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showCompetenceGrades(subjectId, subjectName) {
    setCookie("subject", subjectId);
    setCookie("subjectName", subjectName);
    window.location.href = "./showCompetencesGrades.html";
}

function showCompetenceGradesStudent(subjectId, subjectName) {
    setCookie("subject", subjectId);
    setCookie("subjectName", subjectName);
    window.location.href = "./showCompetencesGradesStudent.html";
}

function showFinalGradesStudent(subjectId, subjectName) {
    setCookie("subject", subjectId);
    setCookie("subjectName", subjectName);
    window.location.href = "./showFinalGradesStudent.html";
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

    loadSubjectData();
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