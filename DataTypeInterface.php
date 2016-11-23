<?php

namespace container;

interface DataTypeInterface
{
    public function setData($data=[]);

    public function getData();

    public function fileToArray($path=null);

    public function getDataDump($data=[]);

}