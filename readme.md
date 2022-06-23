# Webserver

point your webserver to the /Public folder

# Things included

- MySQL PDO: 
    - `$db = new MySQL(...);`
    - `$records = $db->exec("SELECT ...",[]);` 
    - returns a collection of the records
```
use System\DB\MySQL;
# this should come from the config but that might be a future update
$db = new MySQL(
    dsn: "mysql:host=127.0.0.1;dbname=portal-admin;charset=$charset",
    username: "root",
    password: "password"
);
$records = $db->exec("SELECT * FROM `instances` WHERE `name` LIKE :NAME LIMIT 0,3",array(
    "NAME"=>"%M%"
));

```

- Collections: 
    - `$collection = new Collection(iterable);`
    - `$collection->key;` this returns a collection of just this key 
    - `$collection->key->toArray();` the above but turns it to an array 
    - `$collection->toSchema(..);` 
    - `$collection->toArray()`
    - `$collection->first()`
    - `$collection->last()`
    - `$collection->slice(..)`
```
$collection = new Collection(array(
  array("id"=>"3","name"=>"william"),
  array("id"=>"2","name"=>"bluff")
));
# get a collection of just name for each record
$collection->name;
#turn the result to array
$collection->name->toArray();

```

- Schemas: (for when you want to re use an output across your project)
    -  `$collection->toSchema(new schema());`
    -  `$collection->toSchema(new schema(),$params_i_want_to,$send_to_the,$schema);`
    -  `$collection->toSchema(function($item){ return array("id"=>$item->id,"name"=>$item->name); });` if you want to add a closure as a schema

```
# each record will come out as the schema (returns array)
$collection->toSchema(new schema());

# using a closure (inline function)
$collection->toSchema(function($item){ 
  return array(
    "id"=>$item->id,
    "name"=>$item->name); 
  });


```