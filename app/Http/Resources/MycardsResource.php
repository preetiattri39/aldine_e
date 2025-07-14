<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MycardsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"      => $this->id,
            "payment" => [
                "id" => $this->payment->id,
                "amount" => $this->payment->amount,
                "user_id" => $this->payment->id,
                "status"  => $this->payment->status
            ],
            "user" => [
                "id" => $this->payment->user->id,
                "first_name" => $this->payment->user->first_name,
                "last_name"  => $this->payment->user->last_name,
                "full_name"  =>  $this->payment->user->full_name,
                "email"  => $this->payment->user->email,
                "status" => $this->payment->user->status,
            ],
            "card" => [
                "id" => $this->card->id,
                "name" => $this->card->name,
                "amount" => $this->card->amount,
                "description" => $this->card->description,
                "image" => $this->card->image,
                "type" => $this->card->type,
                "path" => $this->card->path,
                "status" => $this->card->status,
                "category" => [
                    "id" => $this->card->category->id,
                    "name" => $this->card->category->name,
                    "card_limit" => $this->card->category->card_limit,
                    "status" => $this->card->category->status,
                ]
            ]
        ];
    }
}
