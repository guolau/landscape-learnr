<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SnippetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body_html' => 'string|max:65500',

            'images' => 'array|max:10',
            'images.*.id' => 'nullable|numeric|exists:images',
            'images.*.file_input.file' => 'nullable|file|max:512|mimes:jpeg,png,gif',
            'images.*.file_input.action' => 'nullable|string|in:create,delete',
            'images.*.alt_text' => 'nullable|string|max:150',
            'images.*.attribution' => 'nullable|string|max:250',
            'images.*.source_url' => 'nullable|url|max:500',
            'images.*.license' => 'nullable|string|max:50|required_with:images.*.license_url',
            'images.*.license_url' => 'nullable|url|max:500|required_with:images.*.license',
            
            'street_view_links' => 'array|max:10',
            'street_view_links.*.id' => 'nullable|numeric|exists:street_view_links',
            'street_view_links.*.title' => 'nullable|required_with:street_view_links.*.url|string|max:100',
            'street_view_links.*.url' => 'nullable|required_with:street_view_links.*.title|url|max:550',

            'tags' => 'array|max:20',
            'tags.*' => 'string|max:50',

            'is_revised' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'body_html' => 'body',

            'images.*.file' => 'image',
            'images.*.alt_text' => 'alt text',
            'images.*.attribution' => 'attribution',
            'images.*.source_url' => 'source URL',
            'images.*.license' => 'license',
            'images.*.license_url' => 'license URL',

            'street_view_links.*.title' => 'link title',
            'street_view_links.*.url' => 'link URL',

            'tags.*' => 'tag',
        ];
    }
}
