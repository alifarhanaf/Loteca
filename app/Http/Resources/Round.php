<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Round extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'status'=>200,
            'response'=> true,
            'data' => [
            'id' => $this->id,
            'name' => $this->name,
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'games' => new GameCollection($this->games),

            ],
            
        ];
    }
}
