var x;

async function loadProjectGrade() {
    var lang = getCookie("lang");
    document.getElementById("gradeProjectDetail").textContent = translateWord("CALIFICACIONES") + getCookie("projectName");
    document.getElementById("notaTrabajo").textContent = translateWord("CALIFICACION_TRABAJO");
    document.getElementById("notaCorreccion").textContent = translateWord("CALIFICACION_CORRECCION");

    createHideForm("formGradeProject");
    insertField(document.formGradeProject, "id_trabajo", getCookie('project'));
    insertField(document.formGradeProject, "dni", getCookie('userSystem'));
    insertField(document.formGradeProject, "visible", "1");
    await ajaxPromise(document.formGradeProject, "search", "gradeProject", "RECORDSET_DATOS", true)
        .then(async (res) => {
            createHideForm("formProject");
            insertField(document.formProject, "id_trabajo", getCookie('project'));
            await ajaxPromise(document.formProject, "search", "project", "RECORDSET_DATOS", true)
                .then((res2) => {
                    document.getElementById("notaTrabajo").textContent = translateWord("CALIFICACION_TRABAJO") + " - " + (100 - res2['resource'][0].correccion_nota) + "%";
                    document.getElementById("notaCorreccion").textContent = translateWord("CALIFICACION_CORRECCION") + " - " + res2['resource'][0].correccion_nota + "%";
                    const nuevoArray = [];
                    nuevoArray.push({
                        nota_trabajo: res['resource'][0].nota_trabajo,
                        nota_correccion: res['resource'][0].nota_correccion,
                        porcentaje_nota: res2['resource'][0].porcentaje_nota,
                        correccion_nota: res2['resource'][0].correccion_nota
                    });
                    loadData(nuevoArray);
                })
                .catch((res2) => {

                });
        })
        .catch((res) => {
            const nuevoArray = [];
            nuevoArray.push({
                nota_trabajo: "-",
                nota_correccion: "-",
                porcentaje_nota: "-",
                correccion_nota: "-"
            });
            loadData(nuevoArray);
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
        gradeProject = row.nota_trabajo != '-' ? row.nota_trabajo : "-";
        gradeCorrection = row.nota_correccion != '-' ? row.nota_correccion : "-";
        projectPercent = (row.correccion_nota != '-' && row.correccion_nota != 0) ? (100 - row.correccion_nota) / 100 : 0;
        correctionPercent = (row.correccion_nota != '-' && row.correccion_nota != 0) ? row.correccion_nota / 100 : 0;
        finalGradeCalc = parseFloat((gradeProject * projectPercent) + (gradeCorrection * correctionPercent)).toFixed(2);
        finalGrade = !isNaN(finalGradeCalc) ? finalGradeCalc : '-';

        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.nota_trabajo +
            "</td> <td>" +
            row.nota_correccion +
            "<td class='text-nowrap'>" +
            (finalGrade != 0 && finalGrade != '-' ? finalGrade + " → (" + gradeProject + " * " + projectPercent + ") + (" + gradeCorrection + " * " + correctionPercent + ")" : finalGrade) +
            "</td> </tr>";

        return rowTable;
    }
}