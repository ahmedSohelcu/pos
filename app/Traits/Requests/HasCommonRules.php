<?php

namespace App\Traits\Requests;

trait HasCommonRules
{
    protected function nameRules($max = 100)
    {
        return ['required', 'string', "max:$max"];
    }

    protected function codeRules($table, $ignoreId = null)
    {
        return [
            'required',
            'string',
            "unique:$table,code," . $ignoreId
        ];
    }

    protected function priceRules()
    {
        return ['required', 'numeric', 'min:0'];
    }

    protected function qtyRules()
    {
        return ['required', 'numeric', 'min:0'];
    }

    protected function discountRules()
    {
        return ['nullable', 'numeric', 'min:0'];
    }

    protected function taxRules()
    {
        return ['nullable', 'numeric', 'min:0'];
    }

    protected function phoneRules()
    {
        return ['nullable', 'string', 'max:20'];
    }

    protected function emailRules($ignoreId = null)
    {
        return [
            'nullable',
            'email',
            "unique:customers,email," . $ignoreId
        ];
    }

    protected function statusRules()
    {
        return ['required', 'in:active,inactive'];
    }

    protected function imageRules()
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];
    }
}
