<?php

namespace Modules\Actor\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ActorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
         return[
            "id" => $this-> id,
            "name" => $this-> name,
            "gender" => $this-> gender,
            "avatar" => $this-> avatar,
            "movie_id" => $this-> movie_id,
            "created_at" => $this-> created_at,
            "updated_at" => $this-> updated_at,
            "deleted_at" => $this-> deleted_at
         ];
    }
}
