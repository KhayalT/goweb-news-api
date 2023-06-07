<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property boolean $status
 * @property integer $view_count
 * @property \DateTime $created_at
 */
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'view_count' => $this->view_count,
            'created_at' => $this->created_at->diffForHumans(),
            'translations' => $this->translations
        ];
    }
}
