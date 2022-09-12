<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateStreamRequest
 * @package App\Http\Requests
 */
class UpdateStreamRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name'       => 'string',
            'description' => 'string',
            'preview'     => 'image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
