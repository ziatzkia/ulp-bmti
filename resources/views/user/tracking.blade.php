@extends('layouts.user')

@section('content')
<style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
        height: 100%;
    }
    .content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .permohonan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1000px;
        margin-bottom: 1rem;
    }
    .permohonan-header h1 {
        font-size: 2rem;
        color: #0057A2;
    }
    .permohonan-header button.add-button {
        background-color: #0057A2;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: bold;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }
    .permohonan-header button.add-button:hover {
        background-color: #004080;
    }
    .table-container {
        width: 100%;
        max-width: 100%;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        border: 1px solid #e0e0e0;
        padding: 1rem;
        text-align: left;
    }


    /* CSS untuk Form Permohonan Baru */
    .form-card {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 100%; /* Lebar penuh */
        margin-top: 2rem;
    }
    .form-card h1 {
        font-size: 2rem;
        color: #0057A2;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
    }
    .button-container {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    .button-container button {
        background-color: #0057A2;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .button-container button.secondary {
        background-color: #6c757d;
    }
    .button-container button:hover {
        background-color: #004080;
    }
    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        gap: 2rem;
    }
    .step {
        width: 40px;
        height: 40px;
        background-color: #ccc;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .step.active {
        background-color: #0057A2;
    }
    .hidden {
        display: none;
    }

    /* CSS baru untuk Tracking Permohonan */
    .tracking-container {
        width: 100%;
        max-width: 100%; /* Mengubah lebar agar tidak kecil di tengah */
        padding: 2rem;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 2rem;
    }
    .tracking-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .tracking-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #e3f2fd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #0057A2;
        border: 2px solid #0057A2;
    }
    .tracking-text {
        /* Menghapus flex-direction: column agar teks berada di samping */
        display: flex;
        flex-direction: column;
    }
    .tracking-text h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
    }
    .tracking-text p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
    }
</style>

<div class="content">
    <div id="permohonan-list-view" class="hidden">
        <div class="permohonan-header">
            <h1>Permohonan</h1>
            <button id="tambah-button" class="add-button">
                <i class="fa fa-plus-circle"></i> Tambah
            </button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data. Data ini akan diganti dengan data dari database -->
                    <tr>
                        <td>John Doe</td>
                        <td>Draft</td>
                        <td>2025-08-15</td>
                        <td><a href="#">Edit</a> | <a href="#">Hapus</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="tambah-permohonan-view" class="hidden">
        <div class="form-card">
            <h1>Permohonan</h1>
            <div class="step-indicator">
                <div class="step active">1</div>
                <div class="step">2</div>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="nama" placeholder="Nama, NIS/NIM, jurusan, periode, contact person" required>
                </div>
                <div class="form-group">
                    <input type="text" name="sekolah" placeholder="Asal Sekolah/Universitas" required>
                </div>
                <div class="form-group">
                    <input type="date" name="tanggal_mulai" required>
                </div>
                <div class="form-group">
                    <input type="date" name="tanggal_selesai" required>
                </div>
                <div class="button-container">
                    <button type="button" id="kembali-button" class="secondary">Kembali</button>
                    <button type="submit">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>

    <div id="tracking-view">
        <div class="permohonan-header">
            <h1>Tracking Permohonan</h1>
        </div>
        <div class="tracking-container">
            <div class="tracking-item">
                <div class="tracking-icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="tracking-text">
                    <h3>Selesai</h3>
                </div>
            </div>
            <div class="tracking-item">
                <div class="tracking-icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="tracking-text">
                    <h3>Staff Hubungan Masyarakat</h3>
                    <p>Mengajukan Permohonan</p>
                </div>
            </div>
            <div class="tracking-item">
                <div class="tracking-icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="tracking-text">
                    <h3>Penanggung jawab HUMAS dan Publikasi</h3>
                    <p>Mengajukan Permohonan</p>
                </div>
            </div>
            <div class="tracking-item">
                <div class="tracking-icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="tracking-text">
                    <h3>Operator Surat</h3>
                    <p>Mengajukan Permohonan</p>
                </div>
            </div>
            <div class="tracking-item">
                <div class="tracking-icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="tracking-text">
                    <h3>Azkia Aisya</h3>
                    <p>Mengajukan Permohonan</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tambahButton = document.getElementById('tambah-button');
        const kembaliButton = document.getElementById('kembali-button');
        const permohonanListView = document.getElementById('permohonan-list-view');
        const tambahPermohonanView = document.getElementById('tambah-permohonan-view');
        const trackingView = document.getElementById('tracking-view');

        // Menampilkan form permohonan baru saat tombol 'Tambah' diklik
        if (tambahButton) {
            tambahButton.addEventListener('click', function() {
                permohonanListView.classList.add('hidden');
                tambahPermohonanView.classList.remove('hidden');
                trackingView.classList.add('hidden');
            });
        }
        
        // Kembali ke daftar permohonan saat tombol 'Kembali' diklik
        if (kembaliButton) {
            kembaliButton.addEventListener('click', function() {
                tambahPermohonanView.classList.add('hidden');
                permohonanListView.classList.remove('hidden');
                trackingView.classList.add('hidden');
            });
        }

        // Contoh: Logika untuk beralih tampilan berdasarkan rute atau klik
        // Anda perlu menambahkan logika ini di file routing atau controller Anda
        // Misalnya, saat halaman "tracking" diakses, Anda tampilkan tracking-view
        const currentPath = window.location.pathname;
        if (currentPath.includes('/tracking')) {
             if (permohonanListView) permohonanListView.classList.add('hidden');
             if (tambahPermohonanView) tambahPermohonanView.classList.add('hidden');
             if (trackingView) trackingView.classList.remove('hidden');
        } else if (currentPath.includes('/permohonan/tambah')) {
             if (permohonanListView) permohonanListView.classList.add('hidden');
             if (tambahPermohonanView) tambahPermohonanView.classList.remove('hidden');
             if (trackingView) trackingView.classList.add('hidden');
        } else {
             if (permohonanListView) permohonanListView.classList.remove('hidden');
             if (tambahPermohonanView) tambahPermohonanView.classList.add('hidden');
             if (trackingView) trackingView.classList.add('hidden');
        }
    });
</script>
@endsection
