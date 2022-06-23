<?php

namespace System\DB;


use System\Schema\SchemaTrait;

class Record {
    use SchemaTrait;
    function __construct(
        protected array $data,
    ) {}
    function __get($key) {
        return $this->data[$key] ?? null;
    }
}