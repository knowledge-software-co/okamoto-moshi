<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Enums\Models\User\RoleType;

class UserStoreRequest extends FormRequest
{
    protected $errorBag = 'adminUserStore';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool|\Illuminate\Auth\Access\Response
    {
        return Gate::authorize('create', [User::class, auth()->user()]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(RoleType::values())],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                // 'regex:/^(?=.*?[0-9])(?=.*?[a-zA-Z])[A-Za-z!-9@_]{8,}$/',
                'max:255',
                'confirmed' // フィールド名＋_confirmationフィールドと同じ値であることをバリデート
            ],
            // 'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            // 'name_kana' => ['required', 'katakana', 'max:255'],
            'last_name_kana' => ['required', 'katakana', 'max:255'],
            'first_name_kana' => ['required', 'katakana', 'max:255'],
            // 'company_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'japan_phone'],
            'date_of_birth' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],

            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_branch_name' => ['nullable', 'string', 'max:255'],
            'bank_account_holder_type_code' => ['nullable', 'in:1,2'],
            'bank_account_number' => ['nullable', 'string', 'max:255'],
            'bank_account_holder_name' => ['nullable', 'string', 'max:255'],

            'introducer_code' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'password.regex' => '半角英数字、大文字小文字、各1つずつ含む必要があります。',
            'phone.japan_phone' => '電話番号はハイフンなしの半角数字で入力してください。',
            'name_kana.katakana' => 'カタカナで入力してください。',
        ];
    }

    /**
     * Set custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'role' => '役割',

            'email' => 'メールアドレス',
            'password' => 'パスワード',
            // 'name' => '名前',
            'last_name' => '姓',
            'first_name' => '名',
            // 'name_kana' => '名前（カナ）',
            'last_name_kana' => '姓（カナ）',
            'first_name_kana' => '名（カナ）',
            // 'company_name' => '会社名',
            'phone' => '電話番号',
            'date_of_birth' => '生年月日',

            'bank_name' => '銀行名',
            'bank_branch_name' => '銀行支店名',
            'bank_account_holder_type_code' => '口座種別',
            'bank_account_number' => '口座番号',
            'bank_account_holder_name' => '口座名義',
        ];
    }

    /**
     * makeUser
     */
    public function makeUser(): User
    {
        // バリデーションした値で埋めた User を取得
        return new User($this->validated());
    }
}
