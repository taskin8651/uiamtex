<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_create');
    }

    protected function prepareForValidation()
    {
        // These 3 fields come from blade as JSON strings (hidden inputs)
        // Convert them to arrays BEFORE validation.
        $this->merge([
            'pdp_recommended_for_left'  => $this->decodeJsonArrayField('pdp_recommended_for_left'),
            'pdp_recommended_for_right' => $this->decodeJsonArrayField('pdp_recommended_for_right'),
            'pdp_tech_table'            => $this->decodeJsonArrayField('pdp_tech_table'),
        ]);
    }

    private function decodeJsonArrayField(string $key): array
    {
        $val = $this->input($key);

        // If already array, return as-is
        if (is_array($val)) {
            return $val;
        }

        // Empty => return empty array so "array" validation passes (or nullable|array will also pass)
        if ($val === null) {
            return [];
        }

        $val = trim((string) $val);
        if ($val === '') {
            return [];
        }

        $decoded = json_decode($val, true);

        // If JSON invalid or not an array/object => return []
        if (!is_array($decoded)) {
            return [];
        }

        return $decoded;
    }

    public function rules()
    {
        return [
            // your existing required fields
            'select_category_id' => ['required', 'integer'],
            'name'               => ['required', 'string'],
            'slug'               => ['required', 'string'],
            'base_price'         => ['required'],
            'compare_price'      => ['required'],
            'badge'              => ['required'],
            'dispatch_text'      => ['required'],
            'is_featured'        => ['required'],
            'is_active'          => ['required'],

            // optional regular fields
            'short_desc'         => ['nullable', 'string'],
            'description'        => ['nullable', 'string'],
            'rating_avg'         => ['nullable'],
            'rating_count'       => ['nullable'],
            'sku'                => ['nullable', 'string'],

            // media (handled by dropzone)
            'main_image'         => ['nullable'],
            'brochure_pdf'       => ['nullable'],

            // PDP Builder arrays (NOW validation will receive proper arrays)
            'pdp_tags'                  => ['nullable', 'array'],
            'pdp_tags.*'                => ['nullable', 'string'],

            'pdp_pointers'              => ['nullable', 'array'],
            'pdp_pointers.*'            => ['nullable', 'string'],

            'pdp_key_highlights'        => ['nullable', 'array'],
            'pdp_key_highlights.*.icon' => ['nullable', 'string'],
            'pdp_key_highlights.*.title'=> ['nullable', 'string'],
            'pdp_key_highlights.*.text' => ['nullable', 'string'],

            'pdp_works_on'              => ['nullable', 'array'],
            'pdp_works_on.*.icon'       => ['nullable', 'string'],
            'pdp_works_on.*.title'      => ['nullable', 'string'],
            'pdp_works_on.*.text'       => ['nullable', 'string'],

            // ✅ these are the ones causing your error
            'pdp_recommended_for_left'  => ['nullable', 'array'],
            'pdp_recommended_for_left.*'=> ['nullable', 'string'],

            'pdp_recommended_for_right'  => ['nullable', 'array'],
            'pdp_recommended_for_right.*'=> ['nullable', 'string'],

            // ✅ tech table is an object-like array: {columns:[], rows:[]}
            'pdp_tech_table'            => ['nullable', 'array'],
            'pdp_tech_table.columns'    => ['nullable', 'array'],
            'pdp_tech_table.rows'       => ['nullable', 'array'],

            // optional text fields
            'pdp_available_sizes'       => ['nullable', 'string'],
            'pdp_available_variants'    => ['nullable', 'string'],
        ];
    }
}