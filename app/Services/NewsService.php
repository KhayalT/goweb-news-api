<?php

namespace App\Services;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

class NewsService implements INewsService
{
    public static function store(StoreNewsRequest $request): string
    {

    }

    public static function update(UpdateNewsRequest $request, $news): string
    {

    }
}
