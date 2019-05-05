<?php

namespace app\infrastructure;

use app\infrastructure\exceptions\XmlReaderException;
use SimpleXMLElement;

class XmlReader
{
    /**
     * Lee un fichero XML y lo aplana
     *
     * @param  string $path_xml Ruta del fichero xml a aplanar
     * @return array $data Array del xml aplanado
     * @throws XmlReaderException Excepcion de XmlReader
     */
    public function flatten($path_xml)
    {
        try {
            $xml = new SimpleXMLElement(__DIR__ . $path_xml, 0, true);

            $data = array();
            // 1º Recorro los elementos para buscar todas las cabeceras
            $headersCsv = array();
            foreach ($xml->products->product as $product) {
                foreach ($product as $key => $value) {
                    if (!in_array($key, $headersCsv)) {
                        $headersCsv[] = $key;
                    }
                }
            }
            $data[] = $headersCsv;

            // 2º Busco en cada elemento la cabecera
            foreach ($xml->products->product as $product) {
                $productCsv = array();
                foreach ($headersCsv as $header) {
                    $productCsv[] = $product->$header;
                }
                $data[] = $productCsv;
            }

            return $data;

        } catch (\Exception $ex) {
            throw XmlReaderException::withMessage($ex->getMessage());
        }

    }
}
