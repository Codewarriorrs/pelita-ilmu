<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Tampilkan landing page utama.
     */
    public function index(): View
    {
        return view('welcome');
    }

    /**
     * Tampilkan halaman formulir pendaftaran terpisah.
     */
    public function create(): View
    {
        return view('daftar');
    }

    /**
     * Simpan data pendaftaran siswa baru.
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Saat ini UI dan validasi sudah siap. Data siap disimpan ke model Siswa/Pendaftaran.
        // Contoh: Siswa::create([...]);

        return redirect()->route('daftar')
            ->with('success', 'Terima kasih, data pendaftaran ananda ' . e($validated['nama_lengkap']) . ' telah kami terima. Tim admin Pelita Ilmu akan menghubungi nomor ' . e($validated['no_telp_ortu']) . ' via WhatsApp dalam kurun waktu 1x24 jam.');
    }
}
