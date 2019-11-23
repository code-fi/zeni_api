<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
// use App\City;

class CategorySeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        $categories = ['Cloth','Suit','Necklace','Bracelets','Beads','Kante','Fabrics','Designer','Seller','Fugu','Craft & Art'];

        foreach ($categories as $key => $name) {
            $slug = str_slug($name, '-');
            $url = 'product/'.$slug;
            ProductCategory::create(['name'=>$name,'url'=>$url,'slug'=>$slug]);
        }

    }
}
