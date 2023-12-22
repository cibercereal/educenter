var x;
var deliveries = [];

async function loadProjectGradeData() {
    var lang = getCookie("lang");
    deliveries = [];
    document.getElementById("gradeProjectDetail").textContent = translateWord("CALIFICACIONES") + getCookie("projectName");
    document.getElementById("notaTrabajo").textContent = translateWord("CALIFICACION_TRABAJO");
    document.getElementById("notaCorreccion").textContent = translateWord("CALIFICACION_CORRECCION");
    createHideForm("formStudentsProject");
    insertField(document.formStudentsProject, "id_materia", getCookie('subject'));
    await ajaxPromise(document.formStudentsProject, "search", "subjectStudent", "RECORDSET_DATOS", true)
        .then(async (res) => {
            createHideForm("formGradeProject");
            insertField(document.formGradeProject, "id_trabajo", getCookie('project'));
            await ajaxPromise(document.formGradeProject, "search", "gradeProject", "RECORDSET_DATOS", true)
                .then((res2) => {
                    document.getElementById("notaTrabajo").textContent = translateWord("CALIFICACION_TRABAJO") + " - " + (100 - res2['resource'][0].id_trabajo.correccion_nota) + "%";
                    document.getElementById("notaCorreccion").textContent = translateWord("CALIFICACION_CORRECCION") + " - " + res2['resource'][0].id_trabajo.correccion_nota + "%";
                    const showGrade = res2['resource'].find((grade) => grade.visible === 0);
                    if (showGrade) {
                        for (const grade of res2['resource']) {
                            deliveries.push(grade.id_entrega.id_entrega);
                        }
                        showGrades();
                    }
                    const nuevoArray = [];
                    for (const student of res['resource']) {
                      const found = res2['resource'].find((grade) => grade.dni.dni === student.dni.dni);
                      if (found) {
                        nuevoArray.push({
                          dni: student.dni.dni,
                          nombre: student.dni.nombre,
                          apellidos_usuario: student.dni.apellidos_usuario,
                          nota_trabajo: found.nota_trabajo,
                          nota_correccion: found.nota_correccion,
                          porcentaje_nota: found.id_trabajo.porcentaje_nota,
                          correccion_nota: found.id_trabajo.correccion_nota
                        });
                      } else {
                        nuevoArray.push({
                          dni: student.dni.dni,
                          nombre: student.dni.nombre,
                          apellidos_usuario: student.dni.apellidos_usuario,
                          nota_trabajo: 'NP',
                          nota_correccion: 'NP',
                          porcentaje_nota: '',
                          correccion_nota: ''
                        });
                      }
                    }
                    loadData(nuevoArray);
                })
                .catch((res2) => {
                    const nuevoArray = [];
                    for (const student of res['resource']) {
                        nuevoArray.push({
                          dni: student.dni.dni,
                          nombre: student.dni.nombre,
                          apellidos_usuario: student.dni.apellidos_usuario,
                          nota_trabajo: 'NP',
                          nota_correccion: 'NP',
                          porcentaje_nota: '',
                          correccion_nota: ''
                        });
                    }
                    loadData(nuevoArray);
            });
        })
        .catch((res) => {
            if (res.code != "RECORDSET_VACIO") {
                ajaxResponseKO(res.code);

                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
            }
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
        pager("subject");
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
        gradeProject = row.nota_trabajo != 'NP' ? row.nota_trabajo : 0;
        gradeCorrection = row.nota_correccion != 'NP' ? row.nota_correccion : 0;
        projectPercent = (row.correccion_nota != 'NP' && row.correccion_nota != 0) ? (100 - row.correccion_nota) / 100 : 0;
        correctionPercent = (row.correccion_nota != 'NP' && row.correccion_nota != 0) ? row.correccion_nota / 100 : 0;
        finalGrade = parseFloat((gradeProject * projectPercent) + (gradeCorrection * correctionPercent)).toFixed(2);

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.dni +
            "</td> <td>" +
            row.apellidos_usuario + " " + row.nombre +
            "</td> <td>" +
            row.nota_trabajo +
            "</td> <td>" +
            row.nota_correccion +
            "<td class='text-nowrap'>" +
            (finalGrade != 0 ? finalGrade + " → (" + gradeProject + " * " + projectPercent + ") + (" + gradeCorrection + " * " + correctionPercent + ")" : finalGrade) +
        "</td> </tr>";

        return rowTable;
    }
}

function showGrades() {
    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success MOSTRAR_CORRECCION_ALUMNOS mb-3 mr-3" onclick="showGradesToStudents()" class="tooltip"></button>' : '';

    document.getElementById("btnShowGrade").innerHTML += showBtn;
}

async function showGradesToStudents() {
    var errors = [];
    for (const delivery of deliveries) {
            createHideForm("formShowGrades");
            insertField(document.formShowGrades, "id_trabajo", getCookie('project'));
            insertField(document.formShowGrades, "id_entrega", delivery);
            insertField(document.formShowGrades, "visible", '1');
            await ajaxPromise(document.formShowGrades, "edit", "gradeProject", "EDITAR_CALCULAR_NOTA_OK", true)
                .then(async (res) => {

                })
            .catch((res) => {
                errors.push(res.code);
            });
    }

    if (errors.length > 0) {
        ajaxResponseKO("MENSAJE_ERROR_INTERNO");
        setLang(getCookie("lang"));
        document.getElementById("modal").style.display = "block";
    } else {
        ajaxResponseOK("MOSTRAR_NOTA_ALUMNO_OK");
        setLang(getCookie("lang"));
        document.getElementById("modal").style.display = "block";
    }
}

function filterButton() {
    var showBtn = getCookie('userRole') == 'docente' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';

    document.getElementById("btnFilter").innerHTML += showBtn;
}

function showFilters() {
    originalUsers = x;

    displayBlock("bdni");
    displayBlock("bnombre");
    displayBlock("bnotatrabajo");
    displayBlock("bnotacorreccion");
    displayBlock("bnotafinal");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bnotatrabajo");
    valueNullAndDisplayNone("bnotacorreccion");
    valueNullAndDisplayNone("bnotafinal");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadProjectGradeData();
}

function filtrar() {
    x = originalUsers;

    dni = document.getElementById("bdni").value;
    if (dni != null && dni != "") {
        x = x.filter(function (value) {
            return value.dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

    nombre = document.getElementById("bnombre").value;
    if (nombre != null && nombre != "") {
        x = x.filter(function (value) {
            name = value.apellidos_usuario + " " + value.nombre;
            return name.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(nombre.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

    notaTrabajo = document.getElementById("bnotatrabajo").value;
    if (notaTrabajo != null && notaTrabajo != "") {
        x = x.filter(function (value) {
            return value.nota_trabajo.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaTrabajo.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

    notaCorreccion = document.getElementById("bnotacorreccion").value;
    if (notaCorreccion != null && notaCorreccion != "") {
        x = x.filter(function (value) {
            return value.nota_correccion.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaCorreccion.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        });
    }

    notaFinal = document.getElementById("bnotafinal").value;
    if (notaFinal != null && notaFinal != "") {
        x = x.filter(function (value) {
            gradeProject = value.nota_trabajo != 'NP' ? value.nota_trabajo : 0;
            gradeCorrection = value.nota_correccion != 'NP' ? value.nota_correccion : 0;
            projectPercent = (value.correccion_nota != 'NP' && value.correccion_nota != 0) ? (100 - value.correccion_nota) / 100 : 0;
            correctionPercent = (value.correccion_nota != 'NP' && value.correccion_nota != 0) ? value.correccion_nota / 100 : 0;
            finalGrade = parseFloat((gradeProject * projectPercent) + (gradeCorrection * correctionPercent)).toFixed(2);

            return finalGrade.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaFinal.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
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