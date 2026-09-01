<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            [
                'name' => 'الكلية الجامعية للعلوم التطبيقية',
                'email' => 'ucas@nextstep-ai.local',
                'password' => 'UCAS@2026',
                'location' => 'غزة، فلسطين',
                'description' => 'الكلية الجامعية للعلوم التطبيقية (UCAS) مؤسسة للتعليم العالي في فلسطين تقدم برامج أكاديمية وتطبيقية.',
                'vision_mission' => 'تقديم تعليم تطبيقي عالي الجودة وإعداد الطلبة بالمعارف والمهارات اللازمة لسوق العمل.',
                'website_url' => 'https://www.ucas.edu.ps/',
                'contact_info' => 'غزة، فلسطين',
            ],

            [
                'name' => 'الجامعة الإسلامية بغزة',
                'email' => 'iug@nextstep-ai.local',
                'password' => 'IUG@2026',
                'location' => 'غزة، فلسطين',
                'description' => 'الجامعة الإسلامية بغزة مؤسسة أكاديمية مستقلة من مؤسسات التعليم العالي.',
                'vision_mission' => 'توفير بيئة أكاديمية تسهم في بناء المعرفة وتنمية قدرات الطلبة والبحث العلمي.',
                'website_url' => 'https://www.iugaza.edu.ps/',
                'contact_info' => 'غزة، فلسطين',
            ],

            [
                'name' => 'جامعة الأزهر-غزة',
                'email' => 'alazhar@nextstep-ai.local',
                'password' => 'AlAzhar@2026',
                'location' => 'غزة، فلسطين',
                'description' => 'جامعة الأزهر-غزة مؤسسة للتعليم العالي في فلسطين تقدم برامج أكاديمية في مجالات متعددة.',
                'vision_mission' => 'التميز في التعليم العالي والبحث العلمي وخدمة المجتمع.',
                'website_url' => 'https://www.alazhar.edu.ps/',
                'contact_info' => 'غزة، فلسطين',
            ],

            [
                'name' => 'جامعة الأقصى',
                'email' => 'alaqsa@nextstep-ai.local',
                'password' => 'AlAqsa@2026',
                'location' => 'غزة، فلسطين',
                'description' => 'جامعة الأقصى مؤسسة تعليم عالٍ فلسطينية تقدم برامج التعليم الجامعي والبحث العلمي وخدمة المجتمع.',
                'vision_mission' => 'إعداد الطلبة بالمعرفة والمهارات والقيم اللازمة للمجتمع وسوق العمل.',
                'website_url' => 'https://alaqsa.edu.ps/',
                'contact_info' => 'غزة، فلسطين',
            ],

            [
                'name' => 'جامعة غزة',
                'email' => 'gu@nextstep-ai.local',
                'password' => 'GU@2026',
                'location' => 'غزة، فلسطين',
                'description' => 'جامعة غزة مؤسسة للتعليم الجامعي في فلسطين تقدم برامج أكاديمية في مجالات متعددة.',
                'vision_mission' => 'المساهمة في تطوير التعليم العالي الفلسطيني وإعداد الطلبة لسوق العمل.',
                'website_url' => 'https://www.gu.edu.ps/',
                'contact_info' => 'غزة، فلسطين',
            ],
        ];

        foreach ($universities as $data) {

            // إنشاء الجامعة
            $university = University::updateOrCreate(
                [
                    'name' => $data['name'],
                ],
                [
                    'type' => 'university',
                    'cover_image' => null,
                    'logo' => null,
                    'location' => $data['location'],
                    'description' => $data['description'],
                    'vision_mission' => $data['vision_mission'],
                    'website_url' => $data['website_url'],
                    'contact_info' => $data['contact_info'],
                ]
            );

            // إنشاء حساب الجامعة وربطه بها
            User::updateOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role' => 'university',
                    'university_id' => $university->id,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info(
            'تم إنشاء الجامعات وحسابات المستخدمين وربطها بنجاح.'
        );
    }
}