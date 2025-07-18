<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            // 'id' => $this->resource->id,
            'company_id' => $this->resource->company_id,
            // 'name' => $this->resource->name,
            'last_name' => $this->resource->last_name,
            'first_name' => $this->resource->first_name,
            // 'name_kana' => $this->resource->name_kana,
            'last_name_kana' => $this->resource->last_name_kana,
            'first_name_kana' => $this->resource->first_name_kana,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'sex_code' => $this->resource->sex_code,
            'sex_name' => $this->resource->sex_name,
            'sex_label' => $this->resource->sex_label,
            'role_name' => $this->resource->role_name,
            'role_label' => $this->resource->role_label,
            'date_of_birth' => $this->resource->date_of_birth,
            'introducer_code' => $this->resource->introducer_code,
            'profile_photo_url' => $this->resource->profile_photo_url,
            'created_at' => $this->resource->created_at,
            'created_at_formated' => $this->resource->created_at_formated,
            'updated_at' => $this->resource->updated_at,
            'deleted_at_formated' => $this->resource->deleted_at_formated,
            'is_deleted' => $this->resource->is_deleted,
            'is_system_admin' => $this->resource->is_system_admin,
            'is_admin' => $this->resource->is_admin,
            'is_developer' => $this->resource->is_developer,
        ];
    }
}
