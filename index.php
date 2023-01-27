<?php

require 'functions/dd.php';
require_once 'classes/Upload.php';

if (!is_dir('./uploads')) {
    mkdir('./uploads', 0777, true);
}

$filePath = dirname(__FILE__) . '/uploads/';

if (
    isset($_FILES['uploadFile'])
) {
    if ($_FILES['uploadFile']['name'] != '') {
        $upload = new Upload($_FILES['uploadFile'], $filePath);
        $upload->upload();

        if ($upload->passed()) {
            $success = 'Arquivo enviado com sucesso!';
        } else {
            $errors = (array)$upload->errors();
        }
    } else {
        $errors = (array)'Selecione um arquivo para fazer upload.';
    }
}

$success = $success ?? null;
$errors = $errors ?? null;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de imagens usando PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="mx-auto w-50 mt-5 mb-5">
        <div class="card">
            <div class="card-body">
                <h2>Upload de imagens usando PHP</h2>
                <form action="./index.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="uploadFile" class="form-label">Selecione o arquivo:</label>
                        <input type="file" name="uploadFile" id="uploadFile" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" value="Fazer upload" class="btn btn-primary">
                    </div>
                </form>
                <?php
                if (!is_null($success)) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?= $success ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if (!is_null($errors)) {
                    foreach ($errors as $error) {
                ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error ?>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
