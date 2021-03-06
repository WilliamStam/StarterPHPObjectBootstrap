<?php

namespace System;

use System\Schema\SchemaWrapper;
class Collection implements \IteratorAggregate {

    private $collection = array();

    function __construct(?iterable $iterable=null){
        if ($iterable){
            $this->addFromIterable($iterable);
        }
    }

    function add($obj) {
        $this->collection[] = $obj;

        return $obj;
    }
    function addFromIterable($iterable) : Collection {
        foreach ($iterable as $obj){
            $this->add($obj);
        }
        return $this;
    }

    function getIterator() {
        return new \ArrayIterator($this->collection);
    }

    function count() : int {
        return count($this->collection);
    }

    function first() {
        return $this->collection[0] ?? null;
    }

    function last() {
        return $this->collection[count($this->collection) - 1] ?? null;
    }

    function withSlice($offset = 0, $length = -1) : Collection {
        $return = new Collection();
        foreach (array_slice($this->collection, $offset, $length) as $item) {
            $return->add($item);
        }
        return $return;
    }
    function withFilter() : Collection {
        $return = new Collection();
        $args = func_get_args();
        $func = array_shift($args );
        foreach ($this->collection as $item) {
            if (call_user_func_array($func, array($item,...$args))){
                $return->add($item);
            }
        }
        return $return;
    }
    function withSort(callable $function) : Collection {
        $return = new Collection();

        $collection = $this->collection;

        usort($collection,$function);

        foreach ($collection as $item){
            $return->add($item);
        }

        return $return;
    }

    function toSchema() : array {
        $return = array();
        foreach ($this->collection as $item) {
            if (!method_exists($item,"toSchema")){
                $item = new SchemaWrapper($item);
            }
            $return[] = $item->toSchema(...func_get_args());
        }
        return $return;
    }

    function toArray() : array {
        $return = array();
        foreach ($this->collection as $item) {
            if (is_object($item) && method_exists($item, "toArray")) {
                $return[] = $item->toArray();
            } else {
                $return[] = $item;
            }

        }
        return $return;
    }

    function getCollection() {
        return $this->collection;
    }

    function __call($method, $args) {
        $return = new Collection();
        foreach ($this->collection as $item) {
            $return->add(call_user_func_array(array($item, $method), $args));
        }

        return $return;
    }

    function __get($key) {
        $return = new Collection();
        foreach ($this->collection as $item) {
            $return->add($item->$key);
        }

        return $return;
    }

    function getCount() {
        return count($this->collection);
    }


}

