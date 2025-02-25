<?php 
include_once 'style/style.css';
include_once 'class/Database.php';
include_once 'class/IP.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Picker</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>
    <header>
        <h1>IP Picker</h1>
    </header>

    <?php
    
    try {

        $ip_do_usuario = IP::IpPick();

        $info = file_get_contents("http://ip-api.com/json/$ip_do_usuario");
        $dados = json_decode($info, true);
    
        $db = DB::connect();
        $rs = $db->prepare("INSERT INTO ip_registrados (ip_number, pais, estado, cidade, operadora) VALUES (:ip_number, :pais, :estado, :cidade, :operadora)");
        $rs->execute([
            ':ip_number' => $dados['query'],
            ':pais' => $dados['countryCode'],
            ':estado' => $dados['region'],
            ':cidade' => $dados['city'],
            ':operadora' => $dados['isp']
        ]);

        echo json_encode(["msg_success" => "vlw ae pelo teu IP"]);
        echo "<br>P<br>";
        echo "3<br>";
        echo "P<br>";
        http_response_code(200);
        exit;
    } catch (\Throwable $th) {
        echo json_encode(["msg_error" => "nao consegui pegar o seu IP X_X"]);
        http_response_code(200);
        exit;
    }

    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    echo "<br><br>" . $userAgent;
    ?>
</body>    
</html>


