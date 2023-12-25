<?php

include __DIR__ . "/src/Framework/Database.php";

require __DIR__ . "/vendor/autoload.php";


use Framework\Database;
use Dotenv\Dotenv;
use App\Config\Paths;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

/*
$driver = 'mysql';

$config = http_build_query(data: [
  'host' => 'localhost',
  'port' => 3306,
  'dbname' => 'phpiggy'
], arg_separator: ';');

$dsn = "{$driver}:{$config}";

//Root user
$username = 'root';
$password = '';

// echo $dsn;
try {
  $db = new PDO($dsn, $username, $password);
} catch (PDOException $err) {
  die("Unable to connect to database");
}
*/

/*
$db = new Database('mysql', [
  'host' => 'localhost',
  'port' => 3306,
  'dbname' => 'phpiggy'
], 'root', '');
*/

$db = new Database($_ENV["DB_DRIVER"], [
  'host' => $_ENV["DB_HOST"],
  'port' => $_ENV["DB_PORT"],
  'dbname' => $_ENV["DB_NAME"]
], $_ENV["DB_USER"], $_ENV["DB_PASS"]);

// echo "Connected to database";


/*
// $search = "Hats' OR 1=1 -- ";
$search = "Hats";

//the question mark means its a placeholder, we can use name parameters too
// $query = "SELECT * FROM products WHERE name='{$search}'";
// $query = "SELECT * FROM products WHERE name=?";
$query = "SELECT * FROM products WHERE name=:name";



// $stmt = $db->connection->query($query, PDO::FETCH_ASSOC);
//Using a prepared statement
$stmt = $db->connection->prepare($query);

//We can use this feature to execute the query at a later time(Binding)
$stmt->bindValue('name', $search, PDO::PARAM_STR);

//After using prepare, you have to execute it to trigger fetchAll
//After using ? to signify a placeholder,we can now pass an array into execute func

//$stmt->execute([
//  'name' => $search
//]);

//AFter binding the parameter, we can now remove the array from the execute func

$stmt->execute();

var_dump($stmt->fetchAll(PDO::FETCH_OBJ));
*/

/*
//Creating Transactions
try {
  $db->connection->beginTransaction();

  $db->connection->query("INSERT INTO products VALUES(99,'Gloves')");

  $search = "Hats";

  $query = "SELECT * FROM products WHERE name=:name";

  $stmt = $db->connection->prepare($query);


  // $stmt->bindValue('name', $search, PDO::PARAM_STR);
  $stmt->bindValue('name', 'Gloves', PDO::PARAM_STR);

  $stmt->execute();

  var_dump($stmt->fetchAll(PDO::FETCH_OBJ));

  //The commit method ends a transaction
  $db->connection->commit();
} catch (Exception $err) {
  //check if a transaction exists
  if ($db->connection->inTransaction()) {

    $db->connection->rollBack();
  }
  echo "Transaction Failed";
}
*/

//Loading the database.sql file

$sqlFile = file_get_contents("./database.sql");

$db->connection->query($sqlFile);
