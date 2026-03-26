<?php

declare(strict_types=1);

namespace App\Course\Fetcher;

use App\Entity\Course;

interface CourseFetcherInterface
{
    /**
     * @return Course[]
     */
    public function fetchAllCourses(): array;

    /**
     * @param int $id
     * @return Course|null
     */
    public function fetchCourse(int $id): ?Course;
}
