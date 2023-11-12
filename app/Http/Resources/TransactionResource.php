<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_description' => $this->transaction_description,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'amount' => number_format($this->amount, 2),
            'transaction_date' => $this->transaction_date,
            'created_at' => $this->created_at
        ];
    }
}
