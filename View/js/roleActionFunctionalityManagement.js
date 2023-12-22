var x;

async function loadRoleActionFunctionalityData() {
    var lang = getCookie("lang");
    createHideForm("formRoleActionFunctionalityManagement");
    addActionControler(document.formRoleActionFunctionalityManagement, "search", "roleActionFunctionality");
    
    insertField(document.formRoleActionFunctionalityManagement, "empieza", 0);
    insertField(document.formRoleActionFunctionalityManagement, "filaspagina", 25);

    if (getCookie("userRole") != "administrador") {
        insertField(
            document.formRoleActionFunctionalityManagement,
            "user",
            getCookie("userSystem")
        );
    }
    await ajaxPromise(document.formRoleActionFunctionalityManagement, "search", "roleActionFunctionality", "RECORDSET_DATOS", false)
        .then((res) => {
            x = res;
            setCookie("paintPager", "si");
            adjustPager();
            if (getCookie("paintPager") == "si") {
                setCookie("totalElements", res.total.actionFunctionality);
                pager("roleActionFunctionality");
            }
            setCookie("totalElements", res.total.actionFunctionality);
            fileTableMessage();
            $("#roleData").html("");
            $("#roleData").append('<th scope="col"></th>');
            for (var i = 0;i < res.resource.roles.length; i++) {
                var tr = makeHead(res.resource.roles[i], i);
                $("#roleData").append(tr);
            }
            searchEntities(getCookie('actualPage'));
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
    deleteActionController();
}

async function loadSelectionRoleActionFunct($roleId, $actionId, $functionalityId, $checkId) {
    var checked = document.getElementById($checkId).checked;
    var lang = getCookie("lang");
    data = {
        "action": "add",
        "controller": "roleActionFunctionality",
        "checked": checked,
        "id_rol": $roleId,
        "id_accion": $actionId,
        "id_funcionalidad": $functionalityId
    };
    await ajaxPromiseNoSerialize(data, "RECORDSET_DATOS", true)
        .then((res) => {
            // Do nothing.
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
    setLang(lang);
}

function makeBody(actionFunc, row, roles) {
    var checks;
    for (var i = 0; i < roles.length; i++) {
        var $id = "" + roles[i].id_rol + actionFunc.id_accion.id_accion + actionFunc.id_funcionalidad.id_funcionalidad + i + "";
        checks += "<td><input class='form-check-input' type='checkbox' value='' id='"+ $id +"' " + checkRoleActionFunct(row, roles[i].id_rol, actionFunc.id_accion.id_accion, actionFunc.id_funcionalidad.id_funcionalidad) +" onclick='loadSelectionRoleActionFunct("+ roles[i].id_rol + ", " + actionFunc.id_accion.id_accion + ", " + actionFunc.id_funcionalidad.id_funcionalidad + "," + $id + ")'><label class='form-check-label' for='flexCheckDefault'></td>";
    }
    var rowTable =
        '<tr class="impar" id="datoEntidad">' +
        "<td class='row" +
        actionFunc.id_accion.nombre_accion + actionFunc.id_funcionalidad.nombre_funcionalidad +
        "'></td>" + 
        checks + 
        "</tr>";

    return rowTable;
}

function checkRoleActionFunct(roleActionFunct, roleId, actionId, functionalityId) {
    
    for (var i = 0; i < roleActionFunct.length; i++) {
        if (roleActionFunct[i].id_rol.id_rol == roleId && roleActionFunct[i].id_accion.id_accion == actionId && roleActionFunct[i].id_funcionalidad.id_funcionalidad == functionalityId) {
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
        '<div class="' + row.nombre_rol + '"></div>' +
        '<div name="btnOrdenar" value="Ordenar" onclick="sortTable('+ $i +',"tablaRolAccionFuncionalidad")" class="tooltip7"' + 
        '<img class="iconoOrdenar pointer" src="Resources/ordenacion.png" alt="Ordenar" /> <span class="tooltiptext ORDENAR"></span>'+
        '</div></th>';

    return rowTable;
}

function getList(start, end) {
    $("#actionFunctionalityData").html("");
    for (var i = start; i < parseInt(start) + parseInt(end); i++) {
        var tr = makeBody(x.resource.actionFunctionality[i], x.resource.roleActionFunctionality, x.resource.roles);
        $("#actionFunctionalityData").append(tr);
        setLang(getCookie('lang'));
    }
}