<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { about, blog, home } from '@/routes';
import { page as homePage } from '@/routes/home';
</script>

<template>
    <Head title="About" />
    <div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
        <div class="flex flex-col lg:flex-row">
            <aside id="sidebar" class="w-full lg:w-64 p-6 border-b lg:border-b-0 lg:border-r border-[#19140015] dark:border-[#3E3E3A]">
                <div class="sticky top-6">
                    <h2 class="text-xl font-bold mb-4">Maria Bubuioc</h2>
                    <nav class="space-y-2">
                        <Link :href="home().url" class="block hover:underline">Welcome</Link>
                        <Link :href="homePage().url" class="block hover:underline">Works</Link>
                        <Link :href="about().url" class="block font-bold">About</Link>
                        <Link :href="blog().url" class="block hover:underline">Blog</Link>
                    </nav>
                </div>
            </aside>

            <main id="main" class="flex-1 p-6 lg:p-12">
                <div class="max-w-4xl mx-auto">
                    <section class="mb-12">
                        <div class="space-y-6 text-lg leading-relaxed">
                            <p>Welcome and thank you for visiting my page!</p>

                            <p>My work explores the local traditional craftsmanship and natural materials in order to create sustainable and meaningful new objects.</p>

                            <p>I am fascinated by the richness of our cultural heritage: from handwoven textiles, patterns, vibrant colours, to the various embroidery motifs, each of them full with value and distinct depending on their regions. It is admirable how with great investisment of time, accuracy and ability, our ancestors produced their own materials. Every piece of cloth or textile for domestic use, were conceived to have a long life, to withstand multiple usage, and always be valuable in time.</p>

                            <p>This represents a source of inspiration for me, but I am also stimulated by the raw materials, the stages of the working process, the research and observation. I believe that the connection to the place where we live, brings more quality and authenticity to what we do.
                            Reviving the traditional techniques, re-thinking the processes, I strive to create products rooted in the past, but with a contemporary approach.</p>
                        </div>
                    </section>

                    <section class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
                        <div class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                            <img src="/img/about/about_me.jpg" alt="Maria Bubuioc" class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <div class="space-y-8">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">1990 born in Lapusna, Moldova</p>

                                    <h4 class="text-xl font-bold mb-4">Education</h4>
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>2012-2014 Master Degree in Photography, University of Art and Design Cluj-Napoca, Romania</li>
                                        <li>2009-2012 Bachelor in Product Design, University of Art and Design Cluj-Napoca, Romania</li>
                                        <li>2011 Ecole Supérieure des Arts Saint-Luc Liège, Belgium, ERASMUS program</li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold mb-4">Internship</h4>
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>2013 <a href="http://mobitec.be" target="_blank" class="text-blue-600 hover:underline">Mobitec Systems</a>, Belgium (3,5 months)</li>
                                        <li>2016 <a href="https://www.steelcase.com/" target="_blank" class="text-blue-600 hover:underline">Steelcase</a>, Cluj-Napoca (3 months)</li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold mb-4">Projects, Exhibitions</h4>
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>2017 Biennale Internationale Design Saint-Etienne, exhibiting the project Quintessence;</li>
                                        <li>2014 - partaker to the sound installation by German sound & media artist Frank Schulte, within the 20th anniversary of German Cultural Centre, event held on the Fortress Hill in Cluj-Napoca;</li>
                                        <li>2012 - ‘13 - taking part in the workshop “Re-act Boema”; its aim was to temporarily reactivate an old historical building of Cluj, that was abandoned for about 10 years;</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>
