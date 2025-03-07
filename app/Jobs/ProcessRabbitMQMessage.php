<?php

namespace App\Jobs;

use App\Repositories\Bookmark\BookmarkRepositoryInterface;
use DOMDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessRabbitMQMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private BookmarkRepositoryInterface $bookmarkRepository;

    public function __construct(protected array $data)
    {
        $this->bookmarkRepository = resolve(BookmarkRepositoryInterface::class);
    }

    public function handle()
    {
        try {
            $bookmark = $this->bookmarkRepository->findById($this->data['id']);

            if (!$bookmark) {
                Log::warning("Bookmark with ID {$this->data['id']} not found.");
                return;
            }

            $response = Http::retry(2)->get($bookmark->url);

            if ($response->failed()) {
                Log::error("Failed to fetch URL {$bookmark->url} for bookmark ID {$bookmark->id}");
                return;
            }

            $metadata = $this->extractMetadataFromHtml($response->body());

            $this->bookmarkRepository->update($bookmark->id, $metadata);

            Log::info("Successfully updated bookmark ID {$bookmark->id} with new metadata.");

        } catch (\Throwable $e) {
            Log::error("An error occurred while processing the message: {$e->getMessage()}", [
                'data' => $this->data,
                'exception' => $e
            ]);
        }
    }

    private function extractMetadataFromHtml(string $html): array
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $title = $doc->getElementsByTagName('title')->item(0)?->textContent ?? null;
        $description = $this->getMetaDescription($doc);

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    private function getMetaDescription(DOMDocument $doc): ?string
    {
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            if ($meta->getAttribute('name') === 'description') {
                return $meta->getAttribute('content');
            }
        }
        return null;
    }
}
