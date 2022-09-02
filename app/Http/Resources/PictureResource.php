<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PictureResource extends JsonResource
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
        if($this->boat_id != null && $this->adventure_id == null) {
            return [
                'id' => $this->id,
                'boat_id' => $this->boat_id,
                'picture' => asset(Storage::url('boat/'. $this->boat_id . '/' . $this->id . '-' . $this->picture)),
                'is_first' => $this->is_first,
            ];
        } elseif ($this->boat_id == null && $this->adventure_id != null) {
            return [
                'id' => $this->id,
                'adventure_id' => $this->adventure_id,
                'picture' => asset(Storage::url('adventure/'. $this->adventure_id . '/' . $this->id . '-' . $this->picture)),
                'is_first' => $this->is_first,
            ];
        }
        // return [
        //     'id' => $this->id,
        //     'picture' => Storage::url('app/public'),
        // ];
    }
}
