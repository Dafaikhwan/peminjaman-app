@extends('layouts.backend') 
{{-- bisa diganti ke layout admin kamu --}}

@section('content')
<div class="container py-4">

    <h3 class="mb-4 fw-bold">📅 Kalender Jadwal Peminjaman</h3>

    <!-- FILTER -->
    <div class="mb-3">
        <select id="filterTipe" class="form-select" style="max-width:250px;">
            <option value="">Semua</option>
            <option value="alat">Alat</option>
            <option value="ruangan">Ruangan</option>
        </select>
    </div>

    <!-- KALENDER -->
    <div id="calendar"></div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                <p><strong>Pinjam:</strong> <span id="detailPinjam"></span></p>
                <p><strong>Kembali:</strong> <span id="detailKembali"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- FULLCALENDAR CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<style>
    #calendar {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    @media(max-width:768px){
        #calendar { font-size: 12px !important; }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let calendarEl = document.getElementById("calendar");

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        height: "auto",
        editable: true,         // drag & drop aktif
        eventResizableFromStart: true, // resize aktif
        selectable: false,

        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay"
        },

        events: {
            url: "/kalender/data",
            method: "GET",
            extraParams: function () {
                return {
                    tipe: document.getElementById("filterTipe").value
                };
            }
        },

        // === DRAG EVENT ===
        eventDrop: function (info) {
            updateTanggal(info);
        },

        // === RESIZE (ubah durasi) ===
        eventResize: function(info) {
            updateTanggal(info);
        },

        // === KLIK EVENT ===
        eventClick: function(info) {
            document.getElementById("detailNama").textContent = info.event.title;
            document.getElementById("detailPinjam").textContent = info.event.start.toISOString().slice(0,10);
            document.getElementById("detailKembali").textContent = info.event.end ? info.event.end.toISOString().slice(0,10) : '-';

            new bootstrap.Modal(document.getElementById("detailModal")).show();
        }
    });

    calendar.render();

    // FILTER
    document.getElementById("filterTipe").addEventListener("change", function () {
        calendar.refetchEvents();
    });

    // === FUNCTION UPDATE DATABASE ===
    function updateTanggal(info) {
        fetch("/kalender/update-tanggal", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                id: info.event.id,
                start: info.event.startStr,
                end: info.event.endStr
            })
        }).then(res => res.json())
          .then(data => {
            if (!data.success) alert("Gagal update tanggal!");
        });
    }
});
</script>

@endsection
