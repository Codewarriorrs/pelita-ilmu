<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Pendaftaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Tampilkan landing page utama.
     */
    public function index(): View
    {
        return view('LandingPage');
    }

    /**
     * Tampilkan halaman formulir pendaftaran terpisah.
     */
    public function create(): View
    {
        return view('pendaftaran');
    }

    /**
     * Simpan data pendaftaran siswa baru.
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $mapelList = isset($validated['mata_pelajaran']) && is_array($validated['mata_pelajaran']) 
            ? ' (Mapel: ' . implode(', ', $validated['mata_pelajaran']) . ')' 
            : '';

        $kategori = $validated['kategori_kelas'] ?? 'Reguler';
        $programDetail = $kategori . ' - ' . $validated['minat_program'] . $mapelList;

        Pendaftaran::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'minat_program' => $programDetail,
            'nomor_wa' => $validated['no_telp_ortu'],
            'status_tindak_lanjut' => 'BARU',
            'tanggal_masuk' => now(),
        ]);

        return redirect()->route('daftar')
            ->with('success', 'Terima kasih! Data pendaftaran ananda ' . e($validated['nama_lengkap']) . ' telah berhasil diterima. Tim Bimbel Pelita Ilmu akan menghubungi WhatsApp orang tua (' . e($validated['no_telp_ortu']) . ') untuk konfirmasi jadwal dan rincian biaya.');
    }
}
