<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                Order::STATUS_PENDING,
                Order::STATUS_PREPARING,
                Order::STATUS_READY,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
            ])],
            'fulfillment_method' => ['required', Rule::in([
                Order::FULFILLMENT_DELIVERY,
                Order::FULFILLMENT_PICKUP,
            ])],
            'delivery_location' => ['nullable', 'string', 'max:120'],
        ];
    }
}
