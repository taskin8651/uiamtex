<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_edit');
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'pdp_recommended_for_left'  => $this->decodeJsonArrayField('pdp_recommended_for_left'),
            'pdp_recommended_for_right' => $this->decodeJsonArrayField('pdp_recommended_for_right'),
            'pdp_tech_table'            => $this->decodeJsonArrayField('pdp_tech_table'),
        ]);
    }

    private function decodeJsonArrayField(string $key): array
    {
        $val = $this->input($key);

        if (is_array($val)) {
            return $val;
        }

        if ($val === null) {
            return [];
        }

        $val = trim((string) $val);
        if ($val === '') {
            return [];
        }

        $decoded = json_decode($val, true);

        if (!is_array($decoded)) {
            return [];
        }

        return $decoded;
    }

    public function rules()
    {
        return [
            'select_category_id' => ['required', 'integer'],
            'name'               => ['required', 'string'],
            'slug'               => ['required', 'string'],
            'base_price'         => ['required'],
            'compare_price'      => ['required'],
            'badge'              => ['required'],
            'dispatch_text'      => ['required'],
            'is_featured'        => ['required'],
            'is_active'          => ['required'],

            'short_desc'         => ['nullable', 'string'],
            'description'        => ['nullable', 'string'],
            'rating_avg'         => ['nullable'],
            'rating_count'       => ['nullable'],
            'sku'                => ['nullable', 'string'],

            'main_image'         => ['nullable'],
            'brochure_pdf'       => ['nullable'],

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

            // ✅ error fields
            'pdp_recommended_for_left'   => ['nullable', 'array'],
            'pdp_recommended_for_left.*' => ['nullable', 'string'],

            'pdp_recommended_for_right'   => ['nullable', 'array'],
            'pdp_recommended_for_right.*' => ['nullable', 'string'],

            'pdp_tech_table'             => ['nullable', 'array'],
            'pdp_tech_table.columns'     => ['nullable', 'array'],
            'pdp_tech_table.rows'        => ['nullable', 'array'],

            'pdp_available_sizes'        => ['nullable', 'string'],
            'pdp_available_variants'     => ['nullable', 'string'],
        ];
    }
}