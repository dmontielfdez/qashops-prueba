<?php

namespace app\application;

use app\infrastructure\exceptions\CsvWriterException;
use app\infrastructure\exceptions\XmlReaderException;
use app\infrastructure\XmlReader;
use app\infrastructure\CsvWriter;

class FlattenXmlService
{

    /**
     * Aplana un XML y lo convierte a csv
     *
     * @param  string $path_xml Ruta del fichero xml a aplanar
     * @return string Ruta del fichero csv convertido
     * @throws XmlReaderException Excepcion de XmlReader
     * @throws CsvWriterException Excepcion de CsvWriterException
     */
    public function execute($path_xml)
    {
        $xmlReader = new XmlReader();
        $xmlConverted = $xmlReader->flatten($path_xml);

        $csvWriter = new CsvWriter();
        return $csvWriter->convert($xmlConverted);
    }
}
