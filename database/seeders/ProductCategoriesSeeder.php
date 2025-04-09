<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Proizvodi i sirovine' => [
                'Voće i povrće',
                'Žitarice i mahunarke',
                'Mlečni proizvodi',
                'Jaja i med',
                'Mesni proizvodi',
                'Prerađevine i zimnica',
                'Začinsko bilje i čajevi',
                'Organska hrana',
                'Pakovani proizvodi (domaći brendovi)',
            ],
            'Sadni materijal i seme' => [
                'Voćne sadnice',
                'Povrtarsko seme',
                'Cveće i ukrasne biljke',
                'Vinova loza i lozni kalemovi',
                'Žitarice i stočna hrana',
            ],
            'Poljoprivredna mehanizacija' => [
                'Traktori',
                'Priključne mašine',
                'Kombajni',
                'Motokultivatori',
                'Pumpe i sistemi za navodnjavanje',
                'Sitna oprema',
                'Delovi i oprema za mehanizaciju',
            ],
            'Životinje i stočarstvo' => [
                'Stoka',
                'Pčele i pčelarska oprema',
                'Živina',
                'Kunići i druge sitne životinje',
                'Hrana i dodaci za životinje',
            ],
            'Oprema i alati' => [
                'Plastenici i oprema',
                'Sistemi za navodnjavanje',
                'Baštenska oprema',
                'Električni i ručni alati',
                'Rezervni delovi',
            ],
            'Zaštita bilja i đubriva' => [
                'Pesticidi i herbicidi',
                'Prirodna zaštitna sredstva',
                'Mineralna i organska đubriva',
                'Folijarna ishrana i stimulatori rasta',
            ],
        ];

        foreach ($categories as $main => $subs) {
            $parent = ProductCategory::create(['name' => $main]);

            foreach ($subs as $sub) {
                ProductCategory::create([
                    'name' => $sub,
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
