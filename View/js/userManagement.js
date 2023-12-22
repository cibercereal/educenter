var x;

function loadUserDataAjaxPromise() {
    var lang = getCookie("lang");
    var token = getCookie("token");

    if (token == null) {
        authenticationError("ACCESO_DENEGADO", lang);
    } else {
        return new Promise(function (resolve, reject) {
            $.ajax({
                method: "POST",
                url: "../Backend/index.php",
                data: $("#formUserManagement").serialize(),
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


async function loadUserData() {
    var lang = getCookie("lang");
    createHideForm("formUserManagement");
    addActionControler(document.formUserManagement, "search", "user");
    if (getCookie("userRole") != "administrador") {
        insertField(
            document.formUserManagement,
            "user",
            getCookie("userSystem")
        );
    }
    await loadUserDataAjaxPromise()
        .then((res) => {
            if (getCookie("userRole") == "usuario") {
                elem = [];
                for (var i = 0; i < res['resource'].length; i++) {
                    if (res['resource'][i]['dni'] == getCookie('userSystem')) {
                        elem.push(res['resource'][i]);
                    }
                }
                res['total'] = elem.length;
                res['filas'] = elem.length;
                res['empieza'] = res['empieza'];
                res['resource'] = elem;
            }
            x = res;
            setCookie("paintPager", "si");
            adjustPager();
            if (getCookie("paintPager") == "si") {
                setCookie("totalElements", res.total);
                pager("user");
            }
            setCookie("totalElements", res.total);
            fileTableMessage();
            searchEntities(getCookie('actualPage'));
        })
        .catch((res) => {
            ajaxResponseKO(res.code);
        });
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
        atributosFunciones = [
            "'" + row.dni + "'",
            "'" + row.nombre + "'",
            "'" + row.apellidos_usuario + "'",
            "'" + row.fecha_nac + "'",
            "'" + row.direccion + "'",
            "'" + row.telefono + "'",
            "'" + row.email + "'",
            "'" + row.id_rol.nombre_rol + "'",
            "'" + row.password + "'",
            "'" + row.id_rol.id_rol + "'"
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
            atributosFunciones[0] +
            ')" alt="Eliminar"/><span class="tooltiptext ICONO_ELIMINAR pointer"></span></div>';
        if (getCookie('userRole') == 'administrador') {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar + celdaAccionesEliminar;
        } else if ((getCookie('userRole') == 'docente' || getCookie('userRole') == 'usuario') && row.dni == getCookie('userSystem')) {
            celdaAcciones = celdaAccionesDetalle + celdaAccionesEditar;
        } else if (getCookie('userRole') == 'docente' && (row.id_rol.nombre_rol == 'usuario' || row.id_rol.nombre_rol == 'docente')) {
            celdaAcciones = celdaAccionesDetalle;
        } else {
            celdaAcciones = '';
        }
        var rowTable =
            '<tr class="impar" id="datoEntidad">' +
            "</td> <td>" +
            row.dni +
            "</td> <td>" +
            row.nombre +
            "</td> <td>" +
            row.apellidos_usuario +
            "</td> <td>" +
            row.id_rol.nombre_rol +
            "</td> <td class='text-nowrap'>" +
            celdaAcciones +
        "</td> </tr>";

        return rowTable;
    }
}

async function addUser() {
    await ajaxPromise(document.formularioRegistro, "add", "user", "ANADIR_USUARIO_OK", false)
        .then((res) => {
            $("#registro-modal").modal("toggle");

            ajaxResponseOK("ANADIR_USUARIO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#registro-modal").modal("toggle");
            ajaxResponseKO(res.code);

            let idElementoList = [
                "dniP",
                "nombreP",
                "apellidosP",
                "fechaNacP",
                "direccionP",
                "telefonoP",
                "emailP",
                "passwdUsuario1",
                "passwdUsuario2",
            ];
            resetForm("formularioRegistro", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function addButton() {
    var showBtn = getCookie('userRole') == 'administrador' ? '<button type="button" class="btn btn-success ANADIR_USUARIO mb-3" data-toggle="modal" data-target="#registro-modal" class="tooltip"></button>' : '';

    showBtn += getCookie('userRole') == 'administrador' || getCookie('userRole') == 'docente' ? ' <button id="btnFilterShow" type="button" class="btn btn-dark FILTRAR mb-3" onclick="showFilters()" class="tooltip"></button>' +
        ' <button id="btnFilterClose" type="button" class="btn btn-dark CERRAR_FILTRADO mb-3" onclick="closeFilters()" class="tooltip" style="display:none"></button>' : '';


    document.getElementById("btnAdd").innerHTML += showBtn;

}

async function deleteUser(dni) {
    data = {
        "action": "delete",
        "controller": "user",
        "dni": dni
      };
    await ajaxPromiseNoSerialize(data, "ELIMINAR_USUARIO_OK", false)
        .then((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseOK("ELIMINAR_USUARIO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $('#myModalDel').modal('hide');
            ajaxResponseKO(res.code);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showDelete(dni) {
    $('#myModalDel').modal('show');
    document.getElementById("deleteMsg").textContent = translateWord("CONFIRMAR_ELIMINAR") + " " + dni + "?";
    document.getElementById("btnDelete").addEventListener('click', () => {
        deleteUser(dni);
    });
}

/*Función para mostrar modal para ver en detalle e invoca a la función
 * que carga como corresponda los label, input y campo obligatorio.*/
function showDetail(
    dni,
    nombre,
    apellidos,
    fecha_nac,
    direccion,
    telefono,
    email,
    rol,
    password,
    id_rol
) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_VER") + " " + dni;
    var idioma = getCookie("lang");
    var campos = [
        "input_dni_usuario",
        "input_nombre_usuario",
        "input_apellidos_usuario",
        "input_rol_usuario",
        "input_usuario_usuario",
        "input_fechaNacimiento_usuario",
        "input_direccion_usuario",
        "input_telefono_usuario",
        "input_email_usuario",
        "input_usuario_borrado_logico",
    ];
    seeInDetailStructure();
    changeForm("detailForm", "javascript:closeEntityModal();", "");
    changeIcon("Resources/close2.png", "CERRARMODAL", "iconoCerrar white-icon", "Ok");
    fillForm(
        dni,
        nombre,
        apellidos,
        fecha_nac,
        direccion,
        telefono,
        email,
        rol,
        password,
        id_rol
    );
    disableFields(campos);
    $("#formularioAcciones").modal("show");
    setLang(idioma);
}

/**Función para dar una estructura a la ventana modal de ver en detalle.*/
function seeInDetailStructure() {
    clearModalErrors();
    activateFieldsBlock();
    hideRequired();
    showLabels();
    hideHelp();
    deleteOnblurPass();

    $("#passwdUsuario1").attr("style", "display: none");
    $("#passwdUsuario2").attr("style", "display: none");
    $("#label_usuario_borrado_logico").attr("style", "display: none");
    $("#input_usuario_borrado_logico").attr("style", "display: none");
    $("#select_borrado_logico").attr("style", "display: none");
    $("#select_id_rol").attr("style", "display: none");
}

function clearModalErrors() {
    let errores = [
        "errorFormatoDni",
        "errorFormatoNombre",
        "errorFormatoApellidos",
        "errorFormatoFecha",
        "errorFormatoDireccion",
        "errorFormatoTelefono",
        "errorFormatoEmail",
        "errorFormatoPassRegistro",
        "errorFormatoPassRegistro2",
        "bloqueoMayusculasRegistro",
        "error"
    ];
    errores.forEach((element) => {
        deleteFieldId(element);
    });
}

function activateFieldsBlock() {
    $("#input_dni_usuario").attr("style", "display: block");
    $("#input_nombre_usuario").attr("style", "display: block");
    $("#input_apellidos_usuario").attr("style", "display: block");
    $("#input_fechaNacimiento_usuario").attr("style", "display: block");
    $("#input_direccion_usuario").attr("style", "display: block");
    $("#input_telefono_usuario").attr("style", "display: block");
    $("#input_email_usuario").attr("style", "display: block");
    $("#input_usuario_usuario").attr("style", "display: block");
    $("#input_rol_usuario").attr("style", "display: block");
    $("#input_usuario_borrado_logico").attr("style", "display: block");
    $("#passwdUsuario1").attr("style", "display: block");
    $("#passwdUsuario2").attr("style", "display: block");
    $("#select_borrado_logico").attr("style", "display: block");
    $("#select_id_rol").attr("style", "display: block");

    enableFields([
        "input_dni_usuario",
        "input_nombre_usuario",
        "input_apellidos_usuario",
        "input_fechaNacimiento_usuario",
        "input_direccion_usuario",
        "input_telefono_usuario",
        "input_email_usuario",
        "input_usuario_usuario",
        "input_rol_usuario",
        "input_usuario_borrado_logico",
        "passwdUsuario1",
        "passwdUsuario2",
        "select_borrado_logico",
        "select_id_rol",
    ]);
}

function hideRequired() {
    $("#obligatorio_usuario_dni").attr("style", "display: none");
    $("#obligatorio_usuario_nombre").attr("style", "display: none");
    $("#obligatorio_usuario_apellidos").attr("style", "display: none");
    $("#obligatorio_usuario_fechaNacimiento").attr("style", "display: none");
    $("#obligatorio_usuario_direccion").attr("style", "display: none");
    $("#obligatorio_usuario_telefono").attr("style", "display: none");
    $("#obligatorio_usuario_email").attr("style", "display: none");
    $("#obligatorio_usuario_usuario").attr("style", "display: none");
    $("#obligatorioPass1").attr("style", "display: none");
    $("#obligatorioPass2").attr("style", "display: none");
}

function showLabels() {
    $("#label_usuario_dni").attr("style", "display: block");
    $("#label_usuario_nombre").attr("style", "display: block");
    $("#label_usuario_apellidos").attr("style", "display: block");
    $("#label_usuario_fechaNacimiento").attr("style", "display: block");
    $("#label_usuario_direccion").attr("style", "display: block");
    $("#label_usuario_telefono").attr("style", "display: block");
    $("#label_usuario_email").attr("style", "display: block");
    $("#label_usuario_usuario").attr("style", "display: block");
    $("#label_usuario_rol").attr("style", "display: block");
    $("#label_usuario_borrado_logico").attr("style", "display: block");
}

function hideHelp() {
    $("#ayudaDNI").attr("style", "display: none");
    $("#ayudaTEL").attr("style", "display: none");
    $("#ayudaEMAIL").attr("style", "display: none");
}

function deleteOnblurPass() {
    $("#passwdUsuario1").attr("onblur", "");
    $("#passwdUsuario2").attr("onblur", "");
}

/**Función que rellenado los datos del formulario para realizar la petición.*/
function fillForm(
    dni,
    nombre,
    apellidos,
    fecha_nac,
    direccion,
    telefono,
    email,
    rol,
    password,
    id_rol
) {
    $("#input_dni_usuario").val(dni);
    $("#input_nombre_usuario").val(nombre);
    $("#input_apellidos_usuario").val(apellidos);
    $("#input_fechaNacimiento_usuario").val(fecha_nac);
    $("#input_direccion_usuario").val(direccion);
    $("#input_telefono_usuario").val(telefono);
    $("#input_email_usuario").val(email);
    $("#input_rol_usuario").val(rol);
    $("#input_id_rol_usuario").val(id_rol);
    //$("#input_usuario_borrado_logico").val(borrado_logico);
}

/**Función para cerrar la ventana de detalle de usuario*/
function closeEntityModal() {
    $("#formularioAcciones").modal("hide");
    closeModal("formularioAcciones", "", "");
}

/*Función para mostrar modal para editar e invoca a la función que
 * carga como corresponda los label, input y campo obligatorio.*/
function showEdit(
    dni,
    nombre,
    apellidos,
    fecha_nac,
    direccion,
    telefono,
    email,
    rol,
    password,
    id_rol
) {
    document.getElementById("tituloModal").textContent = translateWord("TITULO_MODAL_EDITAR") + " " + dni;
    var lang = getCookie("lang");
    var fields = [
        "input_rol_usuario",
        "input_dni_usuario",
        "input_usuario_borrado_logico",
    ];
    editStructure();
    changeForm(
        "editForm",
        "javascript:editEntidad('"+dni+"');",
        "return checkEditUser();"
    );
    changeOnBlurFields(
        "return checkUserDNI('input_dni_usuario', 'errorFormatoDni', 'dniPersona')",
        "return checkName('input_nombre_usuario', 'errorFormatoNombre', 'nombrePersonaRegistro')",
        "return checkSurname('input_apellidos_usuario', 'errorFormatoApellidos', 'apellidosPersonaRegistro')",
        "return checkBirthDate('input_fechaNacimiento_usuario', 'errorFormatoFecha', 'fechaPersonaRegistro')",
        "return checkAddress('input_direccion_usuario', 'errorFormatoDireccion', 'direccionPersonaRegistro')",
        "return checkPhone('input_telefono_usuario', 'errorFormatoTelefono', 'telefonoPersonaRegistro')",
        "return checkEmail('input_email_usuario', 'errorFormatoEmail', 'emailPersonaRegistro')",
    );
    changeIcon("Resources/edit.png", "ICONO_EDIT", "iconoEditarRol white-icon", "Editar");
    fillForm(
        dni,
        nombre,
        apellidos,
        fecha_nac,
        direccion,
        telefono,
        email,
        rol,
        password,
        id_rol
    );
    disableFields(fields);
    $("#formularioAcciones").modal("show");
    setLang(lang);
}

/**Función para dar una estructura a la ventana modal de editar.*/
function editStructure() {
    clearModalErrors();
    activateFieldsBlock();
    hideRequired();
    showLabels();
    hideHelp();
    deleteOnblurPass();

    $("#passwdUsuario1").attr("style", "display: none");
    $("#passwdUsuario2").attr("style", "display: none");
    $("#select_borrado_logico").attr("style", "display: none");
    $("#select_id_rol").attr("style", "display: none");
    $("#label_usuario_borrado_logico").attr("style", "display: none");
    $("#input_usuario_borrado_logico").attr("style", "display: none");
}

/* Función para cambiar onBlur de los campos.El objetivo es añadir onBlur en los input.*/
function changeOnBlurFields(
    onBlurDni,
    onBlurNombre,
    onBlurApellidos,
    onBlurFechaNaciemiento,
    onBlurDireccion,
    onBlurTelefono,
    onBlurEmail,
    onBlurPassword1,
    onBlurPassword2
) {
    if (onBlurDni != "") {
        $("#input_dni_usuario").attr("onblur", onBlurDni);
    }

    if (onBlurNombre != "") {
        $("#input_nombre_usuario").attr("onblur", onBlurNombre);
    }

    if (onBlurApellidos != "") {
        $("#input_apellidos_usuario").attr("onblur", onBlurApellidos);
    }

    if (onBlurFechaNaciemiento != "") {
        $("#input_fechaNacimiento_usuario").attr("onblur", onBlurFechaNaciemiento);
    }

    if (onBlurDireccion != "") {
        $("#input_direccion_usuario").attr("onblur", onBlurDireccion);
    }

    if (onBlurTelefono != "") {
        $("#input_telefono_usuario").attr("onblur", onBlurTelefono);
    }

    if (onBlurEmail != "") {
        $("#input_email_usuario").attr("onblur", onBlurEmail);
    }

    if (onBlurPassword1 != "") {
        $("#passwdUsuario1").attr("onblur", onBlurPassword1);
    }

    if (onBlurPassword2 != "") {
        $("#passwdUsuario2").attr("onblur", onBlurPassword2);
    }
}

async function editEntidad(dni) {
    insertField(document.formularioGenerico, "dni", dni);
    await ajaxPromise(document.formularioGenerico, "edit", "user", "EDITAR_USUARIO_OK", true)
        .then((res) => {
            $("#formularioAcciones").modal("toggle");

            ajaxResponseOK("EDITAR_USUARIO_OK", res.code);

            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        })
        .catch((res) => {
            $("#formularioAcciones").modal("toggle");
            ajaxResponseKO(res.code);
            let idElementoList = [
                "input_rol_usuario",
                "input_dni_usuario",
                "input_nombre_usuario",
                "input_apellidos_usuario",
                "input_fechaNacimiento_usuario",
                "input_direccion_usuario",
                "input_telefono_usuario",
                "input_email_usuario",
                "input_usuario_borrado_logico",
                "passwdUsuario1",
                "passwdUsuario2",
            ];
        
            resetForm("formularioGenerico", idElementoList);
            setLang(getCookie("lang"));
            document.getElementById("modal").style.display = "block";
        });
}

function showFilters() {
    originalUsers = x.resource;

    displayBlock("bdni");
    displayBlock("bnombre");
    displayBlock("bapellidos");
    displayBlock("brol");

    $('#btnFilterShow').css('display', 'none');
    $('#btnFilterClose').css('display', 'inline-block');
}


function closeFilters() {
    originalUsers = null;

    valueNullAndDisplayNone("bdni");
    valueNullAndDisplayNone("bnombre");
    valueNullAndDisplayNone("bapellidos");
    valueNullAndDisplayNone("brol");

    $('#btnFilterShow').css('display', 'inline-block');
    $('#btnFilterClose').css('display', 'none');

    loadUserData();
}

function filtrar() {
    x.resource = originalUsers;

    filterElement(x, "dni", "bdni");
    filterElement(x, "nombre", "bnombre");
    filterElement(x, "apellidos_usuario", "bapellidos");
    filterElement(x, "id_rol.nombre_rol", "brol");

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