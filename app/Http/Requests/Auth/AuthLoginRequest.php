<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AuthLoginRequest
 * @package App\Http\Requests
 */
class AuthLoginRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string'
        ];
    }
}
