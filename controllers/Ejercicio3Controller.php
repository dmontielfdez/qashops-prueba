<?php

namespace app\controllers;

use app\application\MergeCSVService;
use app\infrastructure\exceptions\CsvReaderException;
use app\infrastructure\exceptions\CsvWriterException;
use app\infrastructure\exceptions\XmlReaderException;
use yii\web\Controller;


class Ejercicio3Controller extends Controller
{
    public function actionIndex()
    {
        try {
            $mergeCsvService = new MergeCSVService();
            return \Yii::$app->response->sendFile($mergeCsvService->execute("./csv1.csv", "./csv2.csv"));
        } catch (CsvReaderException $csvReaderException) {
            return $csvReaderException->getMessage();
        } catch (CsvWriterException $csvWriterException) {
            return $csvWriterException->getMessage();
        }

    }
}
