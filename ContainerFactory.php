<?php

namespace container;

require_once(__DIR__.'/ContainerFactoryInterface.php');
require_once(__DIR__.'/IniType.php');
require_once(__DIR__.'/XmlType.php');

class ContainerFactory implements ContainerFactoryInterface
{
    const INI_TYPE = 'ini';
    const XML_TYPE = 'xml';
    const ARRAY_TYPE = 'array';
    const JSON_TYPE = 'json';
    const FILE_METHOD_NAME = 'fileToArray';

    /** @var array  */
    private static $_container = [];

    /**
     * ContainerFactory constructor.
     * @param string $type
     * @param string $path
     * @param array $data
     */
    public function setAll($type, $path=null, $data = [])
    {
        switch($type){
            case self::INI_TYPE:
                $this->_setContainer(new IniType(), $path, []);
                break;
            case self::XML_TYPE:
                $this->_setContainer(new XmlType(), $path, []);
                break;
            case self::ARRAY_TYPE;
                self::$_container = array_merge(self::$_container, $data);
                break;
            case self::JSON_TYPE;
                $data = json_decode($data, true);
                self::$_container = array_merge(self::$_container, is_array($data) ? $data : []);
                break;
        }
    }

    /**
     * @param \container\DataTypeInterface $type
     * @param null $path
     * @param array $data
     */
    private function _setContainer(DataTypeInterface $type, $path=null, $data = []){
       $type->setData($path != null ? $type->fileToArray($path) : $data);
        self::$_container = array_merge(self::$_container, $type->getData());
    }

    /**
     * @param string $type
     * @return array
     */
    public function getAll($type){
        switch($type){
            case self::INI_TYPE:
                (new IniType())->getDataDump(self::$_container);
                break;
            case self::XML_TYPE:
                (new XmlType())->getDataDump(self::$_container);
                break;
            case self::ARRAY_TYPE;
                return self::$_container;
                break;
            case self::JSON_TYPE;
                return json_encode(self::$_container);
                break;
        }

    }

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        $data = self::$_container;
        return !empty($data[$key]) ? $data[$key] : [];
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $data = self::$_container;
        $data[$key] = $value;
        self::$_container = $data;
    }
}