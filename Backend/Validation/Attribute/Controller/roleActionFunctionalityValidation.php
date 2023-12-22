<?php
    
include_once './Validation/validate.php';

function validate_data_roleActionFunctionality() {

    include_once './Validation/Attribute/entityValidation/roleActionFunctionalityAttValidation.php';
    
    $roleActionFunctionalityValidation = new roleActionFunctionalityAttValidation();

    switch(action){
        case 'search':
            $attributeList = array('id_rol', 'id_accion', 'id_funcionalidad');
            makeList($attributeList, $roleActionFunctionalityValidation);
            $roleActionFunctionalityValidation->validateSearchAttributes();
        break;
        case 'add':
            $attributeList = array('id_rol', 'id_accion', 'id_funcionalidad');
            makeList($attributeList, $roleActionFunctionalityValidation);
            $roleActionFunctionalityValidation->validateAddAttributes();
        break;
        case 'delete':
            $attributeList = array('id_rol', 'id_accion', 'id_funcionalidad');
            makeList($attributeList, $roleActionFunctionalityValidation);
            $roleActionFunctionalityValidation->validateDeleteAttributes();
        break;
    }
}

?>