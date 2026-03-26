<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Course;

class CourseRepository
{
    private array $courses = [];
    private int $nextId = 1;
    private string $storageFile;

    public function __construct()
    {
        $this->storageFile = dirname(__DIR__, 2) . '/var/data/courses.json';
        $this->load();
    }

    private function load(): void
    {
        if (file_exists($this->storageFile)) {
            $data = json_decode(file_get_contents($this->storageFile), true);
            $this->courses = [];
            foreach ($data['courses'] ?? [] as $item) {
                $course = new Course();
                $course->setTitle($item['title']);
                $course->setSummary($item['summary']);
                $course->setFilePath($item['filePath']);
                $course->setId($item['id']);
                $this->courses[$item['id']] = $course;
            }
            $this->nextId = $data['nextId'] ?? 1;
        }
    }

    private function persist(): void
    {
        $dir = dirname($this->storageFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $data = [
            'courses' => [],
            'nextId' => $this->nextId,
        ];
        foreach ($this->courses as $id => $course) {
            $data['courses'][] = [
                'id' => $id,
                'title' => $course->getTitle(),
                'summary' => $course->getSummary(),
                'filePath' => $course->getFilePath(),
            ];
        }
        file_put_contents($this->storageFile, json_encode($data));
    }

    public function save(Course $entity): void
    {
        if ($entity->getId() === null) {
            $entity->setId($this->nextId++);
            $this->courses[$entity->getId()] = $entity;
        }
        $this->persist();
    }

    /**
     * @return Course[]
     */
    public function findAll(): array
    {
        return array_values($this->courses);
    }

    public function find(int $id): ?Course
    {
        return $this->courses[$id] ?? null;
    }
}
