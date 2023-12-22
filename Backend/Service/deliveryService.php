<?php

include_once './Service/ServiceBase.php';
include_once './Validation/Attribute/Controller/deliveryValidation.php';

class deliveryService extends ServiceBase {

    private $projectModel;
    private $userModel;
    private $subjectStudentModel;
    private $subjectTeacherModel;
    private $subjectModel;

    function startRest() {
        $this->listAttributesEqual = array();
        if ((action == 'add' || action == 'edit') && !isset($_POST['test'])) {
            $_POST['datos'] = $_FILES['datos'];
            $nombreTemporalActual = $_FILES['datos']['tmp_name']; // Nombre temporal actual del archivo
            $nuevoNombreTemporal = time() . $_FILES['datos']['name']; // Nuevo nombre que deseas asignar al archivo temporal

            // Ruta completa de destino
            $rutaDestino = realpath(__DIR__ . DIRECTORY_SEPARATOR . SAVE_ROUTE) . DIRECTORY_SEPARATOR . $nuevoNombreTemporal;
            // Cambiar el nombre del archivo temporal utilizando la función rename()
            rename($nombreTemporalActual, $rutaDestino);
            $_POST['datos']['name'] = $nuevoNombreTemporal;
            $_POST['datos']['tmp_name'] = $rutaDestino;
        }
        $this->validateDataAttributes();

        switch(action) {
            case 'add':
                $this->attributeList = array('id_trabajo', 'dni', 'datos');
            break;
            case 'edit':
                $this->attributeList = array('id_entrega', 'datos');
            break;
            case 'delete':
                $this->attributeList = array('id_entrega');
            break;
            case 'search':
                $this->attributeList = array('fecha_entrega', 'id_trabajo', 'dni');
                $this->listAttributesEqual = array('id_trabajo', 'dni');
            break;
        }

        $this->model = $this->createModelOne('delivery');
        $this->projectModel = $this->createModelOne('project');
        $this->userModel = $this->createModelOne('user');
        $this->subjectStudentModel = $this->createModelOne('subjectStudent');
        $this->subjectTeacherModel = $this->createModelOne('subjectAssignment');
        $this->subjectModel = $this->createModelOne('subject');
        $this->validationClass = $this->createValidationOne('delivery');
        $this->validationClass->model = $this->model;
        $this->validationClass->project = $this->projectModel;
        $this->validationClass->user = $this->userModel;
        $this->validationClass->subjectStudent = $this->subjectStudentModel;
        $this->validationClass->subjectTeacher = $this->subjectTeacherModel;
        $this->validationClass->subject = $this->subjectModel;
        return $this->returnRest(action);
    }

    function returnRest($action) {
        switch(action) {
            case 'add':
                $this->model->arrayDataValue['fecha_entrega'] = date('Y-m-d');
                $this->validateAdd();
                $this->model->arrayDataValue['datos'] = json_encode($this->model->arrayDataValue['datos']);
                return $this->addDelivery('ANADIR_ENTREGA_OK');
            break;
            case 'edit':
                $this->model->arrayDataValue['fecha_entrega'] = date('Y-m-d');
                $this->validateEdit();
                $this->model->arrayDataValue['datos'] = json_encode($this->model->arrayDataValue['datos']);
                return $this->editDelivery('EDITAR_ENTREGA_OK');
            break;
            case 'delete':
                $this->validationClass->validateDelete();
                return $this->deleteDelivery('ELIMINAR_ENTREGA_OK');
            break;
            case 'search':
                $this->model->arrayDataValue['dni'] = isset($this->model->arrayDataValue['dni']) ? $this->model->arrayDataValue['dni'] : '';
                $this->model->arrayDataValue['id_trabajo'] = isset($this->model->arrayDataValue['id_trabajo']) ? $this->model->arrayDataValue['id_trabajo'] : '';
                $this->model->arrayDataValue['fecha_entrega'] = isset($this->model->arrayDataValue['fecha_entrega']) ? $this->model->arrayDataValue['fecha_entrega'] : '';
                $this->validateSearch();
                return $this->search();
            break;
        }
    }

    function deleteDelivery($msg) {
        $this->model->DELETE();

        return $this->createFeedback($msg);
    }

    function editDelivery($msg) {
        $this->model->EDIT();
        return $this->createFeedback($msg);
    }

    function addDelivery($msg) {
        $this->model->ADD();
        return $this->createFeedback($msg);
    }

    function createFeedback($message) {
        $this->feedback['code'] = $message;
        $this->feedback['ok'] = true;
        return $this->feedback;
    }
}
?>