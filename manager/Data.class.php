<?php

/**
 * Created by PhpStorm.
 * User: lytvy
 * Date: 25.02.2017
 * Time: 10:47
 */
class Data
{
    private $data = array();
    public $file = null;

    function __construct($fileName)
    {
        $this->file = $fileName;
    }

    public function add($value){
        $key = $this->generateId();
        $this->data[$key]=$value;
        return $key;
    }
    public function set($key,$value){
        $this->data[$key]=$value;
        return $this->data;
    }

    public function get($key){
        return $this->data[$key];
    }

    public function getAll(){
        return array_values($this->data);
    }

    public function delete($key){
        unset($this->data[$key]);
        return $this->data;
    }


    public function load(){
        $data = file_get_contents($this->file);
        $data = unserialize($data);
        if(is_array($data)){
            $this->data = $data;
        }
        return $this->data;
    }

    public function save(){
        $data = serialize($this->data);
        file_put_contents($this->file,$data);
    }

    function generateId($prefix='') {
        return uniqid ($prefix);
    }

}