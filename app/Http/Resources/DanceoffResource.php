<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DanceoffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'winner' => $this->winner,
            'loser' => $this->loser,
            'dancedAt' => $this->created_at,
        ];
    }
}
