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
        return view('landingpage');
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

        $mapels = $validated['mata_pelajaran'] ?? [];
        $kategori = $validated['kategori_kelas'] ?? 'Reguler';
        $kelas = $validated['kelas'] ?? $validated['tingkat_kelas'] ?? '';
        $program = $validated['minat_program'] ?? '';
        $jenjang = $validated['jenjang'] ?? '';

        $isTkOrSd = ($jenjang === 'TK' || $jenjang === 'SD' || $program === 'TK' || str_starts_with($program, 'SD') || str_contains(strtoupper($kelas), 'SD') || str_contains(strtoupper($kelas), 'TK') || str_contains(strtoupper($kelas), 'PAUD'));

        if (empty($mapels) && $isTkOrSd) {
            $mapels = ($jenjang === 'TK' || $program === 'TK' || str_contains(strtoupper($kelas), 'TK'))
                ? ['Semua Mapel TK (Calistung, Mengaji, B. Inggris)']
                : ['Semua Mapel Pokok SD (Matematika, IPA, IPS, B. Indonesia, B. Inggris, Tematik)'];
        }

        $mapelList = !empty($mapels) && is_array($mapels) 
            ? ' (Mapel: ' . implode(', ', $mapels) . ')' 
            : '';

        $programDetail = ($kelas ? '[' . $kelas . '] ' : '') . $kategori . ' - ' . $program . $mapelList;

        Pendaftaran::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'asal_sekolah' => $validated['asal_sekolah'] ?? null,
            'kelas' => $kelas,
            'kategori_kelas' => $kategori,
            'program_belajar' => $program,
            'pilihan_mapel' => $mapels,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'nama_ortu' => $validated['nama_ortu'] ?? null,
            'no_telp_ortu' => $validated['no_telp_ortu'] ?? null,
            'no_telp_siswa' => $validated['no_telp_siswa'] ?? null,
            'alamat_rumah' => $validated['alamat_rumah'] ?? null,
            'minat_program' => $programDetail,
            'nomor_wa' => $validated['no_telp_ortu'] ?? null,
            'status_tindak_lanjut' => 'BARU',
            'tanggal_masuk' => now(),
        ]);

        return redirect()->route('pendaftaran')
            ->with('success', 'Terima kasih! Data pendaftaran ananda ' . e($validated['nama_lengkap']) . ' telah berhasil diterima. Tim Bimbel Pelita Ilmu akan segera menghubungi WhatsApp orang tua (' . e($validated['no_telp_ortu']) . ') untuk konfirmasi jadwal dan rincian biaya.');
    }
}
