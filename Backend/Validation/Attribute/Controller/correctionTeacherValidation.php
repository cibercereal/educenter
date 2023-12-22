<?php

include_once './Validation/validate.php';

function validate_data_correctionTeacher() {
    include_once './Validation/Attribute/entityValidation/correctionTeacherAttValidation.php';

    $correctionTeacherAttValidation = new correctionTeacherAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('id_criterio', 'id_trabajo', 'id_entrega');
            makeList($attributeList, $correctionTeacherAttValidation);
            $correctionTeacherAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_correccion_profesor', 'correccion_docente', 'comentario_docente');
            makeList($attributeList, $correctionTeacherAttValidation);
            $correctionTeacherAttValidation->validateEditAttributes();
        break;
        case 'search':
            $attributeList = array('id_criterio', 'id_trabajo', 'id_entrega', 'dni', 'correccion_docente');
            makeList($attributeList, $correctionTeacherAttValidation);
            $correctionTeacherAttValidation->validateSearchAttributes();
        break;
        case 'showCorrection':
            $attributeList = array('id_correccion_profesor', 'visible');
            makeList($attributeList, $correctionTeacherAttValidation);
            $correctionTeacherAttValidation->validateShowCorrectionAttributes();
        break;
        case 'delete':
           $attributeList = array('id_correccion_profesor');
           makeList($attributeList, $correctionTeacherAttValidation);
           $correctionTeacherAttValidation->validateDeleteCorrectionAttributes();
        break;
    }
}
?>