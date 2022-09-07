<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SkipperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'picture' => asset(Storage::url('skipper/'. $this->name . '-' . $this->firstname . '/' . $this->picture)),
            'description_fr' => $this->description_fr,
            'description_en' => $this->description_en,
            'languages' => $this->languages,
        ];
    }
}
