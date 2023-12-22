var x;

async function loadActionFunctionalityData() {
    var lang = getCookie("lang");
    createHideForm("formActionFunctionalityManagement");
    addActionControler(document.formActionFunctionalityManagement, "search", "actionFunctionality");
    if (getCookie("userRole") != "administrador") {
        insertField(
            document.formActionFunctionalityManagement,
            "user",
            getCookie("userSystem")
        );
    }
    await ajaxPromise(document.formActionFunctionalityManagement, "search", "actionFunctionality", "RECORDSET_DATOS", false)
        .then((res) => {
            x = res;
            setCookie("paintPager", "si");
            adjustPager();
            if (getCookie("paintPager") == "si") {
                setCookie("totalElements", res.total.functionalities);
                pager("actionFunctionality");
            }
            setCookie("totalElements", res.total.functionalities);
            fileTableMessage();
            $("#actionData").html("");
            $("#actionData").append('<th scope="col"></th>');
            for (var i = 0;i < res.resource.actions.length; i++) {
                var tr = makeHead(res.resource.actions[i], i);
                $("#actionData").append(tr);
            }
            searchEntities(getCookie('actualPage'));
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

async function loadSelectionActionFunct($idAction, $idFunctionality, $checkId) {
    var checked = document.getElementById($checkId).checked;
    var lang = getCookie("lang");

    data = {
        "action": "add",
        "controller": "actionFunctionality",
        "checked": checked,
        "id_accion": $idAction,
        "id_funcionalidad": $idFunctionality
    };
    await ajaxPromiseNoSerialize(data, "RECORDSET_DATOS", true)
        .then((res) => {
            
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
}

function makeBody(row, actions, actionFunct) {
    atributosFunciones = [
        "'" + row.nombre_funcionalidad + "'"
    ];

    var checks;
    for (var i = 0; i < actions.length; i++) {
        checks += "<td><input class='form-check-input' type='checkbox' value='' id='"+ actions[i].id_accion + row.id_funcionalidad + i +"' " + checkActionFunct(actionFunct, actions[i].id_accion, row.id_funcionalidad) +" onclick='loadSelectionActionFunct("+ actions[i].id_accion + ", " + row.id_funcionalidad + "," + actions[i].id_accion + row.id_funcionalidad + i +")'><label class='form-check-label' for='flexCheckDefault'></td>";
    }

    var rowTable =
        '<tr class="impar" id="datoEntidad">' +
        "<td class='row" +
        row.nombre_funcionalidad +
        "'></td>" + 
        checks + 
        "</tr>";

    return rowTable;
}

function checkActionFunct(actionFunct, idAction, idFunctionality) {
    for (var i = 0; i < actionFunct.length; i++) {
        if (actionFunct[i].id_accion.id_accion == idAction && actionFunct[i].id_funcionalidad.id_funcionalidad == idFunctionality) {
            return "checked";
        }
    }

    return "";
}

function makeHead(row, $i) {
    atributosFunciones = [
        "'" + row.nombre_accion + "'"
    ];

    var rowTable =
        '<th scope="col">' +
        '<div class="' + row.nombre_accion + '"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTable('+ $i +',"tablaAccionFuncionalidad")" class="tooltip7"' + 
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>';

    return rowTable;
}

function getList(start, end) {
    $("#roleData").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeBody(x.resource.functionalities[i], x.resource.actions, x.resource.actionFunctionality);
        $("#roleData").append(tr);
        setLang(getCookie('lang'));
    }
}