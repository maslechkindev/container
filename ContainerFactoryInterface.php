<?php

namespace container;

interface ContainerFactoryInterface
{
    /**
     * @param string $type
     * @return array
     */
    public function getAll($type);

    /**
     * @param string $type
     * @param string | null $path
     * @param array $data
     */
    public function setAll($type, $path=null, $data = []);

    /**
     * @param string $key
     * @return string
     */
    public function get($key);

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value);
}