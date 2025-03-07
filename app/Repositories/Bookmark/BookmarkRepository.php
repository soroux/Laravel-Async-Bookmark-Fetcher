<?php

namespace App\Repositories\Bookmark;

use App\Models\Bookmark;
use App\Repositories\BaseRepository;

class BookmarkRepository extends BaseRepository implements BookmarkRepositoryInterface
{
    public function __construct(Bookmark $model)
    {
        parent::__construct($model);
    }
}
