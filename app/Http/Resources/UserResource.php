<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'code_name' => $this->code_name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'password' => $this->password,
            'created_at' => $this->created_at,
            'token' => $this->createToken('test')->accessToken,
        ];
    }
}
