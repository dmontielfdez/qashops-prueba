<?php

namespace app\infrastructure;

use app\infrastructure\exceptions\CsvWriterException;

class CsvWriter
{
    /**
     * Escribe un archivo csv en el directorio con nombre output.csv
     *
     * @param  array $arrayToConvert Array para convertir
     * @return string Ruta del fichero csv convertido
     * @throws CsvWriterException Excepcion de CsvWriterException
     */
    public function convert($arrayToConvert)
    {
        try {

            $file = __DIR__ . '/output.csv';

            $fp = fopen($file, 'w');
            foreach ($arrayToConvert as $values) {
                fputcsv($fp, $values, ";");
            }

            fclose($fp);

            return $file;
        } catch (\Exception $ex) {
            throw CsvWriterException::withMessage($ex->getMessage());
        }

    }
}
