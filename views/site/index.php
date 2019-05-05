<?php

/* @var $this yii\web\View */

$this->title = 'QaShops - Prueba técnica';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Prueba técnica para QaShops</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Ejercicio 1 - Refactoring</h2>

                <p>En la carpeta models del proyecto hay una clase llamada Product.php donde se ha hecho el refactoring
                    de la clase original.</p>

                <p>Se han creado nuevos metodos para reducir evitar comprobaciones duplicadas y dado una limpieza
                    general para entenderlo mejor.</p>
            </div>
            <div class="col-lg-4">
                <h2>Ejercicio 2 - Aplanamiento XML</h2>

                <p>Se ha creado un controlador que llama a un servicio para aplanar y convertir el XML en CSV.</p>

                <p>
                    <a href="/ejercicio2">
                        <button class="btn btn-success">
                            Ver resultado &raquo;
                        </button>
                    </a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a>
                </p>
            </div>
        </div>

    </div>
</div>
