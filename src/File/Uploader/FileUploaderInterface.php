<?php

declare(strict_types=1);

namespace App\File\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

interface FileUploaderInterface
{
    public function upload(File $file, string $destination): string;
}
