<?php

require 'functions/dd.php';
require_once 'classes/Upload.php';

if (!is_dir('./uploads')) mkdir('./uploads', 0777, true);

$filePath = dirname(__FILE__) . '/uploads/';

if (isset($_FILES['uploadFile'])) {
    $upload = new Upload($_FILES['uploadFile'], $filePath);
    $upload->upload();

    if ($upload->passed()) {
        dd('Arquivo enviado com sucesso.');
    } else {
        $errors = (array)$upload->errors();
    };
}

$errors = $errors ?? null;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de imagens usando PHP</title>
</head>

<body>
    <div style="text-align: center;">
        <h1>Upload de imagens usando PHP</h1>
        <form action="./index.php" method="POST" enctype="multipart/form-data">
            <label for="uploadFile">Selecione o arquivo:</label>
            <input type="file" name="uploadFile" id="uploadFile">
            <input type="submit" value="Upload">
        </form>
    </div>
</body>

</html>