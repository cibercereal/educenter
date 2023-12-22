<?php

include_once './Validation/validate.php';

function validate_data_competence() {
    include_once './Validation/Attribute/entityValidation/competenceAttValidation.php';

    $competenceAttValidation = new competenceAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('titulo', 'descripcion');
            makeList($attributeList, $competenceAttValidation);
            $competenceAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_competencia', 'titulo', 'descripcion', 'id_materia');
            makeList($attributeList, $competenceAttValidation);
            $competenceAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_competencia');
            makeList($attributeList, $competenceAttValidation);
            $competenceAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('titulo', 'descripcion', 'id_materia');
            makeList($attributeList, $competenceAttValidation);
            $competenceAttValidation->validateSearchAttributes();
        break;
        case 'assignCompetence':
            $attributeList = array('id_competencia', 'id_materia');
            makeList($attributeList, $competenceAttValidation);
            $competenceAttValidation->validateAssignCompetenceAttributes();
        break;
    }
}
?>