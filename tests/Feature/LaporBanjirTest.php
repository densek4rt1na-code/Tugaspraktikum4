<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporBanjirTest extends TestCase
{
    use RefreshDatabase;


    /** Gambar PNG asli (1x1 px) yang dipadding hingga $kb kilobyte; tidak butuh ekstensi GD. */
    private function gambar(string $nama = 'banjir.jpg', int $kb = 1): UploadedFile
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $isi = str_pad($png, $kb * 1024, "\0");

        return UploadedFile::fake()->createWithContent($nama, $isi);
    }

    private function dataValid(array $override = []): array
    {
        return array_merge([
            'nama_pelapor' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'lokasi' => 'Jl. Raya Dayeuhkolot RT 02/05',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 45,
            'keterangan' => 'Air masuk ke rumah warga.',
            'foto' => $this->gambar('banjir.jpg', 500),
        ], $override);
    }

    private function buatLaporan(array $override = []): Laporan
    {
        return Laporan::create(array_merge([
            'nama_pelapor' => 'Siti',
            'no_hp' => '0812000111',
            'lokasi' => 'Jl. Mawar',
            'kecamatan' => 'Baleendah',
            'tinggi_air' => 30,
            'keterangan' => 'Genangan di jalan.',
            'foto' => null,
            'status' => 'Menunggu',
        ], $override));
    }

    public function test_warga_dapat_mengirim_laporan_dengan_foto(): void
    {
        Storage::fake('public');

        $response = $this->post('/lapor', $this->dataValid());

        $response->assertRedirect(route('lapor.create'));
        $response->assertSessionHas('success');

        $laporan = Laporan::first();
        $this->assertNotNull($laporan);
        $this->assertSame('Menunggu', $laporan->status);
        Storage::disk('public')->assertExists($laporan->foto);
    }

    public function test_halaman_form_dan_pesan_sukses_tampil(): void
    {
        $this->get('/lapor')->assertOk()->assertSee('Foto Bukti Banjir');

        $this->withSession(['success' => 'Laporan berhasil dikirim.'])
            ->get('/lapor')->assertSee('Laporan berhasil dikirim.');
    }

    public function test_validasi_foto_wajib_dan_hanya_jpg_png_maks_2mb(): void
    {
        Storage::fake('public');

        $this->post('/lapor', $this->dataValid(['foto' => null]))
            ->assertSessionHasErrors(['foto' => 'Foto bukti wajib diunggah.']);

        $this->post('/lapor', $this->dataValid(['foto' => UploadedFile::fake()->create('dok.pdf', 100, 'application/pdf')]))
            ->assertSessionHasErrors('foto');

        $this->post('/lapor', $this->dataValid(['foto' => $this->gambar('besar.jpg', 2049)]))
            ->assertSessionHasErrors(['foto' => 'Ukuran foto maksimal 2 MB.']);

        $this->post('/lapor', $this->dataValid(['foto' => $this->gambar('ok.png', 2048)]))
            ->assertSessionDoesntHaveErrors();

        $this->assertSame(1, Laporan::count());
    }

    public function test_pesan_galat_tampil_di_bawah_input(): void
    {
        $this->from('/lapor')->post('/lapor', [])->assertRedirect('/lapor');

        $this->get('/lapor')
            ->assertSee('Nama pelapor wajib diisi.')
            ->assertSee('Nomor HP wajib diisi.')
            ->assertSee('Kecamatan wajib dipilih.')
            ->assertSee('Foto bukti wajib diunggah.');
    }

    public function test_tamu_tidak_bisa_masuk_area_petugas(): void
    {
        $laporan = $this->buatLaporan();

        $this->get('/laporan')->assertRedirect('/login');
        $this->get('/laporan/create')->assertRedirect('/login');
        $this->get("/laporan/{$laporan->id}")->assertRedirect('/login');
        $this->get("/laporan/{$laporan->id}/edit")->assertRedirect('/login');
        $this->put("/laporan/{$laporan->id}", [])->assertRedirect('/login');
        $this->delete("/laporan/{$laporan->id}")->assertRedirect('/login');
    }

    public function test_index_menampilkan_thumbnail_dan_pagination(): void
    {
        Storage::fake('public');
        foreach (range(1, 7) as $i) {
            $this->buatLaporan(['nama_pelapor' => "Pelapor $i", 'foto' => "foto-laporan/f$i.jpg"]);
        }

        $this->actingAs(User::factory()->create())
            ->get('/laporan')
            ->assertOk()
            ->assertSee('class="thumb"', false)
            ->assertSee('Berikutnya')
            ->assertSee('page=2', false);

        $this->get('/laporan?page=2')->assertOk()->assertSee('Pelapor 1');
    }

    public function test_detail_laporan(): void
    {
        $laporan = $this->buatLaporan();

        $this->actingAs(User::factory()->create())
            ->get("/laporan/{$laporan->id}")
            ->assertOk()->assertSee('Siti')->assertSee('Menunggu');
    }

    public function test_petugas_mengubah_status_dan_data(): void
    {
        $laporan = $this->buatLaporan();
        $payload = $this->dataValid(['status' => 'Diproses', 'foto' => null, 'nama_pelapor' => 'Siti Aminah']);
        unset($payload['foto']);

        $this->actingAs(User::factory()->create())
            ->put("/laporan/{$laporan->id}", $payload)
            ->assertRedirect(route('laporan.show', $laporan))
            ->assertSessionHas('success');

        $laporan->refresh();
        $this->assertSame('Diproses', $laporan->status);
        $this->assertSame('Siti Aminah', $laporan->nama_pelapor);
    }

    public function test_status_tidak_valid_ditolak(): void
    {
        $laporan = $this->buatLaporan();
        $payload = $this->dataValid(['status' => 'Ngawur']);
        unset($payload['foto']);

        $this->actingAs(User::factory()->create())
            ->put("/laporan/{$laporan->id}", $payload)
            ->assertSessionHasErrors(['status' => 'Status penanganan tidak valid.']);
    }

    public function test_ganti_foto_menghapus_foto_lama_dari_storage(): void
    {
        Storage::fake('public');
        $lama = $this->gambar('lama.jpg')->store('foto-laporan', 'public');
        $laporan = $this->buatLaporan(['foto' => $lama]);

        $this->actingAs(User::factory()->create())
            ->put("/laporan/{$laporan->id}", $this->dataValid(['status' => 'Selesai']))
            ->assertSessionHas('success');

        $laporan->refresh();
        $this->assertNotSame($lama, $laporan->foto);
        Storage::disk('public')->assertMissing($lama);
        Storage::disk('public')->assertExists($laporan->foto);
        $this->assertSame('Selesai', $laporan->status);
    }

    public function test_update_tanpa_foto_baru_mempertahankan_foto_lama(): void
    {
        Storage::fake('public');
        $lama = $this->gambar('lama.jpg')->store('foto-laporan', 'public');
        $laporan = $this->buatLaporan(['foto' => $lama]);
        $payload = $this->dataValid(['status' => 'Diproses']);
        unset($payload['foto']);

        $this->actingAs(User::factory()->create())->put("/laporan/{$laporan->id}", $payload);

        $this->assertSame($lama, $laporan->fresh()->foto);
        Storage::disk('public')->assertExists($lama);
    }

    public function test_hapus_laporan_ikut_menghapus_foto(): void
    {
        Storage::fake('public');
        $path = $this->gambar('x.jpg')->store('foto-laporan', 'public');
        $laporan = $this->buatLaporan(['foto' => $path]);

        $this->actingAs(User::factory()->create())
            ->delete("/laporan/{$laporan->id}")
            ->assertRedirect(route('laporan.index'))
            ->assertSessionHas('success', 'Laporan berhasil dihapus.');

        $this->assertDatabaseMissing('laporans', ['id' => $laporan->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_register_dan_login_manual(): void
    {
        $this->post('/register', [
            'name' => 'Petugas Baru', 'email' => 'baru@bpbd.test',
            'password' => 'rahasia1', 'password_confirmation' => 'rahasia1',
        ])->assertRedirect('/login');

        $this->post('/login', ['email' => 'baru@bpbd.test', 'password' => 'rahasia1'])
            ->assertRedirect('/laporan');
        $this->assertAuthenticated();
    }
}
