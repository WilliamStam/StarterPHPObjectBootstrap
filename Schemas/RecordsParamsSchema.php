<?php

namespace Schemas;

use System\Schema\AbstractSchema;
use System\Schema\SchemaInterface;


class RecordsParamsSchema extends AbstractSchema implements SchemaInterface {

    function __invoke(string $prefix="", string $suffix="") {
        $item = $this->item;
        return array(
            "id" => $item->id,
            "name" => $prefix . "|" . $item->name . "|" . $suffix,
        );


    }
}