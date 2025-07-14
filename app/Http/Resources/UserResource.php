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
            'id'            => $this->id,  
            'name'          => $this->first_name.' '.$this->last_name,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
             'country'         => $this->country,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'plan_type'     => $this->plan_type,
            'theme'         => $this->theme ? $this->theme :  null,
            'profile'       => ($this->userDetail && $this->userDetail->profile) ? $this->userDetail->profile : null,
            'phone_number'  => ($this->userDetail && $this->userDetail->phone_number) ? $this->userDetail->phone_number : null,
            'address'       => ($this->userDetail && $this->userDetail->address) ? $this->userDetail->address : null,
            'zip_code'      => ($this->userDetail && $this->userDetail->zip_code) ? $this->userDetail->zip_code : null,
            'gender'        => ($this->userDetail && $this->userDetail->gender) ? $this->userDetail->gender : null,
            'country_code'      => ($this->userDetail && $this->userDetail->country_code) ? $this->userDetail->country_code : null,
            'country_short_code'=> ($this->userDetail && $this->userDetail->country_short_code) ? $this->userDetail->country_short_code : null,
            'dob'               => ($this->userDetail && $this->userDetail->dob) ? $this->userDetail->dob : null,
        ];
    }
}
