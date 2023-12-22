<?php

include_once './Validation/validate.php';

function validate_data_criteriaCompetence() {
    include_once './Validation/Attribute/entityValidation/criteriaCompetenceAttValidation.php';

    $criteriaCompetenceAttValidation = new criteriaCompetenceAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('id_criterio', 'id_competencia');
            makeList($attributeList, $criteriaCompetenceAttValidation);
            $criteriaCompetenceAttValidation->validateAddAttributes();
        break;
        case 'delete':
            $attributeList = array('id_criterio', 'id_competencia');
            makeList($attributeList, $criteriaCompetenceAttValidation);
            $criteriaCompetenceAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('id_criterio', 'id_competencia');
            makeList($attributeList, $criteriaCompetenceAttValidation);
            $criteriaCompetenceAttValidation->validateSearchAttributes();
        break;
    }
}
?>