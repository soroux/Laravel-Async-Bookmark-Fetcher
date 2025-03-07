<?php

namespace App\Services\Api\V1;

use App\Jobs\ProcessRabbitMQMessage;
use App\Models\Bookmark;
use App\Repositories\Bookmark\BookmarkRepositoryInterface;
use Illuminate\Support\Collection;

readonly class BookmarkService
{
    public function __construct(private BookmarkRepositoryInterface $bookmarkRepository)
    {

    }


    /**
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->bookmarkRepository->list();
    }

    public function create(string $url): Bookmark
    {
        $bookmark = $this->bookmarkRepository->create([
            'url' => $url,
        ]);
        $data = [
            'id' => $bookmark->id,
            'timestamp' => now(),
        ];
        ProcessRabbitMQMessage::dispatch($data);

        return $bookmark;
    }

    public function delete(string $bookmarkId): void
    {
        $this->bookmarkRepository->deleteById($bookmarkId);
    }

}
