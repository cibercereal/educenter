<?php

include_once './Validation/validate.php';

function validate_data_delivery() {
    include_once './Validation/Attribute/entityValidation/deliveryAttValidation.php';

    $deliveryAttValidation = new deliveryAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('fecha_entrega', 'id_trabajo', 'dni', 'datos');
            makeList($attributeList, $deliveryAttValidation);
            $deliveryAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_entrega', 'datos');
            makeList($attributeList, $deliveryAttValidation);
            $deliveryAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_entrega');
            makeList($attributeList, $deliveryAttValidation);
            $deliveryAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('fecha_entrega', 'id_trabajo', 'dni');
            makeList($attributeList, $deliveryAttValidation);
            $deliveryAttValidation->validateSearchAttributes();
        break;
    }
}
?>