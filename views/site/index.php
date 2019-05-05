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
                <h2>Ejercicio 3 - Merge de 2 CSV</h2>

                <p>Se ha creado un controlador que llama a un servicio para unir los 2 CSV.</p>

                <p>
                    <a href="/ejercicio3">
                        <button class="btn btn-success">
                            Ver resultado &raquo;
                        </button>
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
