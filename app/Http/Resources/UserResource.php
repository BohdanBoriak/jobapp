<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'first_name'=> $this->first_name,
            'second_name' => $this->second_name,
            'country' => $this->country,
            'city' => $this->city,
            'phone' => $this->phone,
            'role' => $this->role,
        ];
    }
}
