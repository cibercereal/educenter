<?php

include_once './Validation/validate.php';

function validate_data_correctionCriteria() {
    include_once './Validation/Attribute/entityValidation/correctionCriteriaAttValidation.php';

    $correctionCriteriaAttValidation = new correctionCriteriaAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('dni_alumno', 'id_trabajo', 'id_entrega', 'fecha_fin_correccion');
            makeList($attributeList, $correctionCriteriaAttValidation);
            $correctionCriteriaAttValidation->validateAddAttributes();
        break;
        case 'search':
            $attributeList = array('dni_alumno', 'id_entrega', 'id_trabajo', 'fecha_fin_correccion');
            makeList($attributeList, $correctionCriteriaAttValidation);
            $correctionCriteriaAttValidation->validateSearchAttributes();
        break;
        case 'edit':
            $attributeList = array('id_correccion_criterio', 'correccion_alumno', 'comentario_alumno');
            makeList($attributeList, $correctionCriteriaAttValidation);
            $correctionCriteriaAttValidation->validateEditAttributes();
        break;
        case 'editTeacher':
            $attributeList = array('id_correccion_criterio', 'correccion_docente', 'comentario_docente');
            makeList($attributeList, $correctionCriteriaAttValidation);
            $correctionCriteriaAttValidation->validateEditTeacherAttributes();
        break;
        case 'assignRandom':
            $attributeList = array('numero_alumnos', 'id_trabajo', 'fecha_fin_correccion');
            makeList($attributeList, $correctionCriteriaAttValidation);
            $correctionCriteriaAttValidation->validateAssignRandom();
        break;
    }
}
?>