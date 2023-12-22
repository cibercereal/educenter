<?php

include_once './Validation/validate.php';

function validate_data_subjectStudent() {
    include_once './Validation/Attribute/entityValidation/subjectStudentAttValidation.php';

    $subjectStudentAttValidation = new subjectStudentAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('id_materia', 'dni');
            makeList($attributeList, $subjectStudentAttValidation);
            $subjectStudentAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_materia', 'dni', 'aceptado');
            makeList($attributeList, $subjectStudentAttValidation);
            $subjectStudentAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_materia', 'dni');
            makeList($attributeList, $subjectStudentAttValidation);
            $subjectStudentAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('id_materia', 'dni', 'aceptado');
            makeList($attributeList, $subjectStudentAttValidation);
            $subjectStudentAttValidation->validateSearchAttributes();
        break;
    }
}
?>