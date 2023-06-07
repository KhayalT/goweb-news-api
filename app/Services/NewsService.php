<?php

namespace App\Services;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Exception;
use Illuminate\Support\Facades\DB;

class NewsService implements INewsService
{
    /**
     * @throws Exception
     */
    public static function store(StoreNewsRequest $request)
    {
        DB::beginTransaction();

        try {
            $translations = $request->get('translations');

            $news = News::query()->create($request->only('title', 'description'));

            foreach ($translations as $translation) {
                $news->translations()->create([
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                    'language_id' => $translation['language_id'],
                ]);
            }

            DB::commit();
            return $news;
        }catch (Exception $th){
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function update(UpdateNewsRequest $request, $news): string
    {
        DB::beginTransaction();

        try {
            $news->update($request->except('translations'));

            $translations = $request->get('translations');

            $news->translations()->delete();

            foreach ($translations as $translation) {
                $news->translations()->create([
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                    'language_id' => $translation['language_id'],
                ]);
            }

            DB::commit();
            return $news;
        }catch (Exception $th){
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
}
