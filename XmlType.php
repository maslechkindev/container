<?php

namespace container;

require_once(__DIR__ . '/DataTypeInterface.php');

class XmlType implements DataTypeInterface
{
    /** @var array */
    private $_data;

    /**
     * @param array $data
     */
    public function setData($data = [])
    {
        $this->_data = $data;
    }


    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param string $path
     * @return array
     */
    public function fileToArray($path = null)
    {
        try {
            $data = [];
            if ($path != null) {
                $xmlcontent = file_get_contents($path);
                $xmlstr = utf8_encode($xmlcontent);
                $xml = simplexml_load_string($xmlstr);
                foreach ($xml->item as $item) {
                    $data[$item->key->__toString()] = $item->value->__toString();
                }
            }
            return $data;
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function getDataDump($data = [])
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><container></container>");


        $this->array_to_xml($data, $xml);
        header('Content-Disposition: attachment;filename=container.xml');
        header('Content-Type: text/xml');

        echo $xml->asXML();
        die();
    }

    public function array_to_xml($array, &$xml)
    {
        foreach ($array as $key => $value) {
            $node = $xml->addChild('item');
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $node->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                } else {
                    $this->array_to_xml($value, $node);
                }
            } else {
                $node->addChild("key", "$key");
                $node->addChild("value", "$value");
            }
        }
    }
}