var x;
var competences;
var gradeCompetence = [];
var mapaAgrupadoPorDni = new Map();
var originalUsers = new Map();

async function loadCompetenceGrades() {
    var lang = getCookie("lang");
    var mapaAgrupadoPorDni = new Map();
    originalUsers = new Map();
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
        insertField(document.formStudentsProject, "aceptado", "1");
        await ajaxPromise(document.formStudentsProject, "search", "subjectStudent", "RECORDSET_DATOS", true)
            .then(async (res) => {
                createHideForm("formProjects");
                insertField(document.formProjects, "id_materia", getCookie('subject'));
                await ajaxPromise(document.formProjects, "search", "project", "RECORDSET_DATOS", true)
                    .then(async (res2) => {
                        createHideForm("formGradeCompetence");
                            insertField(document.formGradeCompetence, "id_materia", getCookie('subject'));
                        for (const project of res2['resource']) {
                            insertField(document.formGradeCompetence, "id_trabajo", project.id_trabajo);
                            await ajaxPromise(document.formGradeCompetence, "search", "gradeCompetence", "RECORDSET_DATOS", true)
                                .then(async (res3) => {
                                    const showGrade = res3['resource'].find((grade) => grade.visible === 0);
                                    if (showGrade && buttonNotVisible) {
                                        buttonNotVisible = false;
                                        for (const grade of res3['resource']) {
                                            gradeCompetence.push({subjectId: grade.id_materia.id_materia, projectId: grade.id_trabajo.id_trabajo, competenceId: grade.id_competencia.id_competencia, dni: grade.dni.dni, criteriaId: grade.id_criterio.id_criterio});
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
                                                  nota_competencia: 'NP'
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
    if (row != null) {
        var rowTable = '<th scope="col" colspan="2">' +
           '<div class="nombreUsuarioColumn ALUMNOS"></div></th>' +
           '<th scope="col" colspan="' + competences.length + '"><div class="nombreUsuarioColumn COMPETENCIA_NOTA"></div></th>';

        return rowTable;
    }
}

function makeHead(row) {
    if (row != null) {
        var rowTable =
            '<th scope="col">' +
            '<div class="nombreUsuarioColumn DNI"></div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(0, ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div><div><input type="text" id="bdni" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>' +
            '<th scope="col">' +
            '<div class="nombreUsuarioColumn NOMBRE_PERSONA"></div>' +
            '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex(1, ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
            '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
            '</div><div><input type="text" id="bnombre" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>';

            counter = 2;
            for (const elem in competences) {
                rowTable += '<th scope="col">' +
                '<div class="info pointer">' +
                '<span class="tooltiptext pointer"></span>' +
                '</div>' +
                '<div class="nombreUsuarioColumn">' + competences[elem].titulo + '</div>' +
                '<div name="btnOrdenar" value="Ordenar" onclick="sortTableFromIndex('+ counter +', ' + "'tablaNotaCompetencia'" + ', 0)" class="tooltip7">' +
                '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
                '</div><div><input type="text" id="btitulo'+competences[elem].id_competencia+'" class="mt-1 form-control" style="display:none" onkeyup="filtrar()"></div></th>';
                counter ++;
            }

        return rowTable;
    }
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
                parseFloat((groupByDelivery[elem].suma * 10) / groupByDelivery[elem].elems).toFixed(2) +
                "</td>";
        }

        rowTable += "</tr>";
        return rowTable;
    }
}

function showGrades() {
    document.getElementById("btnShowGrade").innerHTML = "";

    var showBtn = getCookie('userRole') == 'docente' ? '<button type="button" class="btn btn-success MOSTRAR_NOTAS_COMPETENCIAS_ALUMNOS mb-3 mr-3" onclick="showGradesToStudents()" class="tooltip"></button>' : '';

    document.getElementById("btnShowGrade").innerHTML += showBtn;
}

async function showGradesToStudents() {
    var errors = [];
    for (const gradeComp of gradeCompetence) {
            createHideForm("formShowGrades");
            insertField(document.formShowGrades, "id_materia", gradeComp.subjectId);
            insertField(document.formShowGrades, "id_trabajo", gradeComp.projectId);
            insertField(document.formShowGrades, "id_competencia", gradeComp.competenceId);
            insertField(document.formShowGrades, "dni", gradeComp.dni);
            insertField(document.formShowGrades, "id_criterio", gradeComp.criteriaId);
            insertField(document.formShowGrades, "visible", '1');
            await ajaxPromise(document.formShowGrades, "makeVisible", "gradeCompetence", "PUBLICAR_NOTA_COMPETENCIA_OK", true)
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
    for (const elem in competences) {
        displayBlock("btitulo"+competences[elem].id_competencia);
    }

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}

function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    for (const elem in competences) {
        valueNullAndDisplayNone("btitulo"+competences[elem].id_competencia);
    }

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadCompetenceGrades();
}

function filtrar() {
    x = originalUsers;

    const dni = document.getElementById("bdni").value;
    if (dni !== null && dni !== "") {
        x = new Map([...x].filter(([key, value]) => {
            return value.some(item => item.dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(dni.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "")));
        }));
    }

    nombre = document.getElementById("bnombre").value;
    if (nombre != null && nombre != "") {
        x = new Map([...x].filter(([key, value]) => {
            return value.some(item => {
                const name = item.apellidos_usuario + ", " + item.nombre;
                return name.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, "").includes(nombre.toLowerCase().normalize("NFD").replace(/\p{Diacritic}/gu, ""));
            });
        }));
    }

    const clavesAUsar = Array.from(x.keys()).slice(0, x.size);
    var l = [];
    for (var i = 0; i < x.size; i++) {
        const groupByDelivery = {};
        for (const item of x.get(clavesAUsar[i])) {
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
            l.push({
                dni: groupByDelivery[elem].items[0].dni,
                competencia: groupByDelivery[elem].items[0].nombre_competencia,
                nota: parseFloat((groupByDelivery[elem].suma * 10) / groupByDelivery[elem].elems).toFixed(2)
            });
        }
    }

    const mapaAgrupado = l.reduce((mapa, elemento) => {
      const { dni, competencia, nota } = elemento;

      if (!mapa.has(dni)) {
        mapa.set(dni, []);
      }

      mapa.get(dni).push({ competencia, nota });

      return mapa;
    }, new Map());

    for (const competencia of competences) {
        const tituloCompetencia = document.getElementById("btitulo" + competencia.id_competencia).value;

        if (tituloCompetencia != null && tituloCompetencia !== "") {
            x = new Map([...x].filter(([key, value]) => {
                return value.some(item => {
                    const competenciaNota = mapaAgrupado.get(item.dni).find(comp => comp.competencia === competencia.titulo);
                    if (competenciaNota) {
                        const nota = competenciaNota.nota;
                        return nota.toString().includes(tituloCompetencia);
                    }
                    return false;
                });
            }));
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