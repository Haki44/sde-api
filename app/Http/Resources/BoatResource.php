<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
            // 'id' => $this->id,
            // 'pictures' => [
                // "id" => $this->pictures['id'],
                // "boat_id" => $this->pictures['boat_id'],
                // "picture" => $this->picture['picture'],
                // "is_first" => $this->picture['is_first'],
                // "adventure_id" => $this->picture['adventure_id'],
                // 'id' => $this->emoji['id'],
                // 'name' => $this->emoji['name'],
                // 'emoji' => $this->emoji['emoji'],
            // ]
        // ];
    }
}
