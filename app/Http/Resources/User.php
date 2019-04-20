<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'location' => $this->location,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'skills' => $this->skills,
            'profilePic' => $this->profilePic
        ];
    }
}