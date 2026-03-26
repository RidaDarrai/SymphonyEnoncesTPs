<?php

declare(strict_types=1);

namespace App\Course\Fetcher;

use App\Entity\Course;
use App\Repository\CourseRepository;

final class DefaultCourseFetcher implements CourseFetcherInterface
{
    public function __construct(private CourseRepository $courseRepository)
    {
    }

    public function fetchAllCourses(): array
    {
        return $this->courseRepository->findAll();
    }

    public function fetchCourse(int $id): ?Course
    {
        return $this->courseRepository->find($id);
    }
}
