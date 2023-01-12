<?php

class Upload
{
    private $file, $path, $mimeTypes, $maxSize, $errors;

    public function __construct($file, $path)
    {
        $this->file = $file;
        $this->path = $path;
        $this->mimeTypes = ['image/gif', 'image/jpeg', 'image/png',];
        $this->maxSize = 2097152;
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = $this->rename($this->file);
            $fileTempPath = $this->file['tmp_name'];
            $filePath = $this->path . $fileName;

            if (!move_uploaded_file($fileTempPath, $filePath)) {
                $this->addError('Houve um erro inesperado.');
            }
        }
    }

    private function rename($file)
    {
        $ex = explode('.', $file['name']);
        $name = $this->generateHash('image_') . '.' . end($ex);

        return $name;
    }

    private function generateHash()
    {
        $hash = substr(md5(mt_rand()), 0, 7);

        return $hash;
    }

    private function validate()
    {
        $fileType = mime_content_type($this->file['tmp_name']);
        $fileSize = $this->file['size'];

        if (!in_array($fileType, $this->mimeTypes)) {
            $this->addError('Formato de arquivo inválido.');
        }

        if ($fileSize > $this->maxSize) {
            $this->addError('O tamanho do arquivo excede o permitido.');
        }

        return true;
    }

    private function addError($message)
    {
        $this->errors[] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function passed()
    {
        return (empty($this->errors)) ? true : false;
    }
}
