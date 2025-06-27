<?php

// File: tests/Feature/Api/TutorialApiTest.php

namespace Tests\Feature\Api;

use App\Models\Tutorial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TutorialApiTest extends TestCase
{
    use RefreshDatabase; // Selalu gunakan ini untuk tes database

    /**
     * Tes: API mengembalikan data tutorial yang benar untuk kode mata kuliah yang valid.
     */
    public function test_api_returns_correct_tutorials_for_valid_course_code(): void
    {
        // 1. Arrange (Atur Skenario)
        // Buat dua tutorial dengan kode mata kuliah yang sama
        $courseCode = 'A11.64404';
        $tutorial1 = Tutorial::factory()->create([
            'course_code' => $courseCode,
            'title' => 'Hello World dengan PHP'
        ]);
        $tutorial2 = Tutorial::factory()->create([
            'course_code' => $courseCode,
            'title' => 'Variabel dan Operator'
        ]);

        // Buat satu tutorial "pengganggu" dengan kode yang berbeda
        Tutorial::factory()->create(['course_code' => 'A11.XXXXX']);

        // 2. Act (Lakukan Aksi)
        // Panggil endpoint API dengan kode mata kuliah yang valid
        $response = $this->getJson('/api/tutorials/' . $courseCode);

        // 3. Assert (Pastikan Hasilnya Benar)
        // Pastikan status respons adalah 200 (OK)
        $response->assertStatus(200);

        // Pastikan struktur JSON utama sudah benar (memiliki 'results' dan 'status')
        $response->assertJsonStructure([
            'results' => [
                '*' => [ // Tanda '*' berarti setiap item di dalam array
                    'kode_matkul',
                    'nama_matkul',
                    'judul',
                    'url_presentation',
                    'url_finished',
                    'creator_email',
                    'created_at',
                    'updated_at',
                ]
            ],
            'status' => [
                'code',
                'description'
            ]
        ]);

        // Pastikan ada tepat 2 hasil di dalam 'results'
        $response->assertJsonCount(2, 'results');

        // Pastikan data yang dikembalikan mengandung judul tutorial yang kita buat
        $response->assertJsonFragment(['judul' => 'Hello World dengan PHP']);
        $response->assertJsonFragment(['judul' => 'Variabel dan Operator']);

        // Pastikan status code di dalam JSON adalah 200
        $response->assertJsonPath('status.code', 200);
    }

    /**
     * Tes: API mengembalikan format "Not Found" untuk kode mata kuliah yang tidak valid.
     */
    public function test_api_returns_not_found_for_invalid_course_code(): void
    {
        // 1. Arrange (Atur Skenario)
        $invalidCourseCode = 'TIDAK.ADA';

        // 2. Act (Lakukan Aksi)
        $response = $this->getJson('/api/tutorials/' . $invalidCourseCode);

        // 3. Assert (Pastikan Hasilnya Benar)
        // Pastikan status respons adalah 404 (Not Found)
        $response->assertStatus(404);

        // Pastikan JSON yang dikembalikan persis seperti format error yang diharapkan
        $response->assertExactJson([
            'results' => [],
            'status' => [
                'code' => 404,
                'description' => 'Not Found data ' . $invalidCourseCode,
            ]
        ]);
    }
}
