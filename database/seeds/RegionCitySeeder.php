<?php

use Illuminate\Database\Seeder;
use App\Region;
use App\ProductCategory;
// use App\City;

class RegionCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
        $regions = ['Ashanti','Brong Ahafo','','Central','Eastern','Western','Northern','Volta','Upper East','Upper West'];

        $cities = ['Kumasi','Sunyani','Accra','Cape Coast','Koforidua','Seckondi Takoradi','Tamale','Ho','Bolgatanga','Wa'];

        foreach ($regions as $key => $name) {
            $region = Region::create(['name'=>$name]);
            $region->cities()->create(['name'=>$cities[$key]]);
        }

        // $categories = ['Cloth','Suit','Necklace','Bracelets','Beads','Kante','Fabrics','Designer','Seller','Fugu','Craft & Art'];

        // foreach ($categories as $key => $name) {
        //     $slug = str_slug($name, '-');
        //     $url = 'product/'.$slug;
        //     ProductCategory::create(['name'=>$name,'slug'=>$slug]);
        // }

    }
}
