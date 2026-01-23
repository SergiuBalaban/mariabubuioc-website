<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Furniture' => Category::firstOrCreate(['name' => 'Furniture']),
            'Women Accessories' => Category::firstOrCreate(['name' => 'Women Accessories']),
            'Home Accessories' => Category::firstOrCreate(['name' => 'Home Accessories']),
        ];

        $projects = [
            [
                'title' => 'Rocking chair',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/furniture/rocking_chair/rocking_chair_900x500.jpg',
                'content' => 'This rocking chair is part of the furniture collection Quintessence - a project inspired from Romanian and Moldovian traditional craftsmanship. Together with the designer Mihai Stamati, we set out to research and revalue the old production techniques in order to create a unique collection of furniture responsive to contemporary requisites.',
                'details' => [
                    'MATERIALS' => 'Ash wood, flax yarn',
                    'DIMENSIONS' => '96x63 cm, H86 cm',
                    'PHOTO CREDITS' => 'Igor Rotari, Mihai Stamati',
                    'images' => [
                        '/img/projects/furniture/rocking_chair/rocking_chair_1.jpg',
                        '/img/projects/furniture/rocking_chair/rocking_chair_2.jpg',
                        '/img/projects/furniture/rocking_chair/rocking_chair_3.jpg',
                        '/img/projects/furniture/rocking_chair/rocking_chair_4.jpg',
                        '/img/projects/furniture/rocking_chair/rocking_chair_5.jpg',
                        '/img/projects/furniture/rocking_chair/rocking_chair_6.jpg',
                    ],
                ],
                'price' => '750€',
            ],
            [
                'title' => 'Coffee table',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/furniture/coffee_table/coffee_table_900x500.jpg',
                'content' => 'The coffee table is part of the furniture collection Quintessence - a project inspired from Romanian and Moldovian traditional craftsmanship. Together with the designer Mihai Stamati, we set out to research and revalue the old production techniques.',
                'details' => [
                    'MATERIALS' => 'Ash wood',
                    'DIMENSIONS' => 'D60 cm, H45 cm',
                    'PHOTO CREDITS' => 'Igor Rotari',
                    'images' => [
                        '/img/projects/furniture/coffee_table/coffee_table_1.jpg',
                        '/img/projects/furniture/coffee_table/coffee_table_2.jpg',
                        '/img/projects/furniture/coffee_table/coffee_table_3.jpg',
                        '/img/projects/furniture/coffee_table/coffee_table_4.jpg',
                    ],
                ],
                'price' => '450€',
            ],
            [
                'title' => 'Floor lamp',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/furniture/floor_lamp/floor_lamp_900x500.jpg',
                'content' => 'This floor lamp is part of the furniture collection Quintessence.',
                'details' => [
                    'MATERIALS' => 'Ash wood, linen thread',
                    'DIMENSIONS' => 'H160 cm',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/furniture/floor_lamp/floor_lamp_1.jpg',
                        '/img/projects/furniture/floor_lamp/floor_lamp_2.jpg',
                        '/img/projects/furniture/floor_lamp/floor_lamp_3.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Poof',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/furniture/poof/poofs_900x500.jpg',
                'content' => 'These poofs are part of the furniture collection Quintessence.',
                'details' => [
                    'MATERIALS' => 'Ash wood, wool',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/furniture/poof/poof_1.jpg',
                        '/img/projects/furniture/poof/poof_2.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Reed bench',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/furniture/reed_bench/reed_bench_900x500.jpg',
                'content' => 'The reed bench is inspired by traditional Romanian benches.',
                'details' => [
                    'MATERIALS' => 'Ash wood, reed',
                    'PHOTO CREDITS' => 'Igor Rotari',
                    'images' => [
                        '/img/projects/furniture/reed_bench/reed_bench_1.jpg',
                        '/img/projects/furniture/reed_bench/reed_bench_2.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Crochet jewelry',
                'category_id' => $categories['Women Accessories']->id,
                'cover' => '/img/projects/women_accesories/crochet_collar/crochet_collar_900x500.jpg',
                'content' => 'A collection of crochet jewelry.',
                'details' => [
                    'MATERIALS' => 'Linen, cotton',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/women_accesories/crochet_collar/crochet_collar_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Crochet rug',
                'category_id' => $categories['Home Accessories']->id,
                'cover' => '/img/projects/home_accesories/crochet_rug/crochet_rug_900x500.jpg',
                'content' => 'A handmade crochet rug.',
                'details' => [
                    'MATERIALS' => 'Cotton rope',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/home_accesories/crochet_rug/crochet_rug_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Wine bottle holder',
                'category_id' => $categories['Home Accessories']->id,
                'cover' => '/img/projects/home_accesories/wine_bottler_holders/wine_bottle_holder_900x500.jpg',
                'content' => 'Wine bottle holders made from recycled materials.',
                'details' => [
                    'MATERIALS' => 'Recycled textiles',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/home_accesories/wine_bottler_holders/wine_bottle_holder_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Kitchen textiles',
                'category_id' => $categories['Home Accessories']->id,
                'cover' => '/img/projects/home_accesories/kitchen_textiles/kitchen_textiles_900x500.jpg',
                'content' => 'A set of kitchen textiles.',
                'details' => [
                    'MATERIALS' => 'Linen, cotton',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/home_accesories/kitchen_textiles/kitchen_textiles_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Fruits hanging basket',
                'category_id' => $categories['Home Accessories']->id,
                'cover' => '/img/projects/home_accesories/fruits_hanging_basket/fruit_hanging_basket_900x500.jpg',
                'content' => 'Hanging baskets for fruits.',
                'details' => [
                    'MATERIALS' => 'Jute',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/home_accesories/fruits_hanging_basket/fruit_hanging_basket_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Wooden sideboard',
                'category_id' => $categories['Furniture']->id,
                'cover' => '/img/projects/home_accesories/wooden_sideboard/sideboard_900x500.jpg',
                'content' => 'A wooden sideboard with intricate details.',
                'details' => [
                    'MATERIALS' => 'Ash wood',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'images' => [
                        '/img/projects/home_accesories/wooden_sideboard/sideboard_1.jpg',
                    ],
                ],
            ],
            [
                'title' => 'Christmas trees',
                'category_id' => $categories['Home Accessories']->id,
                'cover' => '/img/projects/home_accesories/christmas_trees/christmas_trees_900x500.jpg',
                'content' => 'A collection of crocheted Christmas trees, made out of bleached linen and yellow cotton.',
                'details' => [
                    'MATERIALS' => 'Linen thread, cotton yarn',
                    'PHOTO CREDITS' => 'Maria Bubuioc',
                    'Shop' => 'etsy',
                    'ShopUrl' => 'https://www.etsy.com/listing/4410820266/decorative-tall-crochet-christmas-trees',
                    'images' => [
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_1.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_2.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_3.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_4.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_5.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_6.jpg',
                        '/img/projects/home_accesories/christmas_trees/christmas_trees_7.jpg',
                    ],
                ],
                'price' => '15$',
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }
    }
}
