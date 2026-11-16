<?php

namespace App\Http\Controllers;

use App\Filament\Pages\RekapPresensiMatrix;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapPresensiExportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $user = auth()->user();
        if (! $user || (! $user->isAdmin() && ! $user->isTentor())) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $page = new RekapPresensiMatrix();
        $page->bulan = (int) $request->query('bulan', date('m'));
        $page->tahun = (int) $request->query('tahun', date('Y'));
        $page->jenjang = (string) $request->query('jenjang', 'ALL');
        $page->kelompokId = $request->filled('kelompokId') ? (int) $request->query('kelompokId') : null;
        $page->searchSiswa = (string) $request->query('searchSiswa', '');

        return $page->exportExcel();
    }
}
