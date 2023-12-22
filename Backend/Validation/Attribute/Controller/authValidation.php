<?php
    
include_once './Validation/validate.php';

function validate_data_auth() {

    include_once './Validation/Attribute/entityValidation/authAttValidation.php';
    
    $authValidation = new authAttValidation();

    switch(action){
        case 'login':
                $attributeList = array('dni', 'password');
                makeList($attributeList, $authValidation);
                $authValidation->validate_data_login();
        break;
        case 'register':
            $attributeList = array('dni', 'nombre', 'apellidos_usuario', 'email', 'password', 'id_rol', 'direccion', 'telefono', 'fecha_nac');
            makeList($attributeList, $authValidation);
            $authValidation->validate_data_register();
        break;
        case 'getPasswordEmail':		
            $attributeList = array('dni', 'email');
            makeList($attributeList, $authValidation);
            $authValidation->validate_data_getPasswordEmail();
        break;
    }
}

function makeList($attributeList, $validation) {
    foreach ($attributeList as $attribute) {
        if (!isset($_POST[$attribute])) {
            $validation->$attribute = '';
        } else {
            $validation->$attribute = $_POST[$attribute];
        }
    }
}

?>