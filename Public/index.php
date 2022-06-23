<?php
//header_remove("X-Powered-By");
//$start = (double)microtime(TRUE);
//$GLOBALS['output'] = function ($line) {
////    var_dump($line);
//};
//
//
//(require __DIR__ . '/../app/Application.php')->run();
//var_dump("index.php",((double)microtime(TRUE) - $start) * 1000);

# this just registers the paths. this way you don't have to include(file) for every class. they will load
# automatically from the namespace. if you use composer then this is probably not necessary if you use something like
# "autoload": {
#    "psr-4": {
#     "App\\": "app/",
#    }
#  },

spl_autoload_register(function ($class) {
    $root = realpath("../");

    $path = $root . DIRECTORY_SEPARATOR . $class;
    $path = str_replace(array("\\", "/", "//", "\\\\"), DIRECTORY_SEPARATOR, $path);
    $path = $path . ".php";

    if (file_exists($path)) {
        include ($path);
    } else {
        # its probably useful to add the following here:
        # var_dump($path); exit();
        # this way the prog will end and show you what file it can't find
        return FALSE;
    }
});

# get the shit from your config or whatevers
$host = '127.0.0.1';
$db   = 'portal-admin';
$user = 'root';
$pass = 'stars';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

use System\DB\MySQL;

$db = new MySQL(
    dsn: $dsn,
    username: $user,
    password: $pass
);

# db selects are done like this
$records = $db->exec("SELECT * FROM `instances` WHERE `name` LIKE :NAME LIMIT 0,3",array(
    "NAME"=>"%M%"
));



var_dump($records->name);
#you can turn a property to an array of items like this
var_dump($records->id->toArray());
# this will return the records as an array. but i suggest you use the toSchema rather. it gets super powerfull
var_dump($records->toArray());


# use toSchema to turn the object to array for outputting for instance JSON. if you loop through
# the records rather sue the raw object like foreach ($records as $item){ echo $item->name; }
# try not use the array for any logic parts

# change the file Schemas\RecordsSchema to have the fields you want
var_dump($records->toSchema(new Schemas\RecordsSchema()));

# add in "parameters" if you want to pass stuff to the schema
var_dump($records->toSchema(new Schemas\RecordsParamsSchema("myprefix","mysuffix")));

#you can also use a function for it
var_dump($records->toSchema(function($item,$param){
    # the first parameter is the "object"
    return array(
        "name"=>$item->name,
        "param"=>$param
    );
    # can send infinate items to it just csv them
},"myparamhere"));
// the passing params to it is super helpful if for instance you want to include a "selected" type field,

# this will return null if no record found type thing. so you can straight out do an if($details){ // it exists }
$details = $db->exec("SELECT * FROM instances WHERE id = :ID",array("ID"=>"4"))->first();
$records = $db->exec("SELECT * FROM instances limit 0,5");
$data = array(
    "details"=>$details->toSchema(new Schemas\RecordsSchema()),
    "list"=>$records->toSchema(new Schemas\RecordsListSchema(),$details->id),
);
echo json_encode($data);

# close your db connection hashtag housekeeping. this isnt necessary tho
$db->close();

# using the db class like this lets you do something like
# $db1 = new MySQL(
#    dsn: $dsn,
#    username: $user,
#    password: $pass
#);
# $db2 = new MySQL(
#    dsn: $dsn,
#    username: $user,
#    password: $pass
#);
# and then $db1->exec(...)
# and on the 2nd database/server/creds $db2->exec(...)
