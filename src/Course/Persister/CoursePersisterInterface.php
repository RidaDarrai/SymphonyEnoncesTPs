<?php

declare(strict_types=1);

namespace App\Course\Persister;

use App\Entity\Course;

interface CoursePersisterInterface
{
    public function save(Course $course, bool $isNewEntry = false): void;
}
