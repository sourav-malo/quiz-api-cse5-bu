<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(__DIR__) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Users;
  use \models\Categories;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $categories = new Categories($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';

  $allCategories = $categories->read()->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($allCategories);
?>