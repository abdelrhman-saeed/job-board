<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string',
            'location'      => 'nullable|string',
            'description'   => 'nullable|string',
            'min_salary'    => 'nullable|decimal:0,10|min:0',
            'max_salary'    => 'nullable|decimal:0,10|min:0',
            'is_remote'     => 'nullable|boolean',
            'publish'       => 'nullable|boolean',
        ];
    }

  public function validated($key = null, $default = null): array
  {
    $validated = parent::validated($key, $default);

    if (isset($validated['publish']) && $validated['publish']) {

        unset($validated['publish']);
        $validated['published_at'] = now();
    }

    return $validated;
  }
}
