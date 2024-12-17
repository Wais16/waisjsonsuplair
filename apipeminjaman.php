<?php
header("Content-Type: application/json; charset=UTF-8");

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perpustakaan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Koneksi gagal: " . $conn->connect_error]));
}

// Query data peminjaman
$sql = "SELECT 
            p.id_peminjaman, 
            b.id_buku, 
            b.judul AS judul_buku, 
            a.id_anggota, 
            a.nama AS nama_anggota, 
            p.tanggal_pinjam, 
            p.tanggal_kembali, 
            p.status 
        FROM peminjaman p
        JOIN buku b ON p.id_buku = b.id_buku
        JOIN anggota a ON p.id_anggota = a.id_anggota";

$result = $conn->query($sql);

$peminjaman = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $peminjaman[] = $row;
    }
}

echo json_encode($peminjaman);

$conn->close();
?>
