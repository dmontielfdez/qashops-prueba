<p align="center">
    <h1 align="center">Prueba técnica para QaShops</h1>
    <br>
</p>

Proyecto realizado con el framwework Yii2 de PHP para prueba técnica de QaShops.


### Instalación

Descargar una copia del repositorio e instalar las dependencias con Composer. Una vez instaladas las dependencias ejecutar:

~~~
php yii serve
~~~

Abrir en el navegador la URL:

~~~
http://localhost:8080/
~~~

### Ejercicio 1

En la carpeta models del proyecto hay una clase llamada Product.php donde se ha hecho el refactoring de la clase original.

Se han creado nuevos metodos para reducir evitar comprobaciones duplicadas y dado una limpieza general para entenderlo mejor.

### Ejericio 2 y 3

Se ha creado una estructura de capas para poder reutilizar codigo. Hay un controlador por cada ejercicio en la carpeta controllers.

Estos llaman a una capa de servicio que hace el aplanamiento del XML o el merge de los CSV.

Por otro lado, se han creado diferentes clases de ayuda como XmlReader.php, CsvReader.php o CsvWriter.php que las utilzamos para realizar todos los procesos.

Ademas, se han creado excepciones propias para cada clase con el fin de tener controlado posibles errores.