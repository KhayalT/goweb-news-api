<?php

namespace App\Services;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;

interface INewsService
{
    public static function store(StoreNewsRequest $request);

    public static function update(UpdateNewsRequest $request, $news);
}
