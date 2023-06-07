<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Http\Traits\ApiFormatterTrait;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    use ApiFormatterTrait;

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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        //
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

        return $this->success(new NewsResource($news));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $news = News::query()->findOrFail($id);

        $news->update($request->all());
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
