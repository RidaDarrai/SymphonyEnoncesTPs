<?php

declare(strict_types=1);

namespace App\File\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class OnServerFileUploader implements FileUploaderInterface
{
    private string $uploadDir;

    public function __construct(ParameterBagInterface $params)
    {
        $this->uploadDir = $params->get('kernel.project_dir') . '/public/uploads';
    }

    public function upload(File $file, string $destination): string
    {
        $file->move($this->uploadDir, $destination);
        return $destination;
    }
}
