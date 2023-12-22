async function getAcademicCourses() {
  var lang = getCookie("lang");
  createHideForm("formAcademicCourse", "javascript:academicCourse()");

  await ajaxPromise(document.formAcademicCourse, "search", "academicCourse", "RECORDSET_DATOS", true)
    .then((res) => {
      fillSelectAcademicCourse(res['resource'])
    })
    .catch((res) => {
      actionError(res.code);
      setLang(lang);
    });
  deleteActionController();
}


function fillSelectAcademicCourse($academicCourses) {
  var select = $("#select_id_academic_course");

  select.empty();

  var option1 = document.createElement("option");
  option1.setAttribute("value", "");
  option1.setAttribute("class", "SELECCION_CURSO_ACADEMICO");
  option1.setAttribute("selected", "true");
  select.append(option1);

  var academicCourseCookie = ",,";
  var academicCourseCookie2 = ",,";
  $academicCourses.forEach( $elem => {
    academicCourseCookie += $elem.nombre_curso_academico + ",";
    academicCourseCookie2 += $elem.id_curso_academico + ",";
  });

  var academicCourseArray = academicCourseCookie.split(",");
  var academicCourseArray2 = academicCourseCookie2.split(",");
  var option2 = document.createElement("option");
  var textOption = "";

  for (var i = 0; i < academicCourseArray.length; i++) {
    if (academicCourseArray[i] != "") {
      option2 = document.createElement("option");
      option2.setAttribute("value", academicCourseArray2[i]);
      option2.setAttribute("name", i);
      textOption = document.createTextNode(translateWord(academicCourseArray[i]));
      option2.appendChild(textOption);
      select.append(option2);
    }
  }

  setLang(getCookie("lang"));
}

function changeAcademicCourse() {
    var selectBox = document.getElementById("select_id_academic_course");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    setCookie("academicCourse", selectedValue);
    setCookie("academicCourseName", selectBox.options[selectBox.selectedIndex].text);
    window.location.href = "./subjectManagement.html";
}