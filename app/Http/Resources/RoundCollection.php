<?php

namespace App\Http\Resources;

use App\Http\Resources\GameCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoundCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
     
        $this->collection->transform(function (Round $round) {
            return [
                
                'id' => $round->id,
                'name' => $round->name,
                'starting_date' => $round->starting_date,
                'ending_date' => $round->ending_date,
                'created_at' => $round->created_at,
                'updated_at' => $round->updated_at,
                'games' => new GameCollection($round->games),

            ];
        }),
    ];

        // return parent::toArray($request);
    
        // return[
        // 'status' => 200,
        // 'response' => true,
        // 'data' => $this->collection,
        
        // ];
    }
}
