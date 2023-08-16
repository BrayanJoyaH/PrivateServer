# SISTEMA BASADO EN EL PROTOTIPO DE CODIGO 1 

El mismo prototipo de código se ha usado para desarrollar dos sistemas, que solo divergen en algunas funciones adicionales uno del otro. El primer sistema es una web personal y el segundo sistema es un sistema de gestión de archivos. EL presente es el sistema geestor de archivos "Private server"... Para ver el otro sistema consulta mi repositorio buscando "PortafolioSystem".

# Instrucciones para instalar XAMPP e importar una base de datos existente

¡Bienvenido/a! A continuación, encontrarás los pasos para instalar XAMPP y cómo importar una base de datos ya existente. Asumo que tienes conocimientos previos, pero siempre es útil contar con documentación. ¡Comencemos!

## Clonar el repositorio

0. **Clona el repositorio**: los archivos deben quedar dentro de xampp/htdocs/gestorDeArchivos/

## Instalación de XAMPP

1. **Descarga XAMPP**: Ve al sitio web oficial de XAMPP (https://www.apachefriends.org/es/index.html) y descarga la versión adecuada para tu sistema operativo (Windows, macOS o Linux).

2. **Ejecuta el instalador**: Una vez descargado, ejecuta el archivo de instalación y sigue las instrucciones del asistente para instalar XAMPP en tu sistema.

3. **Selecciona componentes**: Durante la instalación, se te pedirá seleccionar los componentes que deseas instalar. Asegúrate de seleccionar "MySQL" para poder trabajar con bases de datos.

4. **Elige el directorio de instalación**: Selecciona la ubicación donde deseas instalar XAMPP en tu sistema.

5. **Completa la instalación**: Sigue las indicaciones del instalador para completar la instalación de XAMPP.


## Importar una base de datos existente

6. **Inicia XAMPP**: Una vez instalado, ejecuta XAMPP desde el menú de inicio o la ubicación donde lo hayas instalado.

7. **Inicia los servicios**: Asegúrate de que los servicios de "Apache" y "MySQL" estén activos. Puedes hacerlo desde la interfaz de XAMPP.

8. **Accede a phpMyAdmin**: Abre tu navegador web y ve a la siguiente dirección: http://localhost/phpmyadmin/

9. **Inicia sesión**: Ingresa con el nombre de usuario y contraseña de tu servidor MySQL. Por defecto, puedes usar "root" como nombre de usuario y dejar la contraseña en blanco. No tiende a pedir contraseña en local.

10. **Crea una nueva base de datos**: Si deseas importar la base de datos en una nueva base de datos, haz clic en "Nueva" en el panel lateral izquierdo, ingresa el nombre de la base de datos en este caso "private_server" y selecciona el juego de caracteres deseado.

11. **Importa la base de datos**: Una vez creada la base de datos (o si deseas importar en una existente), selecciona la base de datos en el panel lateral izquierdo y luego ve a la pestaña "Importar". Haz clic en "Examinar" para seleccionar el archivo de la base de datos que deseas importar y luego pulsa "Continuar" para iniciar el proceso de importación.

12. **¡Listo!**: Una vez que se complete el proceso de importación, habrás importado exitosamente la base de datos existente a XAMPP.


## El único código que tienes que editar

13. **Edita la funcion SendMail**: Ve a la ruta ./funcs/funcs.php y busca la funcion SendMail (131-200) y edita las líneas 144, 145, 157.

¡Eso es todo! Ahora estás listo/a para trabajar con XAMPP y tu base de datos. Si tienes alguna pregunta o necesitas más ayuda, no dudes en consultar la documentación oficial de XAMPP o buscar recursos adicionales en línea, o consultarme a mi personalmente por algun medio. ¡Buena suerte en tus proyectos!
