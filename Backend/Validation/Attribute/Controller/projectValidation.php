<?php

include_once './Validation/validate.php';

function validate_data_project() {
    include_once './Validation/Attribute/entityValidation/projectAttValidation.php';

    $projectAttValidation = new projectAttValidation();

    switch(action) {
        case 'add':
            $attributeList = array('nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'id_materia', 'fecha_ini', 'fecha_fin');
            makeList($attributeList, $projectAttValidation);
            $projectAttValidation->validateAddAttributes();
        break;
        case 'edit':
            $attributeList = array('id_trabajo', 'nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'id_materia', 'fecha_ini', 'fecha_fin');
            makeList($attributeList, $projectAttValidation);
            $projectAttValidation->validateEditAttributes();
        break;
        case 'delete':
            $attributeList = array('id_trabajo');
            makeList($attributeList, $projectAttValidation);
            $projectAttValidation->validateDeleteAttributes();
        break;
        case 'search':
            $attributeList = array('id_trabajo', 'nombre_trabajo', 'descripcion_trabajo', 'porcentaje_nota', 'correccion_nota', 'nota', 'id_materia', 'fecha_ini', 'fecha_fin');
            makeList($attributeList, $projectAttValidation);
            $projectAttValidation->validateSearchAttributes();
        break;
    }
}
?>