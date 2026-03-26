<?php

declare(strict_types=1);

namespace App\DTO;

class Pagination
{
    public int $page = 1;
    public int $limit = 10;
}
