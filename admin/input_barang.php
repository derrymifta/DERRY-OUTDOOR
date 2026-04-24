<?php
include '../koneksi.php'; 
?>
<div class="p-4" style="background: rgba(255,255,255,0.05); border-radius: 15px;">
    <h3 class="fw-bold mb-4 text-white">📸 Tambah Data Barang Outdoor</h3>
    
    <form action="proses_tambah_barang.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-light small">Nama Alat</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Tenda Eiger 4P" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-light small">Kategori Alat</label>
                <select name="jenis" class="form-select" required>
                    <option value="" disabled selected>Pilih Kategori...</option>
                    <option value="Tenda">⛺ Tenda</option>
                    <option value="Kompor">🍳 Kompor</option>
                    <option value="Sepatu">👟 Sepatu</option>
                    <option value="Carrier">🎒 Carrier</option>
                    <option value="Lainnya">🧩 Lainnya</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-light small">Kondisi Alat</label>
            <input type="text" name="kondisi" class="form-control" placeholder="Contoh: Bagus / Lecet Pemakaian" required>
        </div>
        
        <div class="mb-4">
            <label class="form-label fw-bold text-light small">Upload Foto Alat</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>
        
        <div class="d-grid pt-2">
            <button type="submit" name="simpan" class="btn btn-primary btn-lg rounded-pill fw-bold">🚀 Simpan & Upload</button>
        </div>
    </form>
</div>