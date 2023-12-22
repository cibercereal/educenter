var x;
var mapaAgrupadoPorDni = new Map();
var deliveries = [];
var originalUsers = new Map();

async function loadProjectGrades() {
    var lang = getCookie("lang");
    var mapaAgrupadoPorDni = new Map();
    originalUsers = new Map();
    deliveries = [];
    document.getElementById("gradeProjectDetail").textContent = translateWord("CALIFICACIONES_MATERIA") + getCookie("subjectName");
    createHideForm("formStudentsProject");
    insertField(document.formStudentsProject, "id_materia", getCookie('subject'));
    await ajaxPromise(document.formStudentsProject, "search", "subjectStudent", "RECORDSET_DATOS", true)
        .then(async (res) => {
            createHideForm("formProjects");
            insertField(document.formProjects, "id_materia", getCookie('subject'));
            await ajaxPromise(document.formProjects, "search", "project", "RECORDSET_DATOS", true)
                .then(async (res2) => {
                    createHideForm("formGradeProject");
                    for (const project of res2['resource']) {
                        insertField(document.formGradeProject, "id_trabajo", project.id_trabajo);
                        await ajaxPromise(document.formGradeProject, "search", "gradeProject", "RECORDSET_DATOS", true)
                            .then(async (res3) => {
                                const showGrade = res3['resource'].find((grade) => grade.visible === 0);
                                if (showGrade) {
                                    for (const grade of res3['resource']) {
                                        deliveries.push([grade.id_entrega.id_entrega, grade.id_trabajo.id_trabajo]);
                                    }
                                    showGrades();
                                }
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
                                      nombre_trabajo: project.nombre_trabajo,
                                      id_trabajo: project.id_trabajo
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
                                      nombre_trabajo: project.nombre_trabajo,
                                      id_trabajo: project.id_trabajo
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
                                      nombre_trabajo: project.nombre_trabajo,
                                      id_trabajo: project.id_trabajo
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
    $("#datosEntidades").html("");
    if (x.size > 0) {
        if (originalUsers.size == 0) {
            var initialTr = makeInitialTr(Array.from(x.entries())[0][1]);
            $("#initialTr").html("");
            $("#initialTr").append(initialTr);
            var tr = makeHead(Array.from(x.entries())[0][1]);
            $("#cabeceras").html("");
            $("#cabeceras").append(tr);
        }
        const clavesAUsar = Array.from(x.keys()).slice(parseInt(start), parseInt(end));
        for (var i = start; i < parseInt(start) + parseInt(end); i++) {
            var tr = makeRow(x.get(clavesAUsar[i]));
            $("#datosEntidades").append(tr);
            setLang(getCookie('lang'));
        }
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
        '</div><div><input type="text" id="bdni" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>' +
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn NOMBRE_PERSONA"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(1, ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div><div><input type="text" id="bnombre" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>';
        counter = 2;
        for (const elem in row) {
            rowTable += '<th scope="col">' +
            '<div class="nombreUsuarioColumn">'+translateWord("CALIFICACION_TRABAJO") + " - " + (100 - row[elem].correccion_nota) + "%"+'</div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div><div><input type="text" id="bnotatrabajo'+row[elem].id_trabajo+'" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>' +
            '<th scope="col">' +
            '<div class="nombreUsuarioColumn">'+translateWord("CALIFICACION_CORRECCION") + " - " + row[elem].correccion_nota + "%"+'</div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(' + (counter+1) + ', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div><div><input type="text" id="bnotacorreccion'+row[elem].id_trabajo+'" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>';
            counter += 2;
        }

        rowTable += '<th scope="col">' +
            '<div class="nombreUsuarioColumn CALIFICACION_FINAL"></div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaTrabajo'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div><div><input type="text" id="bnotafinal" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>';

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

function showGrades() {
    document.getElementById("btnShowGrade").innerHTML = "";

    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success MOSTRAR_CORRECCION_ALUMNOS mb-3 mr-3" onclick="showGradesToStudents()" class="tooltip"></button>' : '';

    document.getElementById("btnShowGrade").innerHTML += showBtn;
}

async function showGradesToStudents() {
    var errors = [];
    for (const delivery of deliveries) {
            createHideForm("formShowGrades");
            insertField(document.formShowGrades, "id_trabajo", delivery[1]);
            insertField(document.formShowGrades, "id_entrega", delivery[0]);
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
    const entries = Array.from(x.entries())[0][1];
    for (const elem in entries) {
        displayBlock("bnotatrabajo"+entries[elem].id_trabajo);
        displayBlock("bnotacorreccion"+entries[elem].id_trabajo);
    }
    displayBlock("bnotafinal");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    const entries = Array.from(x.entries())[0][1];
    for (const elem in entries) {
        valueNullAndDisplayNone("bnotatrabajo"+entries[elem].id_trabajo);
        valueNullAndDisplayNone("bnotacorreccion"+entries[elem].id_trabajo);
    }
    valueNullAndDisplayNone("bnotafinal");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadProjectGrades();
}

function filtrar() {
    x = originalUsers;

    const dni = document.getElementById("bdni").value;
    if (dni !== null && dni !== "") {
        x = new Map([...x].filter(([key, value]) => {
            return value.some(item => item.dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "")));
        }));
    }

    const nombre = document.getElementById("bnombre").value;
    if (nombre != null && nombre != "") {
        x = new Map([...x].filter(([key, value]) => {
            return value.some(item => {
                const name = item.apellidos_usuario + " " + item.nombre;
                return name.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(nombre.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
            });
        }));
    }

    const notaFinal = document.getElementById("bnotafinal").value;
    if (notaFinal != null && notaFinal != "") {
        x = new Map([...x].filter(([key, value]) => {
            const totalFinalGrade = Array.from(value).reduce((sum, item) => {
                const gradeProject = item.nota_trabajo != 'NP' ? item.nota_trabajo : 0;
                const gradeCorrection = item.nota_correccion != 'NP' ? item.nota_correccion : 0;
                const projectPercent = (item.correccion_nota != 'NP' && item.correccion_nota != 0) ? (100 - item.correccion_nota) / 100 : 0;
                const correctionPercent = (item.correccion_nota != 'NP' && item.correccion_nota != 0) ? item.correccion_nota / 100 : 0;
                const finalGrade = parseFloat(((gradeProject * projectPercent) + (gradeCorrection * correctionPercent)) * (item.porcentaje_nota / 100)).toFixed(2);
                return sum + parseFloat(finalGrade);
            }, 0);

            return totalFinalGrade.toFixed(2).toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaFinal.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
        }));
    }

    const entriesArray = Array.from(x.entries());
    if (entriesArray.length > 0) {
        const entries = Array.from(x.entries())[0][1];
        for (const elem in entries) {
            const notaTrabajo = document.getElementById("bnotatrabajo" + entries[elem].id_trabajo).value;
            const notaCorreccion = document.getElementById("bnotacorreccion" + entries[elem].id_trabajo).value;

            if (notaTrabajo != null && notaTrabajo != "") {
                x = new Map([...x].filter(([key, value]) => {
                    return value.some(item => {
                        return item.nota_trabajo.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaTrabajo.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
                    });
                }));
            }

            if (notaCorreccion != null && notaCorreccion != "") {
                x = new Map([...x].filter(([key, value]) => {
                    return value.some(item => {
                        return item.nota_correccion.toString().toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(notaCorreccion.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
                    });
                }));
            }
        }
    }

    x.total = x.size;
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