<?php

namespace Modules\AttributeValue\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\AttributeValue\Entities\AttributeValue;
class AttributeValueDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributeIDs = DB::table('attributes')->pluck('id')->toArray();
        foreach ($attributeIDs as $attributeId) {
            $attribute = DB::table('attributes')->where('id', $attributeId)->first();

            switch ($attribute->name) {
                case 'Image':
                    DB::table('attribute_value')->insert([
                        ['attribute_id' => $attribute->id, 'value' => 'https://hoanghamobile.com/tin-tuc/wp-content/webp-express/webp-images/uploads/2023/07/hinh-dep.jpg.webp', 'created_at' => now(), 'updated_at' => now()],
                        ['attribute_id' => $attribute->id, 'value' => 'https://hoanghamobile.com/tin-tuc/wp-content/webp-express/webp-images/uploads/2023/07/hinh-dep-2.jpg.webp', 'created_at' => now(), 'updated_at' => now()],
                        ['attribute_id' => $attribute->id, 'value' => 'https://hoanghamobile.com/tin-tuc/wp-content/webp-express/webp-images/uploads/2023/07/hinh-dep-3-1.jpg.webp', 'created_at' => now(), 'updated_at' => now()],
                        ['attribute_id' => $attribute->id, 'value' => 'https://hoanghamobile.com/tin-tuc/wp-content/webp-express/webp-images/uploads/2023/07/hinh-dep-4.jpg.webp', 'created_at' => now(), 'updated_at' => now()],
                    ]);
                    break;

                case 'Trailer':
                    DB::table('attribute_value')->insert([
                        ['attribute_id' => $attribute->id, 'value' => 'https://www.youtube.com/embed/_OKAwz2MsJs']
                    ]);
                    break;

                case 'Rating':
                    DB::table('attribute_value')->insert([
                        ['attribute_id' => $attribute->id, 'value' => '4','created_at' => now(), 'updated_at' => now()]
                    ]);
                    break;

                case 'Languge':
                    DB::table('attribute_value')->insert([
                        ['attribute_id' => $attribute->id, 'value' => 'english', 'created_at' => now(), 'updated_at' => now()],
                        ['attribute_id' => $attribute->id, 'value' => 'vietnamese', 'created_at' => now(), 'updated_at' => now()],
                    ]);
                    break;
            }
        }
    }
}
