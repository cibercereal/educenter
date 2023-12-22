#!/bin/sh
echo "\n	########## INICIANDO INSTALACIÓN BACKEND 'EDUCENTER' ##########"
echo "\nDescargando backend 'EDUCENTER'...\n"
git clone https://github.com/cibercereal/educenter.git
echo "\Transfiriendo archivos de backend 'EDUCENTER'...\n"
mv educenter/Backend /var/www/html
rm -rf educenter
echo "\nDescarga finalizada"
echo "\n"
echo " ####### ######  #     # ####### ####### #     # ####### ####### ##### "
echo " #       #     # #     # #       #       ##    #    #    #       #    #"
echo " #       #     # #     # #       #       # #   #    #    #       #    #"
echo " #####   #     # #     # #       #####   #  #  #    #    #####   ##### "
echo " #       #     # #     # #       #       #   # #    #    #       # #   "
echo " #       #     # #     # #       #       #    ##    #    #       #  #  "
echo " ####### ######   #####  ####### ####### #     #    #    ####### #   # "
echo "\n	########## INSTALACIÓN FINALIZADA  ##########"
echo "\nDebe modificar el archivo 'Backend/Core/config.php' estableciendo la dirección IP de su servidor de backend"
echo "\nDebe ejecutar el script SQL 'Backend/Core/bd.sql' para ejecutar la aplicación"
echo "\nDebe ejecutar el script SQL 'Backend/Core/dbTest.sql' para ejecutar los test"
echo "\nAcceda a la aplicación con su navegador desde: 'ip_servidor_front/View'"
echo "\n"
