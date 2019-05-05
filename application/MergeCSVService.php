<?php

namespace app\application;

use app\infrastructure\CsvReader;
use app\infrastructure\CsvWriter;
use app\infrastructure\exceptions\CsvReaderException;
use app\infrastructure\exceptions\CsvWriterException;

class MergeCSVService
{

    /**
     * Recibe 2 rutas de ficheros CSV y devuelve 1 fichero CSV con las cabeceras unificadas
     * y el cuerpo de los dos.
     *
     * @param  string $path_csv_1 Ruta del fichero csv 1
     * @param  string $path_csv_2 Ruta del fichero csv 2
     * @return string Ruta del fichero csv unificado
     * @throws CsvReaderException Excepcion de CsvReaderException
     * @throws CsvWriterException Excepcion de CsvWriterException
     */
    public function execute($path_csv_1, $path_csv_2)
    {
        $csvReader = new CsvReader();
        $csv1 = $csvReader->read($path_csv_1);
        $csv2 = $csvReader->read($path_csv_2);

        $dataMerged = $this->mergeCsv($csv1, $csv2);

        $csvWriter = new CsvWriter();
        return $csvWriter->write($dataMerged, "csv_merged", ",");
    }

    public function mergeCsv($csv1, $csv2)
    {
        $data = array();
        // Headers
        $data[] = array_unique(array_merge($csv1[0], $csv2[0]));

        // Body
        $data = $this->getBody($data, $csv1);
        $data = $this->getBody($data, $csv2);

        return $data;
    }

    public function getBody($data, $csv)
    {
        for ($i = 1; $i < count($csv); $i++) {
            $data[] = $csv[$i];
        }

        return $data;
    }
}
