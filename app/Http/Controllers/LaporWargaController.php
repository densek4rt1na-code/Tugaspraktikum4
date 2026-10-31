<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LaporWargaController extends Controller
{
    public function create(): View
    {
        return view('lapor.create', ['daftarKecamatan' => Laporan::KECAMATAN]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
            'lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', Rule::in(Laporan::KECAMATAN)],
            'tinggi_air' => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan' => ['required', 'string', 'max:2000'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // maks 2 MB
        ], [
            'nama_pelapor.required' => 'Nama pelapor wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP tidak valid (9-20 karakter angka, boleh diawali +).',
            'lokasi.required' => 'Lokasi kejadian wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kecamatan.in' => 'Kecamatan yang dipilih tidak valid.',
            'tinggi_air.required' => 'Tinggi air wajib diisi.',
            'tinggi_air.integer' => 'Tinggi air harus berupa angka bulat (cm).',
            'tinggi_air.min' => 'Tinggi air minimal 1 cm.',
            'tinggi_air.max' => 'Tinggi air maksimal 1000 cm.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'foto.required' => 'Foto bukti wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

 
        $data['foto'] = $request->file('foto')->store('foto-laporan', 'public');
        $data['status'] = Laporan::STATUS_MENUNGGU;

        Laporan::create($data);

        return redirect()->route('lapor.create')
            ->with('success', 'Laporan berhasil dikirim. Terima kasih, petugas BPBD akan segera menindaklanjuti.');
    }
}
