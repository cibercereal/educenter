<?php

include_once './Validation/validate.php';

function validate_data_subject() {
    include_once './Validation/Attribute/entityValidation/subjectAttValidation.php';

    $subjectAttValidation = new subjectAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('nombre_materia', 'creditos', 'dni');
            makeList($attributeList, $subjectAttValidation);
            $subjectAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_materia', 'nombre_materia', 'creditos', 'dni');
            makeList($attributeList, $subjectAttValidation);
            $subjectAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_materia');
            makeList($attributeList, $subjectAttValidation);
            $subjectAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('nombre_materia', 'creditos', 'dni', 'id_curso_academico');
            makeList($attributeList, $subjectAttValidation);
            $subjectAttValidation->validateSearchAttributes();
        break;
        case 'assignTeacher':
            $attributeList = array('id_materia', 'dni');
            makeList($attributeList, $subjectAttValidation);
            $subjectAttValidation->validateAssignTeacherAttributes();
        break;
    }
}
?>