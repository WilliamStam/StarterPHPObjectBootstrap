<?php
namespace System\Schema;


class SchemaWrapper {
    use SchemaTrait;
    function __construct(protected $item = null) {}

    function __get($key){
        if (!$key){
            return;
        }
        if (property_exists($this->item,$key) ){
            return $this->item->$key;
        }

        return  null;
    }

}