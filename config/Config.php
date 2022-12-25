<?php
  namespace config;

  class Config {
    public static $ROOT_DIR;
    public const TIMEZONE = 'Asia/Dhaka';
    public const PROFILE_PIC_UPLOAD_DIR = 'uploads/users/';
    public const CATEGORY_PIC_UPLOAD_DIR = 'uploads/categories/';
    public const TOPIC_PIC_UPLOAD_DIR = 'uploads/topics/';

    public function __construct() {
      self::$ROOT_DIR = $_ENV['ROOT_DIR'];

      date_default_timezone_set(self::TIMEZONE);
    }

    public static function uploadFile($file, $uploadDir) {
      $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
      $randFileName = bin2hex(random_bytes(10));
      $uploadFileName = $uploadDir . $randFileName . '.' . $fileExt;
      $uploadFileLoc = __DIR__ . '/../' . $uploadFileName;
      return move_uploaded_file($file['tmp_name'], $uploadFileLoc) ? $uploadFileName : false;
    }
  }
?>