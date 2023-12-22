var x;
var mapaAgrupadoPorDni = new Map();
var deliveries = [];

async function loadProjectGrades() {
    var lang = getCookie("lang");
    var mapaAgrupadoPorDni = new Map();
    deliveries = [];
    document.getElementById("gradeProjectDetail").textContent = translateWord("CALIFICACIONES_MATERIA") + getCookie("subjectName");
    createHideForm("formStudentsProject");
    insertField(document.formStudentsProject, "id_materia", getCookie('subject'));
    insertField(document.formStudentsProject, "dni", getCookie('userSystem'));
    await ajaxPromise(document.formStudentsProject, "search", "subjectStudent", "RECORDSET_DATOS", true)
        .then(async (res) => {
            createHideForm("formProjects");
            insertField(document.formProjects, "id_materia", getCookie('subject'));
            await ajaxPromise(document.formProjects, "search", "project", "RECORDSET_DATOS", true)
                .then(async (res2) => {
                    createHideForm("formGradeProject");
                    for (const project of res2['resource']) {
                        insertField(document.formGradeProject, "id_trabajo", project.id_trabajo);
                        insertField(document.formGradeProject, "visible", "1");
                        insertField(document.formGradeProject, "dni", getCookie('userSystem'));
                        await ajaxPromise(document.formGradeProject, "search", "gradeProject", "RECORDSET_DATOS", true)
                            .then(async (res3) => {
                                for (const student of res['resource']) {
                                  const nuevoArray = [];
                                  const found = res3['resource'].find((grade) => grade.dni.dni === student.dni.dni);
                                  if (found) {
                                    nuevoElem = {
                                      dni: student.dni.dni,
                                      nombre: student.dni.nombre,
                                      apellidos_usuario: student.dni.apellidos_usuario,
                                      nota_trabajo: found.nota_trabajo,
                                      nota_correccion: found.nota_correccion,
                                      porcentaje_nota: project.porcentaje_nota,
                                      correccion_nota: project.correccion_nota,
                                      nombre_trabajo: project.nombre_trabajo
                                    };
                                  } else {
                                    nuevoElem = {
                                      dni: student.dni.dni,
                                      nombre: student.dni.nombre,
                                      apellidos_usuario: student.dni.apellidos_usuario,
                                      nota_trabajo: 'NP',
                                      nota_correccion: 'NP',
                                      porcentaje_nota: project.porcentaje_nota,
                                      correccion_nota: project.correccion_nota,
                                      nombre_trabajo: project.nombre_trabajo
                                    };
                                  }
                                  if (mapaAgrupadoPorDni.has(student.dni.dni)) {
                                    mapaAgrupadoPorDni.get(student.dni.dni).push(nuevoElem);
                                  } else {
                                    mapaAgrupadoPorDni.set(student.dni.dni, [nuevoElem]);
                                  }
                                }
                            })
                            .catch((res3) => {
                                for (const student of res['resource']) {
                                    nuevoElem = {
                                      dni: student.dni.dni,
                                      nombre: student.dni.nombre,
                                      apellidos_usuario: student.dni.apellidos_usuario,
                                      nota_trabajo: 'NP',
                                      nota_correccion: 'NP',
                                      porcentaje_nota: project.porcentaje_nota,
                                      correccion_nota: project.correccion_nota,
                                      nombre_trabajo: project.nombre_trabajo
                                    };

                                    if (mapaAgrupadoPorDni.has(student.dni.dni)) {
                                        mapaAgrupadoPorDni.get(student.dni.dni).push(nuevoElem);
                                    } else {
                                        mapaAgrupadoPorDni.set(student.dni.dni, [nuevoElem]);
                                    }
                                }
                        });
                    }
                })
                .catch((res2) => {
                    if (res.code != "RECORDSET_VACIO") {
                        ajaxResponseKO(res.code);

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
    $("#initialTr").html("");
    $("#cabeceras").html("");
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
       '<div class="nombreUsuarioColumn ALUMNOS"></div></th>';

    for (const elem in row) {
        rowTable += '<th scope="col" colspan="2">' +
            '<div class="nombreUsuarioColumn">' + row[elem].nombre_trabajo + " - " + row[elem].porcentaje_nota + "%" + '</div></th>';
    }

    rowTable += '<th scope="col">' +
        '<div class="nombreUsuarioColumn RESULTADOS"></div></th>';

    return rowTable;
}

function makeHead(row) {
    var rowTable =
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn DNI"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(0, ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>' +
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn NOMBRE_PERSONA"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(1, ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>';
        counter = 2;
        for (const elem in row) {
            rowTable += '<th scope="col">' +
            '<div class="nombreUsuarioColumn">'+translateWord("CALIFICACION_TRABAJO") + " - " + (100 - row[elem].correccion_nota) + "%"+'</div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div></th>' +
            '<th scope="col">' +
            '<div class="nombreUsuarioColumn">'+translateWord("CALIFICACION_CORRECCION") + " - " + row[elem].correccion_nota + "%"+'</div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(' + (counter+1) + ', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div></th>';
            counter += 2;
        }

        rowTable += '<th scope="col">' +
            '<div class="nombreUsuarioColumn CALIFICACION_FINAL"></div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div></th>';

    return rowTable;
}

function makeRow(row) {
    if (row != null) {
        calc = [];
        var rowTable = '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row[0].dni +
            "</td> <td>" +
            row[0].apellidos_usuario + " " + row[0].nombre +
            "</td>";
        var totalGrade = 0;

        for (const elem in row) {
            gradeProject = row[elem].nota_trabajo != 'NP' ? row[elem].nota_trabajo : 0;
            gradeCorrection = row[elem].nota_correccion != 'NP' ? row[elem].nota_correccion : 0;
            projectPercent = (row[elem].correccion_nota != 'NP' && row[elem].correccion_nota != 0) ? (100 - row[elem].correccion_nota) / 100 : 0;
            correctionPercent = (row[elem].correccion_nota != 'NP' && row[elem].correccion_nota != 0) ? row[elem].correccion_nota / 100 : 0;

            rowTable += "<td>" +
                row[elem].nota_trabajo +
                "</td> <td>" +
                row[elem].nota_correccion +
                "</td>";
            totalGrade += parseFloat(((gradeProject * projectPercent) + (gradeCorrection * correctionPercent)) * (row[elem].porcentaje_nota / 100));
            calc.push("((" + gradeProject + " * " + projectPercent + ") + (" + gradeCorrection + " * " + correctionPercent + ")" + ") * " + (row[elem].porcentaje_nota / 100));
        }
        operation = "";
        for (const index in calc) {
            if (index != (calc.length - 1)) {
                operation += calc[index] + " + ";
            } else {
                operation += calc[index];
            }
        }

        rowTable += "<td class='text-nowrap'>" +
        (totalGrade != 0 ? totalGrade.toFixed(2) + " → " + operation: totalGrade.toFixed(2)) +
        "</td> </tr>";

        return rowTable;
    }
}