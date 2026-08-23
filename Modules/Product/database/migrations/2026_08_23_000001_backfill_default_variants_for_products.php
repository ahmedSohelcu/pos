<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Every product must have at least one variant.
     * Backfill a default variant for products without any
     * (single / service / legacy data).
     */
    public function up(): void
    {
        DB::statement("
            INSERT INTO product_variants (tenant_id, product_id, name, sku, barcode, purchase_price, sale_price, stock, created_at, updated_at)
            SELECT
                p.tenant_id,
                p.id,
                p.name,
                p.sku,
                p.barcode,
                COALESCE(p.purchase_price, 0),
                COALESCE(p.sale_price, 0),
                CASE WHEN p.product_type = 'service' THEN 0 ELSE COALESCE(p.stock, 0) END,
                NOW(),
                NOW()
            FROM products p
            WHERE NOT EXISTS (
                SELECT 1 FROM product_variants v WHERE v.product_id = p.id
            )
        ");
    }

    public function down(): void
    {
        DB::statement("
            DELETE v FROM product_variants v
            INNER JOIN products p ON p.id = v.product_id
            WHERE p.product_type <> 'variant'
              AND v.name <=> p.name
              AND v.sku <=> p.sku
        ");
    }
};
