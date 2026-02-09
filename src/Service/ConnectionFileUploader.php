<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ConnectionFileUploader
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function uploadAtoB(UploadedFile $file, int $idA, int $idB): string
    {
        $newFileName = $idA . '_to_' . $idB . '.' . $file->guessExtension();
        $file->move($this->targetDirectory, $newFileName);

        return $newFileName;
    }
    
    public function uploadBtoA(UploadedFile $file, int $idB, int $idA): string
    {
        $newFileName = $idB . '_to_' . $idA . '.' . $file->guessExtension();
        $file->move($this->targetDirectory, $newFileName);

        return $newFileName;
    }
}