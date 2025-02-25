<?php

class DB {
  public static function connect() {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'ip_picker';

    return new PDO("mysql:host={$host};dbname={$database};charset=UTF8;", $user, $pass);
  }
}


try {
  
  $sql = "
  CREATE TABLE IF NOT EXISTS ip_registrados(
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_number VARCHAR(255) NOT NULL UNIQUE,
    pais VARCHAR(50), 
    estado VARCHAR(50),
    cidade VARCHAR(50),
    operadora VARCHAR(50)
  )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  ";
  $db = DB::connect();
  $rs = $db->prepare($sql);
  $rs->execute();
} catch (\Throwable $th) {
  echo "Erro ao criar tabela.";
  echo $th;
}