<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Hempcrete house - our experience',
                'author' => 'Maria Bubuioc',
                'cover' => '/img/blog/hempcrete_house/hempcrete_house_header.jpg',
                'details' => [
                    'description' => 'Cunoscând îndeaproape beneficiile construcțiilor din materiale naturale, ne-am avântat în construirea unei case din “beton de cânepă”. Betonul de cânepă, sau hempcrete cum mai este numit, are proprietăți deosebite: este un bun izolator termic, poate regla umiditatea relativă a aerului, este rezistent în mod natural la igrasie și mucegai...',
                    'date' => '2023',
                    'category' => 'House',
                    'content_ro' => '<p>Cunoscând îndeaproape beneficiile construcțiilor din materiale naturale, ne-am avântat în construirea unei case din “beton de cânepă”.</p>',
                    'content_en' => '<p>Knowing closely the benefits of constructions from natural materials, we ventured into building a "hemp concrete" house.</p>',
                ],
                'content' => '<p>Cunoscând îndeaproape beneficiile construcțiilor din materiale naturale, ne-am avântat în construirea unei case din “beton de cânepă”.</p><p>Knowing closely the benefits of constructions from natural materials, we ventured into building a "hemp concrete" house.</p>',
            ],
            [
                'title' => 'Behind the scene // Kitchen accessories',
                'author' => 'Maria Bubuioc',
                'cover' => '/img/blog/making_off_kitchen/making_off_kitchen_header.jpg',
                'details' => [
                    'description' => 'Pornind de la bucăți de materiale rămase de la proiectul anterior - Quintessence, dar și din nevoia proprie de a-mi echipa bucătăria, am început să creez niște piese textile.',
                    'date' => '2022',
                    'category' => 'House',
                    'content_ro' => '<p>Pornind de la bucăți de materiale rămase de la proiectul anterior - Quintessence...</p>',
                    'content_en' => '<p>Starting from pieces of materials left over from the previous project - Quintessence...</p>',
                ],
                'content' => '<p>Pornind de la bucăți de materiale rămase de la proiectul anterior - Quintessence...</p><p>Starting from pieces of materials left over from the previous project - Quintessence...</p>',
            ],
            [
                'title' => 'Behind the scene // Quintessence project',
                'author' => 'Maria Bubuioc',
                'cover' => '/img/blog/articol_1/articol_1_1.jpg',
                'details' => [
                    'description' => 'Intrigaţi de “Appel [-ul] à pojets” lansat de către Bienale Internationale Design Saint Etienne 2017, ne-am inscris cu un proiect ce abia se contura pe atunci - o colecţie de mobilier inspirată din tehnici tradiţionale şi materiale locale.',
                    'date' => '13 July 2017',
                    'category' => 'Furniture',
                    'content_ro' => '<p>Intrigaţi de “Appel [-ul] à pojets” lansat de către Bienale Internationale Design Saint Etienne 2017, ne-am inscris cu un proiect ce abia se contura pe atunci - o colecţie de mobilier inspirată din tehnici tradiţionale şi materiale locale.</p><p>Tema generală a ediţiei din anul acesta a Bienalei - <i>Les mutations du travail</i>, se potrivea conceptului de mobilier pe care doream să-l creăm. Secţiunea la care ne-am înscris, <i>Rue de la Republique du Design</i>, invita designerii să ocupe spaţiile comerciale inactive de pe o stradă din centrul oraşului Saint Etienne.</p>',
                    'content_en' => '<p>Intrigued and motivated by the “Call for entries” for the Saint Etienne International Design Biennale of 2017, we submitted a project of our own, that was still in an early phase during that time, and which had been inspired by traditional techniques and local materials.</p><p>The central theme of this year\'s edition - <i>Les mutations du travail</i>, suited the concept of the furniture that we wanted to create.</p>',
                    'images' => [
                        '/img/blog/articol_1/articol_1_2.jpg',
                        '/img/blog/articol_1/articol_1_3.jpg',
                        '/img/blog/articol_1/articol_1_4.jpg',
                    ],
                ],
                'content' => '<p>Intrigaţi de “Appel [-ul] à pojets” lansat de către Bienale Internationale Design Saint Etienne 2017, ne-am inscris cu un proiect ce abia se contura pe atunci - o colecţie de mobilier inspirată din tehnici tradiţionale şi materiale locale.</p><p>Tema generală a ediţiei din anul acesta a Bienalei - <i>Les mutations du travail</i>, se potrivea conceptului de mobilier pe care doream să-l creăm. Secţiunea la care ne-am înscris, <i>Rue de la Republique du Design</i>, invita designerii să ocupe spaţiile comerciale inactive de pe o stradă din centrul oraşului Saint Etienne.</p><p>Intrigued and motivated by the “Call for entries” for the Saint Etienne International Design Biennale of 2017, we submitted a project of our own, that was still in an early phase during that time, and which had been inspired by traditional techniques and local materials.</p><p>The central theme of this year\'s edition - <i>Les mutations du travail</i>, suited the concept of the furniture that we wanted to create.</p>',
            ],
        ];

        foreach ($articles as $article) {
            Blog::updateOrCreate(['title' => $article['title']], $article);
        }
    }
}
