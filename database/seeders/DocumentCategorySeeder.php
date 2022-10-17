<?php

namespace Database\Seeders;

use App\Models\Core\DocumentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentCategory::create(['name' => 'Assurance', "slug" => Str::slug("Assurance")]);
        DocumentCategory::create(['name' => 'Comptes', "slug" => Str::slug("Comptes")]);
        DocumentCategory::create(['name' => 'Contrats', "slug" => Str::slug("Contrats")]);
        DocumentCategory::create(['name' => 'Epargnes', "slug" => Str::slug("Epargnes")]);
        DocumentCategory::create(['name' => 'Courriers', "slug" => Str::slug("Courriers")]);
    }
}
