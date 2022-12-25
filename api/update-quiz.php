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
  use \models\Topics;
  use \models\Quiz;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $topics = new Topics($db);
  $quiz = new Quiz($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';
  require __DIR__ . '/validations/update-quiz.validation.php';

  $quiz->question = !isset($_POST['question']) || !$_POST['question'] ? $singleQuiz['question'] : $_POST['question'];
  $quiz->options = !isset($_POST['options']) || !$_POST['options'] ? $singleQuiz['options'] : $_POST['options'];
  $quiz->correctOptions = !isset($_POST['correctOptions']) || !$_POST['correctOptions'] ? $singleQuiz['correctOptions'] : json_encode($sanitizedCorrectOptions);
  $quiz->topicId = !isset($_POST['topicId']) || !$_POST['topicId'] ? $singleQuiz['topicId'] : $_POST['topicId'];
  $quiz->updatedAt = date('Y-m-d H:i:s', time());

  if(!$quiz->update()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  $singleQuiz = $quiz->readById()->fetch(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($singleQuiz);
?>