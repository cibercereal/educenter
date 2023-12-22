var competences;
var criteria;
var x;
var criteriaCompetence = [];

async function loadCompetenceCriteria() {
    var lang = getCookie("lang");
    document.getElementById("projectDetail").textContent = translateWord("GESTION_COMPETENCIA_CRITERIO") + ": " + getCookie("projectName");
    createHideForm("formCompetence");
    insertField(document.formCompetence, "id_materia", getCookie('subject'));

    await ajaxPromise(document.formCompetence, "search", "competence", "RECORDSET_DATOS", true)
        .then(async (res) => {
            competences = res['resource'];
            createHideForm("formCriteria");
            insertField(document.formCriteria, "id_trabajo", getCookie('project'));
            await ajaxPromise(document.formCriteria, "search", "criteria", "RECORDSET_DATOS", true)
                .then(async (res2) => {
                    x = res2;
                    createHideForm("formCriteriaCompetence");
                    insertField(document.formCriteriaCompetence, "id_trabajo", getCookie('project'));
                    insertField(document.formCriteriaCompetence, "id_materia", getCookie('subject'));
                    await ajaxPromise(document.formCriteria, "search", "criteriaCompetence", "RECORDSET_DATOS", true)
                      .then(async (res3) => {
                         criteriaCompetence = res3['resource'];
                      })
                      .catch((res3)=> {
                        ajaxResponseKO(res2.code);
                      });
                   criteria = res2['resource'];
                   $("#competenceData").html("");
                   $("#competenceData").append('<th scope="col"></th>');
                   for (var i = 0;i < competences.length; i++) {
                       var tr = makeHead(competences[i], i);
                       $("#competenceData").append(tr);
                   }
                   loadData(res2);
                })
                .catch((res2) => {
                    ajaxResponseKO(res2.code);
                });
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

function makeHead(row, $i) {
    var rowTable =
        '<th scope="col">' +
        '<div class="nombreUsuarioColumn">' + row.titulo + '</div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTable('+ $i +',"tablaCompetenciaCriterio")" class="tooltip7">' +
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>';

    return rowTable;
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
    $("#criteriaData").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeRow(x.resource[i]);
        $("#criteriaData").append(tr);
        setLang(getCookie('lang'));
    }
}

function makeRow(row) {

    var checks;
    for (var i = 0; i < competences.length; i++) {
        var $id = "" + row.id_criterio + competences[i].id_competencia + "";
        var checked = "";
        for (var j = 0; j < criteriaCompetence.length; j++) {
          var objeto = criteriaCompetence[j];

          // Verificar si los valores coinciden en el objeto actual
          if (objeto.id_criterio.id_criterio === row.id_criterio && objeto.id_competencia.id_competencia === competences[i].id_competencia) {
            checked = "checked";
            break; // Salir del bucle si se encuentra una coincidencia
          }
        }
        checks += "<td><input class='form-check-input' type='checkbox' value='' id='"+ $id +"' onclick='addOrDelete("+ row.id_criterio + ", " + competences[i].id_competencia +")'"+ checked +"><label class='form-check-label' for='flexCheckDefault'></td>";
    }

    var rowTable =
        '<tr class="" id="datoEntidad">' +
        "<td class='fixed-column'>" +
        row.descripcion +
        "</td>" +
        checks +
        "</tr>";

    return rowTable;
}

async function addOrDelete(id_criterio, id_competencia) {
    var $id = "" + id_criterio + id_competencia + "";
    var checked = document.getElementById($id).checked;
    var action = checked ? "add" : "delete";
    var msg = checked ? "ANADIR_CRITERIO_COMPETENCIA_OK" : "ELIMINAR_CRITERIO_COMPETENCIA_OK";

    data = {
        "action": action,
        "controller": "criteriaCompetence",
        "id_criterio": id_criterio,
        "id_competencia": id_competencia
    };
    await ajaxPromiseNoSerialize(data, msg, true)
        .then((res) => {
            // Do nothing.
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(getCookie("lang"));
}
