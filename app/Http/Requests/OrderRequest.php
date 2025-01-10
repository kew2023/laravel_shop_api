<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'date', // Обязательно, должно быть корректной датой
            'is_processed' => 'boolean', // Булево значение
            'total' => 'numeric|min:0', // Число с минимумом 0
            'payment_status' => 'string|in:НеОплачен,Оплачен,ЧастичноОплачен', // Ограничение по статусам оплаты
            'status' => 'exists:document_statuses,guid', // Ссылка на существующий статус
            'delivery_method' => 'nullable|string|max:36', // Необязательное поле, строка до 36 символов
            'delivery_date' => 'nullable|date', // Необязательное поле, корректная дата
            'delivery_address' => 'nullable|string|max:255', // Необязательное поле, строка
            'delivery_company' => 'nullable|string|max:255', // Необязательное поле, строка
            'contact_name' => 'nullable|string|max:255', // Необязательное поле, строка
            'contact_phone' => 'nullable|string|max:255', // Необязательное поле, строка
            'website_comment' => 'nullable|string|max:255', // Необязательное поле, строка
            'website_comment_for_client' => 'nullable|string|max:255', // Необязательное поле, строка
            'latest_update_by_client' => 'date', // Обязательно, корректная дата
            'payment_type' => 'string|in:Наличная,Безналичная', // Обязательно, должно быть указано
            'is_delivery_today' => 'required|boolean', // Обязательно, булево значение
            'created_by' => 'exists:users,id', // Ссылка на существующего пользователя
        ];
    }
}
