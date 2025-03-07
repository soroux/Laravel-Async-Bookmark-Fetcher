<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateBookmarkRequest;
use App\Services\Api\V1\BookmarkService;
use Illuminate\Http\JsonResponse;

class BookmarkController extends Controller
{
    public function __construct(private readonly BookmarkService $bookmarkService)
    {

    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $bookmarks = $this->bookmarkService->list();
        return ApiResponse::success($bookmarks, 'Bookmark List');
    }

    /**
     * @param CreateBookmarkRequest $request
     * @return JsonResponse
     */
    public function store(CreateBookmarkRequest $request): JsonResponse
    {
        $bookMark = $this->bookmarkService->create($request->input('url'));
        return ApiResponse::success($bookMark, 'Bookmark Created');
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->bookmarkService->delete($id);
        ApiResponse::success(null, 'Bookmark Deleted');;
    }
}
