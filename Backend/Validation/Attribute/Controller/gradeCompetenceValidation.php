<?php

include_once './Validation/validate.php';

function validate_data_gradeCompetence() {
    include_once './Validation/Attribute/entityValidation/gradeCompetenceAttValidation.php';

    $gradeCompetenceAttValidation = new gradeCompetenceAttValidation();

    switch(action) {
        case 'edit':
            $attributeList = array('id_materia');
            makeList($attributeList, $gradeCompetenceAttValidation);
            $gradeCompetenceAttValidation->validateEditAttributes();
        break;
        case 'search':
            $attributeList = array('id_trabajo', 'id_materia', 'id_competencia', 'nota_competencia', 'dni', 'visible');
            makeList($attributeList, $gradeCompetenceAttValidation);
            $gradeCompetenceAttValidation->validateSearchAttributes();
        break;
        case 'makeVisible':
            $attributeList = array('id_trabajo', 'id_materia', 'id_competencia', 'dni', 'visible');
            makeList($attributeList, $gradeCompetenceAttValidation);
            $gradeCompetenceAttValidation->validateMakeVisibleAttributes();
        break;
    }
}
?>