<?php

namespace System\DB;

# you could just use the Collection directly but this lets you do something like
# function (System\DB\Collection $db_collection){.. as a type hint. so if you want to add specific
# methods you know that everywhere you use it it will have this
class Collection extends \System\Collection {

}