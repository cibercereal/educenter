<?php

include_once './Controller/ControllerBase.php';

class delivery extends ControllerBase {

    function download() {
        $jsonData = $_POST['data'];
        // Ruta completa del archivo en la carpeta temporal
        $rutaArchivoTemporal = $jsonData['document']['tmp_name'];
        // Verificar que el archivo existe
        if (file_exists($rutaArchivoTemporal)) {
            // Establecer las cabeceras para indicar que se descargará un archivo
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$jsonData['document']['name'].'"');
            // Leer y enviar el contenido del archivo al navegador
            readfile($rutaArchivoTemporal);
            exit;
        } else {
            $this->feedback['ok'] = false;
            $this->feedback['code'] = "FILE_NOT_FOUND";
            return $this->feedback;
        }
    }
}
?>