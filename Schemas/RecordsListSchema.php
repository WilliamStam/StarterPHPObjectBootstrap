<?php

namespace Schemas;

use System\Schema\AbstractSchema;
use System\Schema\SchemaInterface;


class RecordsListSchema extends AbstractSchema implements SchemaInterface {

    function __invoke(string $selected=null) {
        $item = $this->item;
        return array(
            "id" => $item->id,
            "name" => $item->name,
            "selected"=>$item->id == $selected
        );


    }
}