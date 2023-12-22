#!/bin/sh
echo "\n	########## INICIANDO INSTALACIÓN FRONTEND 'EDUCENTER' ##########"
echo "\nDescargando frontend 'EDUCENTER'...\n"
git clone https://github.com/cibercereal/educenter.git
echo "\Transfiriendo archivos de frontend 'EDUCENTER'...\n"
mv educenter/View /var/www/html
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
echo "\nDebe modificar el archivo 'View/js/constants.js' estableciendo la dirección ip de su servidor"
echo "\nAcceda a la aplicación con su navegador desde: 'ip_servidor_frontend/View'"
echo "\n"
