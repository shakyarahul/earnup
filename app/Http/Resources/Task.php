<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'negotiable' => $this->negotiable,
            'pay' => $this->pay,
            'jobname' => $this->jobname,
            'jobdescription' => $this->jobdescription,
            'skillrequired' => $this->skillrequired,
            'email' => $this->user->email,
            'location' => $this->user->location
        ];
    }
}
