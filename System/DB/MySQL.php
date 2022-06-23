<?php

namespace System\DB;

use \PDO;

class MySQL {
    protected $pdo;

    function __construct(
        protected string $dsn,
        protected  string $username,
        protected string $password,
        protected array $options=[
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    ) {
        # this will connect when you do a new MySQL
        $this->connect();
    }

    # still let you connect again if it fails for any reason or if you close the connection
    function connect() : MySQL {
        try {
             $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $this;
    }

    function exec(string $sql,array $params = []){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $records = array();
        foreach ($stmt->fetchAll() as $record) {
            $records[] = new Record($record);
        }
        return new Collection($records);
    }

    function close() : void {
        $this->pdo = null;
    }


}