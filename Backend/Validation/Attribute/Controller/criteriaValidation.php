<?php

include_once './Validation/validate.php';

function validate_data_criteria() {
    include_once './Validation/Attribute/entityValidation/criteriaAttValidation.php';

    $criteriaAttValidation = new criteriaAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('descripcion', 'id_trabajo');
            makeList($attributeList, $criteriaAttValidation);
            $criteriaAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_criterio', 'descripcion', 'id_trabajo');
            makeList($attributeList, $criteriaAttValidation);
            $criteriaAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_criterio');
            makeList($attributeList, $criteriaAttValidation);
            $criteriaAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('descripcion', 'id_trabajo');
            makeList($attributeList, $criteriaAttValidation);
            $criteriaAttValidation->validateSearchAttributes();
        break;
    }
}
?>