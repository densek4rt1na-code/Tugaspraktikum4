<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $laporans = Laporan::latest()->orderByDesc('id')->paginate(5);

        return view('laporan.index', compact('laporans'));
    }

    public function create(): View
    {
        return view('lapor.create', ['daftarKecamatan' => Laporan::KECAMATAN]);
    }

    public function store(Request $request): RedirectResponse
    {
        return app(LaporWargaController::class)->store($request);
    }

    public function show(Laporan $laporan): View
    {
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan): View
    {
        return view('laporan.edit', [
            'laporan' => $laporan,
            'daftarKecamatan' => Laporan::KECAMATAN,
        ]);
    }

    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
            'lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', Rule::in(Laporan::KECAMATAN)],
            'tinggi_air' => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan' => ['required', 'string', 'max:2000'],
            'status' => ['required', Rule::in(Laporan::DAFTAR_STATUS)],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
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
            'status.required' => 'Status penanganan wajib dipilih.',
            'status.in' => 'Status penanganan tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage sebelum diganti
            $laporan->hapusFoto();
            $data['foto'] = $request->file('foto')->store('foto-laporan', 'public');
        } else {
            unset($data['foto']); // pertahankan foto lama
        }

        $laporan->update($data);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan): RedirectResponse
    {
        $laporan->hapusFoto();
        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
