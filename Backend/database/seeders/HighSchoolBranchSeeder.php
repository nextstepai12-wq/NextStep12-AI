<?php

namespace Database\Seeders;

use App\Models\HighSchoolBranch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HighSchoolBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $branches = ['علمي', 'أدبي', 'تجاري', 'صناعي', 'شرعي'];
    foreach ($branches as $name) {
        HighSchoolBranch::create([
            'name' => $name,
            'is_active' => true,
        ]);
    }
}
}
