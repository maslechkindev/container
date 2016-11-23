<?php

namespace container;

require_once(__DIR__.'/DataTypeInterface.php');

class IniType implements DataTypeInterface
{
    const INI_FILE_NAME = 'container.ini';
    /** @var array  */
    private $_data;

    public function setData($data=[]){
        $this->_data = $data;
    }


    public function getData(){
        return $this->_data;
    }
    
    /**
     * @param string $path
     * @return array
     */
    public function fileToArray($path=null)
    {
        try {
            if ($path != null) {
                return parse_ini_file($path);
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
    
    public function getDataDump($data=[])
    {
        $container_str = '';
        foreach($data as $key=>$val){
            if(is_array($val)){
                foreach($val as $k=>$v){
                    $container_str .= $key."[".$k."]=".$v."\n";
                }
            } else {
                $container_str .= $key."=".$val."\n";
            }
        }
        $file = self::INI_FILE_NAME;
        file_put_contents($file, $container_str);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
}