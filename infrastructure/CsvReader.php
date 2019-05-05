<?php

namespace app\infrastructure;

use app\infrastructure\exceptions\CsvReaderException;

class CsvReader
{
    /**
     * Lee un archivo csv y lo devuelve como un array
     *
     * @param  string $path Ruta del fichero a leer
     * @return array $csv Array leido del fichero CSV
     * @throws CsvReaderException Excepcion de CsvReaderException
     */
    public function read($path)
    {
        try {
            $csv = array_map('str_getcsv', file(__DIR__ . $path));

            return $csv;
        } catch (\Exception $ex) {
            throw CsvReaderException::withMessage($ex->getMessage());
        }
    }
}
