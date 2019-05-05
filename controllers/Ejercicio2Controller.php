<?php

namespace app\controllers;

use app\infrastructure\exceptions\CsvWriterException;
use app\infrastructure\exceptions\XmlReaderException;
use yii\web\Controller;
use app\application\FlattenXmlService;

class Ejercicio2Controller extends Controller
{
    public function actionIndex()
    {
        try {
            $flattenXmlService = new FlattenXmlService();
            return \Yii::$app->response->sendFile($flattenXmlService->execute("./aplanamiento.xml"));
        } catch (XmlReaderException $xmlReaderException) {
            return $xmlReaderException->getMessage();
        } catch (CsvWriterException $csvWriterException) {
            return $csvWriterException->getMessage();
        }

    }
}
