<?php

include_once './Validation/validate.php';

function validate_data_subjectAssignment() {
    include_once './Validation/Attribute/entityValidation/subjectAssignmentAttValidation.php';

    $subjectAssignmentAttValidation = new subjectAssignmentAttValidation();

    switch(action) {
        case 'search':
            $attributeList = array('id_materia', 'dni', 'secundario');
            makeList($attributeList, $subjectAssignmentAttValidation);
            $subjectAssignmentAttValidation->validateSearchAttributes();
        break;
        case 'add':
            $attributeList = array('id_materia', 'dni');
            makeList($attributeList, $subjectAssignmentAttValidation);
            $subjectAssignmentAttValidation->validateAdd();
        break;
        case 'delete':
            $attributeList = array('id_materia', 'dni');
            makeList($attributeList, $subjectAssignmentAttValidation);
            $subjectAssignmentAttValidation->validateDelete();
        break;
        case 'edit':
            $attributeList = array('id_materia', 'dni', 'secundario');
            makeList($attributeList, $subjectAssignmentAttValidation);
            $subjectAssignmentAttValidation->validateEdit();
        break;
    }
}
?>