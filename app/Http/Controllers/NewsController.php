<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Http\Traits\ApiFormatterTrait;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    use ApiFormatterTrait;

    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $allNews = News::query()->get();

        return $this->success(NewsResource::collection($allNews));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewsRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(StoreNewsRequest $request): JsonResponse
    {
        $response = $this->newsService->store($request);

        return $this->success(new NewsResource($response));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $news = News::query()->findOrFail($id);

        $news->increment('view_count');

        return $this->success(new NewsResource($news));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(UpdateNewsRequest $request, int $id): JsonResponse
    {
        $news = News::query()->findOrFail($id);

        $this->newsService->update($request, $news);

        return $this->success(new NewsResource($news));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $news = News::query()->findOrFail($id);

        $news->delete();

        return $this->success(new NewsResource($news));
    }
}
