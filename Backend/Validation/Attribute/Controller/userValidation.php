<?php
    
include_once './Validation/validate.php';

function validate_data_user() {

    include_once './Validation/Attribute/entityValidation/userAttValidation.php';
    
    $userValidation = new userAttValidation();

    switch(action){
        case 'search':
            if(isset($_POST['fecha_nac'])){
                if($_POST['fecha_nac'] == '1900-01-01'){
                    $_POST['fecha_nac'] = '';
                }
            }
            $attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
            makeList($attributeList, $userValidation);
            $userValidation->validateSearchAttributes();
            break;
        case 'searchBy':
            $attributeList = array('dni');
            makeList($attributeList, $userValidation);
            $userValidation->validateSearchByAttributes();
            break;
        case 'add':
            $attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
            makeList($attributeList, $userValidation);
            $userValidation->validateAddAttributes();
            break;
        case 'edit':
            $attributeList = array('nombre', 'apellidos_usuario', 'email', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
            makeList($attributeList, $userValidation);
            $userValidation->validateEditAttributes();
            break;
        case 'delete':
            $attributeList = array('dni');
            makeList($attributeList, $userValidation);
            $userValidation->validateDeleteAttributes();
            break;
        case 'editPass':
            $attributeList = array('password');
            makeList($attributeList, $userValidation);
            $userValidation->validateEditPassAattributes();
            break;
    }
}
?>