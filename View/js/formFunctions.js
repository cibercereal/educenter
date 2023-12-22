/**Function that adds to the generic form the action and controller tags.*/
function addActionControler(form, action, controller) {
    var act = "";

    switch (action) {
      case "login":
        act = "login";
        break;
      case "register":
        act = "register";
        break;
      case "search":
        act = "search";
        break;
      case "searchBy":
        act = "searchBy";
      break;
      case "add":
        act = "add";
      break;
      case "edit":
        act = "edit";
      break;
      case "getPasswordEmail":
        act = "getPasswordEmail";
      break;
      case "editPass":
        act = "editPass";
      break;
      case "assignTeacher":
        act = "assignTeacher";
      break;
      case "assignCompetence":
        act = "assignCompetence";
      break;
      case "assignRandom":
        act = "assignRandom";
      break;
      case "editTeacher":
        act = "editTeacher";
      break;
      case "showCorrection":
        act = "showCorrection";
      break;
      case "makeVisible":
        act = "makeVisible";
      break;
    }

    //(form, name, value)
    insertField(form, "action", act);
    insertField(form, "controller", controller);
}

/**Function to insert fields in the form.*/
function insertField(form, name, value) {
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    input.className = name;
    form.appendChild(input);
}

function createHideForm(name, action) {
  if ($("#" + name).length == 0) {
    var formu = document.createElement("form");
    document.body.appendChild(formu);
    formu.name = name;
    formu.action = action;
    formu.id = name;
    formu.style.display = "none";
  }
}

/**Function to reset the form values.*/
function resetForm(formId, elementListId) {
    document.getElementById(formId).reset();
    //Devuelve el color por defecto.
    elementListId.forEach(function (elementId) {
      document.getElementById(elementId).style.borderColor = "#c8c8c8";
    });
}

/**Function that remove of the form the action and the controller.*/
function deleteActionController() {
    removeField("action");
    removeField("controller");
}

/**Function to remove fields of the form.*/
function removeField(name) {
    $("." + name).remove();
}

/**Función para eliminar campos del formulario*/
function deleteFieldId(idElementoError) {
  document.getElementById(idElementoError).style.display = "none";
}

/**Función para crear un formulario oculto sin accion*/
function createHideFormNoAction(name) {
  if ($("#" + name).length == 0) {
    var formu = document.createElement("form");
    document.body.appendChild(formu);
    formu.name = name;
    formu.id = name;
    formu.style.display = "none";
  }
}
