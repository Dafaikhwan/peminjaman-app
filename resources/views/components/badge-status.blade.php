@php
    $color = [
        'pending' => 'warning text-dark',
        'diterima' => 'success',
        'ditolak' => 'danger',
        'dibatalkan' => 'secondary'
    ];
@endphp

<span class="badge bg-{{ $color[$status] ?? 'dark' }}">
    {{ ucfirst($status) }}
</span>
