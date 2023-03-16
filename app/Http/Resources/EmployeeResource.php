<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'age' => $this->age,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'role' => $this->role,
            'team' => $this->team,
            'is_verified' => $this->is_verified,
            'verified_at' => $this->verified_at
        ];
    }
}
