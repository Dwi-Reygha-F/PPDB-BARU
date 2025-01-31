<?php
// Sambungkan ke database Anda
session_start();

include "../../../koneksi.php";
// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Pastikan variabel no_pendaftaran ada dan bersihkan dari input pengguna
$no_pendaftaran = isset($_POST['no_pendaftaran']) ? mysqli_real_escape_string($koneksi, $_POST['no_pendaftaran']) : '';


// Buat query untuk mengambil data siswa berdasarkan nomor pendaftaran
$query = "SELECT data_siswa.*, tbl_gel.*
          FROM data_siswa
          INNER JOIN tbl_gel ON data_siswa.gelombang = tbl_gel.gelombang
          WHERE data_siswa.no_pendaftaran = '$no_pendaftaran'";
$result = mysqli_query($koneksi, $query);





// Jika query berhasil dieksekusi dan data ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Kirim data siswa sebagai respons JSON
    echo json_encode($row);
} else {
    // Kirim respons kosong jika data tidak ditemukan
    echo json_encode(array());
}

// Tutup koneksi ke database
mysqli_close($koneksi);
