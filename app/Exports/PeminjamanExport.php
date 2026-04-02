<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with(['alat','ruangan','pengguna']);

        if($this->request->filled('tanggal_mulai') && $this->request->filled('tanggal_selesai')){
            $start = $this->request->tanggal_mulai . ' 00:00:00';
            $end   = $this->request->tanggal_selesai . ' 23:59:59';
            $query->whereBetween('tanggal_mulai', [$start, $end]);
        }
        if($this->request->filled('status_peminjaman')){
            $query->where('status_peminjaman', $this->request->status_peminjaman);
        }
        if($this->request->filled('alat_id')){
            $query->where('alat_id', $this->request->alat_id);
        }
        if($this->request->filled('ruangan_id')){
            $query->where('ruangan_id', $this->request->ruangan_id);
        }
        if($this->request->filled('pengguna_id')){
            $query->where('pengguna_id', $this->request->pengguna_id);
        }

        return $query->orderBy('created_at','desc')->get();
    }

    public function headings(): array
    {
        return ['No','Tanggal Mulai','Tanggal Selesai','Pengguna','Alat/Ruangan','Jam','Status'];
    }

    public function map($row): array
    {
        $item = $row->alat ? $row->alat->nama_alat : ($row->ruangan ? $row->ruangan->nama_ruangan : '-');
        return [
            $row->id,
            $row->tanggal_mulai,
            $row->tanggal_selesai,
            $row->pengguna->nama_pengguna ?? '-',
            $item,
            ($row->jam_mulai ?? '-') . ' - ' . ($row->jam_selesai ?? '-'),
            ucfirst($row->status_peminjaman),
        ];
    }
}
