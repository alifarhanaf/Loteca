<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return[
        //     $this->collection->transform(function ( Game $game) {
                // return[
                // 'id' => $this->id,
                // 'name' => $this->name,
                // 'team_a' => $this->team_a,
                // 'team_b' => $this->team_b,
                // 'created_at' => $this->created_at,
                // 'updated_at' => $this->updated_at,

                // ];
            // }),
            
            
            //  ];
        return parent::toArray($request);
    }
}
