<?php

namespace Framework;

use PDO, PDOException, PDOStatement;

class Database
{
  public PDO $connection;
  private PDOStatement $stmt;

  public function __construct(string $driver, array $config, string $username, string $password)
  {


    $config = http_build_query(data: $config, arg_separator: ';');

    $dsn = "{$driver}:{$config}";


    // echo $dsn;
    try {
      //we added the array at the end when validating users credentials for login
      $this->connection = new PDO($dsn, $username, $password, [
        // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        19 => PDO::FETCH_ASSOC
      ]);
    } catch (PDOException $err) {
      die("Unable to connect to database");
    }
  }

  //we dddding an array of params inorder to support prepared statmemnt in the db class
  public function query(string $query, array $params = []): Database
  {
    // $this->connection->query($query);
    $this->stmt = $this->connection->prepare($query);
    $this->stmt->execute($params);

    //To make chaining possible
    return $this;
  }

  public function count()
  {
    return $this->stmt->fetchColumn();
  }

  public function find()
  {
    return $this->stmt->fetch();
  }

  public function id()
  {
    return $this->connection->lastInsertId();
  }

  //Method for grabbing multiple results from a query
  public function findAll()
  {
    return $this->stmt->fetchAll();
  }
}
