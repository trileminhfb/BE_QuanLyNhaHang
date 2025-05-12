<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'phoneNumber' => $this->phoneNumber,
            'mail' => $this->mail,
            'birth' => optional($this->birth)->format('Y-m-d'),
            'FullName' => $this->FullName,
            'image' => $this->image,
            'otp' => $this->otp,
            'point' => $this->point,
            'id_rank' => $this->id_rank,
            'isActive' => $this->isActive,
            'rank' => $this->whenLoaded('rank'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
