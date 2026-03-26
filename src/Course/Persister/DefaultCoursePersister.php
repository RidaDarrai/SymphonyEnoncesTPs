<?php

declare(strict_types=1);

namespace App\Course\Persister;

use App\Entity\Course;
use App\Repository\CourseRepository;

final readonly class DefaultCoursePersister implements CoursePersisterInterface
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function save(Course $course, bool $isNewEntry = false): void
    {
        $this->courseRepository->save($course);
    }
}
