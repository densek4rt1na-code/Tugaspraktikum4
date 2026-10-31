<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Laporan extends Model
{
    public const STATUS_MENUNGGU = 'Menunggu';
    public const STATUS_DIPROSES = 'Diproses';
    public const STATUS_SELESAI = 'Selesai';

    public const DAFTAR_STATUS = [
        self::STATUS_MENUNGGU,
        self::STATUS_DIPROSES,
        self::STATUS_SELESAI,
    ];

    public const KECAMATAN = [
        'Arjasari', 'Baleendah', 'Banjaran', 'Bojongsoang', 'Cangkuang', 'Cicalengka',
        'Cikancung', 'Cilengkrang', 'Cileunyi', 'Cimaung', 'Cimenyan', 'Ciparay',
        'Ciwidey', 'Dayeuhkolot', 'Ibun', 'Katapang', 'Kertasari', 'Kutawaringin',
        'Majalaya', 'Margaasih', 'Margahayu', 'Nagreg', 'Pacet', 'Pameungpeuk',
        'Pangalengan', 'Paseh', 'Pasirjambu', 'Rancabali', 'Rancaekek', 'Solokanjeruk',
        'Soreang',
    ];

    protected $fillable = [
        'nama_pelapor',
        'no_hp',
        'lokasi',
        'kecamatan',
        'tinggi_air',
        'keterangan',
        'foto',
        'status',
    ];

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? '/storage/' . ltrim($this->foto, '/') : null;
    }

    /** Hapus file foto dari storage bila ada. */
    public function hapusFoto(): void
    {
        if ($this->foto) {
            Storage::disk('public')->delete($this->foto);
        }
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DIPROSES => 'diproses',
            self::STATUS_SELESAI => 'selesai',
            default => 'menunggu',
        };
    }
}
