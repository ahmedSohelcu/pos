<?php

namespace Modules\Attribute\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attribute\app\Models\Attribute;
use Modules\Attribute\app\Models\AttributeValue;
use Illuminate\Support\Str;
use Modules\Tenant\app\Models\Tenant;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            'Size' => ['S','M','L','XL'],

            'Color' => ['Red','Blue','Green','Black','White'],

            'Weight' => ['250g','500g','1kg','2kg'],

            'Volume' => ['250ml','500ml','1L','2L'],

        ];

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {

            foreach ($data as $attributeName => $values) {

                $attribute = Attribute::where('tenant_id',$tenant->id)
                    ->where('slug', Str::slug($attributeName))
                    ->first();

                if (!$attribute) {
                    continue;
                }

                foreach ($values as $value) {

                    AttributeValue::firstOrCreate([
                        'tenant_id' => $tenant->id,
                        'attribute_id' => $attribute->id,
                        'slug' => Str::slug($value),
                    ],[
                        'value' => $value,
                    ]);

                }
            }

        }

    }
}
