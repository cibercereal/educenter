var x;
var competences;
var gradeCompetence = [];
var mapaAgrupadoPorDni = new Map();

async function loadCompetenceGradesStudent() {
    var lang = getCookie("lang");
    var mapaAgrupadoPorDni = new Map();
    var buttonNotVisible = true;
    gradeCompetence = [];
    document.getElementById("gradeCompetenceDetail").textContent = translateWord("CALIFICACIONES_COMPETENCIAS") + getCookie("subjectName");
    createHideForm("formCompetence");
    insertField(document.formCompetence, "id_materia", getCookie('subject'));
    await ajaxPromise(document.formCompetence, "search", "competence", "RECORDSET_DATOS", true)
    .then(async (comp) => {
        competences = comp['resource'];
        createHideForm("formStudentsProject");
        insertField(document.formStudentsProject, "id_materia", getCookie('subject'));
        insertField(document.formStudentsProject, "dni", getCookie('userSystem'));
        insertField(document.formStudentsProject, "aceptado", "1");
        await ajaxPromise(document.formStudentsProject, "search", "subjectStudent", "RECORDSET_DATOS", true)
            .then(async (res) => {
                createHideForm("formProjects");
                insertField(document.formProjects, "id_materia", getCookie('subject'));
                await ajaxPromise(document.formProjects, "search", "project", "RECORDSET_DATOS", true)
                    .then(async (res2) => {
                        createHideForm("formGradeCompetence");
                        insertField(document.formGradeCompetence, "id_materia", getCookie('subject'));
                        insertField(document.formGradeCompetence, "dni", getCookie('userSystem'));
                        insertField(document.formGradeCompetence, "visible", '1');
                        for (const project of res2['resource']) {
                            insertField(document.formGradeCompetence, "id_trabajo", project.id_trabajo);
                            await ajaxPromise(document.formGradeCompetence, "search", "gradeCompetence", "RECORDSET_DATOS", true)
                                .then(async (res3) => {
                                    const showGrade = res3['resource'].find((grade) => grade.visible === 0);
                                    if (showGrade && buttonNotVisible) {
                                        buttonNotVisible = false;
                                        for (const grade of res3['resource']) {
                                            gradeCompetence.push({subjectId: grade.id_materia.id_materia, projectId: grade.id_trabajo.id_trabajo, competenceId: grade.id_competencia.id_competencia, dni: grade.dni.dni});
                                        }
                                        showGrades();
                                    }
                                    for (const student of res['resource']) {
                                      const nuevoArray = [];
                                      const elems = res3['resource'].filter((gradeCompetence) => gradeCompetence.dni.dni === student.dni.dni);
                                      for (const found of elems) {
                                          nuevoElem = {
                                            dni: student.dni.dni,
                                            nombre: student.dni.nombre,
                                            apellidos_usuario: student.dni.apellidos_usuario,
                                            nombre_competencia: found.id_competencia.titulo,
                                            nota_competencia: found.nota_competencia
                                          };
                                          if (mapaAgrupadoPorDni.has(student.dni.dni)) {
                                            mapaAgrupadoPorDni.get(student.dni.dni).push(nuevoElem);
                                          } else {
                                            mapaAgrupadoPorDni.set(student.dni.dni, [nuevoElem]);
                                          }
                                      }
                                      if (elems.length == 0) {
                                        for (const competence of competences) {
                                            if (!mapaAgrupadoPorDni.has(student.dni.dni) || !mapaAgrupadoPorDni.get(student.dni.dni).flat().some(item => item.nombre_competencia === competence.titulo)) {
                                                nuevoElem = {
                                                    dni: student.dni.dni,
                                                    nombre: student.dni.nombre,
                                                    apellidos_usuario: student.dni.apellidos_usuario,
                                                    nombre_competencia: competence.titulo,
                                                    nota_competencia: 'NP'
                                                };
                                            }
                                        }
                                      }
                                    }
                                })
                                .catch((res3) => {
                                    for (const student of res['resource']) {
                                        for (const competence of competences) {
                                            if (!mapaAgrupadoPorDni.has(student.dni.dni) || !mapaAgrupadoPorDni.get(student.dni.dni).flat().some(item => item.nombre_competencia === competence.titulo)) {
                                                nuevoElem = {
                                                  dni: student.dni.dni,
                                                  nombre: student.dni.nombre,
                                                  apellidos_usuario: student.dni.apellidos_usuario,
                                                  nombre_competencia: competence.titulo,
                                                  nota_competencia: '--'
                                                };
                                                if (mapaAgrupadoPorDni.has(student.dni.dni)) {
                                                    mapaAgrupadoPorDni.get(student.dni.dni).push(nuevoElem);
                                                } else {
                                                    mapaAgrupadoPorDni.set(student.dni.dni, [nuevoElem]);
                                                }
                                            }
                                        }
                                    }
                                });
                        }
                    })
                    .catch((res2) => {
                        if (res.code != "RECORDSET_VACIO") {
                            ajaxResponseKO(res2.code);
                            setLang(getCookie("lang"));
                            document.getElementById("modal").style.display = "block";
                        }
                });
            })
            .catch((res) => {
                if (res.code != "RECORDSET_VACIO") {
                    ajaxResponseKO(res.code);
                    setLang(getCookie("lang"));
                    document.getElementById("modal").style.display = "block";
                }
        });
        })
        .catch((comp) => {
            if (comp.code != "RECORDSET_VACIO") {
                ajaxResponseKO(comp.code);
                setLang(getCookie("lang"));
                document.getElementById("modal").style.display = "block";
            }
    });
    loadData(mapaAgrupadoPorDni);
    setLang(lang);
    deleteActionController();
}

function loadData(res) {
    x = res;
    setCookie("paintPager", "si");
    adjustPager();
    if (getCookie("paintPager") == "si") {
        setCookie("totalElements", res.size);
        pager("subject");
    }
    setCookie("totalElements", res.size);
    fileTableMessage();
    searchEntities(getCookie('actualPage'));
}

function getList(start, end) {
    $("#datosEntidades").html("");
    var initialTr = makeInitialTr(Array.from(x.entries())[0][1]);
    $("#initialTr").append(initialTr);
    const clavesAUsar = Array.from(x.keys()).slice(parseInt(start), parseInt(end));
    var tr = makeHead(Array.from(x.entries())[0][1]);
    $("#cabeceras").append(tr);
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeRow(x.get(clavesAUsar[i]));
        $("#datosEntidades").append(tr);
        setLang(getCookie('lang'));
    }
}

function makeInitialTr(row) {
    var rowTable = '<th scope="col" colspan="2">' +
       '<div class="nombreUsuarioColumn ALUMNOS"></div></th>' +
       '<th scope="col" colspan="' + competences.length + '"><div class="nombreUsuarioColumn COMPETENCIA_NOTA"></div></th>';

    return rowTable;
}

function makeHead(row) {
    var rowTable =
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn DNI"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(0, ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>' +
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn NOMBRE_PERSONA"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(1, ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>';
        counter = 2;
        for (const elem in competences) {
            rowTable += '<th scope="col">' +
            '<div class="info pointer">' +
            '<span class="tooltiptext pointer"></span>' +
            '</div>' +
            '<div class="nombreUsuarioColumn">' + competences[elem].titulo + '</div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div></th>';
            counter ++;
        }

    return rowTable;
}

function makeRow(row) {
    if (row != null) {
        var rowTable = '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row[0].dni +
            "</td> <td>" +
            row[0].apellidos_usuario + ", " + row[0].nombre +
            "</td>";
        var totalGrade = 0;

        const groupByDelivery = {};
        for (const item of row) {
            const key = item['nombre_competencia'];

            if (!groupByDelivery[key]) {
                groupByDelivery[key] = {
                    items: [],
                    suma: 0,
                    elems: 0
                };
            }

            groupByDelivery[key].items.push(item);

            if (typeof item['nota_competencia'] === 'number') {
                groupByDelivery[key].suma += item['nota_competencia'];
                groupByDelivery[key].elems += 1;
            } else {
                groupByDelivery[key].elems += 1;
            }
        }

        for (const elem in groupByDelivery) {
            rowTable += "<td>" +
                (groupByDelivery[elem].items[0].nota_competencia !== '--' ? parseFloat((groupByDelivery[elem].suma * 10) / groupByDelivery[elem].elems).toFixed(2) : '-') +
                "</td>";
        }

        rowTable += "</tr>";
        return rowTable;
    }
}