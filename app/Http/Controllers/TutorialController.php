<?php


namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; // <-- Helper untuk membuat slug & string acak

class TutorialController extends Controller
{
    // Method index, create, edit, destroy tetap sama...
    public function index()
    {
        $tutorials = Tutorial::latest()->paginate(10);
        return view('tutorials.index', compact('tutorials'));
    }

    public function create(Request $request)
    {
        $refreshToken = $request->session()->get('refreshToken');
        $response = Http::withToken($refreshToken)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
        if (!$response->successful()) {
            return redirect()->route('tutorials.index')->with('error', 'Gagal mengambil data mata kuliah. Sesi Anda mungkin sudah berakhir, silakan coba login ulang.');
        }
        $courses = $response->json('data', []);
        return view('tutorials.create', compact('courses'));
    }


    /**
     * Menyimpan tutorial baru ke database. (Create)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:tutorials,title',
            'course_code' => 'required|string',
        ]);

        $baseSlug = Str::slug($request->title);

        // ================================================================
        // PERUBAHAN UTAMA (1/2): Hasilkan dua slug yang berbeda
        // ================================================================
        $presentationSlug = $baseSlug . '-pres-' . Str::random(10);
        $finishedSlug = $baseSlug . '-pdf-' . Str::random(10);

        $refreshToken = $request->session()->get('refreshToken');
        $response = Http::withToken($refreshToken)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
        $coursesList = $response->json('data', []);
        $courseNames = collect($coursesList)->pluck('nama', 'kdmk');
        $courseName = $courseNames->get($request->course_code, '');

        Tutorial::create([
            'title' => $request->title,
            'course_code' => $request->course_code,
            'course_name' => $courseName,
            'creator_email' => Auth::user()->email,
            'presentation_url' => $presentationSlug, // Gunakan slug presentasi
            'finished_url' => $finishedSlug,       // Gunakan slug finished
        ]);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil dibuat.');
    }

    public function edit(Request $request, Tutorial $tutorial)
    {
        $refreshToken = $request->session()->get('refreshToken');
        $response = Http::withToken($refreshToken)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
        if (!$response->successful()) {
            return redirect()->route('tutorials.index')->with('error', 'Gagal mengambil data mata kuliah. Sesi Anda mungkin sudah berakhir, silakan coba login ulang.');
        }
        $courses = $response->json('data', []);
        return view('tutorials.edit', compact('tutorial', 'courses'));
    }

    /**
     * Memperbarui data tutorial di database. (Update)
     */
    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:tutorials,title,' . $tutorial->id,
            'course_code' => 'required|string',
        ]);

        $refreshToken = $request->session()->get('refreshToken');
        $response = Http::withToken($refreshToken)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
        $coursesList = $response->json('data', []);
        $courseNames = collect($coursesList)->pluck('nama', 'kdmk');
        $tutorial->course_name = $courseNames->get($request->course_code, '');

        // Cek jika judul berubah, kita perlu generate ulang KEDUA URL
        if ($request->title !== $tutorial->title) {
            $baseSlug = Str::slug($request->title);

            $tutorial->presentation_url = $baseSlug . '-pres-' . Str::random(10);
            $tutorial->finished_url = $baseSlug . '-pdf-' . Str::random(10);
        }

        $tutorial->title = $request->title;
        $tutorial->course_code = $request->course_code;
        $tutorial->save();

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil diperbarui.');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil dihapus.');
    }
}
