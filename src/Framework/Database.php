<?php

namespace Framework;

use PDO, PDOException;

class Database
{
  public PDO $connection;
  public function __construct(string $driver, array $config, string $username, string $password)
  {


    $config = http_build_query(data: $config, arg_separator: ';');

    $dsn = "{$driver}:{$config}";


    // echo $dsn;
    try {
      $this->connection = new PDO($dsn, $username, $password);
    } catch (PDOException $err) {
      die("Unable to connect to database");
    }
  }
}
