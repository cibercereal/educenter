<?php

include_once './Validation/validate.php';

function validate_data_academicCourse() {

    include_once './Validation/Attribute/entityValidation/academicCourseAttValidation.php';

    $academicCourseValidation = new academicCourseAttValidation();

    switch(action){
        case 'search':
            $attributeList = array('nombre_curso_academico');
            makeList($attributeList, $academicCourseValidation);
            $academicCourseValidation->validateSearchAttributes();
            break;
        case 'add':
            $attributeList = array('nombre_curso_academico');
            makeList($attributeList, $academicCourseValidation);
            $academicCourseValidation->validateAddAttributes();
            break;
        case 'edit':
            $attributeList = array('id_curso_academico', 'nombre_curso_academico');
            makeList($attributeList, $academicCourseValidation);
            $academicCourseValidation->validateEditAttributes();
            break;
        case 'delete':
            $attributeList = array('id_curso_academico');
            makeList($attributeList, $academicCourseValidation);
            $academicCourseValidation->validateDeleteAttributes();
            break;
    }
}
?>