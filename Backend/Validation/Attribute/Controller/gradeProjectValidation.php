<?php

include_once './Validation/validate.php';

function validate_data_gradeProject() {
    include_once './Validation/Attribute/entityValidation/gradeProjectAttValidation.php';

    $gradeProjectAttValidation = new gradeProjectAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('id_trabajo', 'id_entrega');
            makeList($attributeList, $gradeProjectAttValidation);
            $gradeProjectAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_trabajo', 'id_entrega', 'visible');
            makeList($attributeList, $gradeProjectAttValidation);
            $gradeProjectAttValidation->validateEditAttributes();
        break;
        case 'search':
            $attributeList = array('id_trabajo', 'id_entrega', 'nota_trabajo', 'nota_correccion', 'dni', 'visible');
            makeList($attributeList, $gradeProjectAttValidation);
            $gradeProjectAttValidation->validateSearchAttributes();
        break;
    }
}
?>