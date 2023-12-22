<?php
    
include_once './Validation/validate.php';

function validate_data_actionFunctionality() {

    include_once './Validation/Attribute/entityValidation/actionFunctionalityAttValidation.php';
    
    $actionFunctionalityValidation = new actionFunctionalityAttValidation();

    switch(action){
        case 'search':
            $attributeList = array('id_accion', 'id_funcionalidad');
            makeList($attributeList, $actionFunctionalityValidation);
            $actionFunctionalityValidation->validateSearchAttributes();
        break;
        case 'add':
            $attributeList = array('id_accion', 'id_funcionalidad');
            makeList($attributeList, $actionFunctionalityValidation);
            $actionFunctionalityValidation->validateAddAttributes();
        break;
        case 'delete':
            $attributeList = array('id_accion', 'id_funcionalidad');
            makeList($attributeList, $actionFunctionalityValidation);
            $actionFunctionalityValidation->validateDeleteAttributes();
        break;
    }
}

?>