<?php

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * @return object file name
     * @var iterable $files
     */
    public function upload(UploadedFile $file, $directory, $slugName): Image
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $imageEntity = new Image();
        $imageEntity->setFile($newFilename);
        $file->move(
            $directory . $slugName,
            $newFilename
        );

        return $imageEntity;
    }
}