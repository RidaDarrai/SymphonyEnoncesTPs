<?php

declare(strict_types=1);

namespace App\File\Uploader\Handler;

use App\File\Uploader\FileUploaderInterface;
use Symfony\Component\HttpFoundation\File\File;

final class FileHandler
{
    public function handle(File $file, FileUploaderInterface $fileUploader): string
    {
        $safeFilename = $this->doGenerateSafeFilename($file);
        return $fileUploader->upload($file, $safeFilename);
    }

    private function doGenerateSafeFilename(File $file): string
    {
        $originalFilename = \pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        return \sprintf('%s-%s.%s', $originalFilename, \uniqid(), $file->guessExtension());
    }
}
