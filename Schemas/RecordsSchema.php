<?php

namespace Schemas;

use System\Schema\AbstractSchema;
use System\Schema\SchemaInterface;


class RecordsSchema extends AbstractSchema implements SchemaInterface {

    function __invoke() {
        $item = $this->item;


        return array(
            "id" => $item->id,
            "name" => $item->name,
        );


    }
}