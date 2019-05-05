<?php

namespace app\infrastructure;

use app\infrastructure\exceptions\CsvWriterException;

class CsvWriter
{
    /**
     * Escribe un archivo csv
     *
     * @param  array $array Array para convertir
     * @return string Ruta del fichero csv convertido
     * @throws CsvWriterException Excepcion de CsvWriterException
     */
    public function write($array, $nameFile, $delimiter)
    {
        try {

            $file = __DIR__ . '/'.$nameFile.'.csv';

            $fp = fopen($file, 'w');
            foreach ($array as $values) {
                fputcsv($fp, $values, $delimiter);
            }

            fclose($fp);

            return $file;
        } catch (\Exception $ex) {
            throw CsvWriterException::withMessage($ex->getMessage());
        }

    }
}
