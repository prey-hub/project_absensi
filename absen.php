<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if(!isset($_SESSION['nim'])){
    header("Location:index.php");
    exit();
}

$matkul = $_GET['matkul'];
$jam_masuk = $_GET['jam'];
$jam_sekarang = date("H:i");

$selisih = (strtotime($jam_sekarang) - strtotime($jam_masuk)) / 60;

// Tentukan status
if($selisih <= 7){
    $status = "Hadir";
}
elseif($selisih <= 30){
    $status = "Telat";
}
else{
    $status = "Alpha";
}

// Cek apakah absensi ditutup (>30 menit)
$absen_ditutup = $selisih > 30;

// Cek apakah sudah pernah absen matkul ini
$sudah_absen = false;

if(isset($_SESSION['history'])){
    foreach($_SESSION['history'] as $h){
        if($h['matkul'] == $matkul){
            $sudah_absen = true;
        }
    }
}

// Simpan absensi jika:
if(isset($_POST['absen']) && !$absen_ditutup && !$sudah_absen){

    $_SESSION['history'][] = [
        "matkul"=>$matkul,
        "jam"=>$jam_sekarang,
        "status"=>$status
    ];

    $absen_berhasil = true;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Absensi</title>
<style>
body{font-family:Arial}
.container{display:flex}
.kiri{width:60%;text-align:center}
.kanan{width:40%;background:#f4f4f4;padding:15px}
video,canvas{border:2px solid black;border-radius:10px}
button{padding:8px 15px;margin:5px}
.warning{color:red;font-weight:bold}
.success{color:green;font-weight:bold}
</style>
</head>
<body>

<div class="container">

<div class="kiri">
<h2>Absensi <?= $matkul ?></h2>
<p>NIM: <?= $_SESSION['nim']; ?></p>
<p>Jam Masuk: <?= $jam_masuk ?></p>
<p>Jam Sekarang: <?= $jam_sekarang ?></p>

<?php if($absen_ditutup){ ?>

<p class="warning">Absensi ditutup. Anda Alpha (lebih dari 30 menit).</p>

<?php } elseif($sudah_absen){ ?>

<p class="warning">Anda sudah absen untuk mata kuliah ini.</p>

<?php } else { ?>

<!-- Kamera -->
<video id="video" width="320" height="240" autoplay></video>
<br>

<button onclick="ambilFoto()">Ambil Foto</button>

<form method="POST">
<button id="btnAbsen" name="absen" disabled>Absen Sekarang</button>
</form>

<br>
<canvas id="canvas" width="320" height="240"></canvas>

<?php if(isset($absen_berhasil)){ ?>
<p class="success">Absensi berhasil! Status Anda <?= $status ?>.</p>
<script>
let suara = new SpeechSynthesisUtterance(
    "Absensi berhasil. Status Anda <?= $status ?>."
);
suara.lang = "id-ID";
speechSynthesis.speak(suara);
</script>
<?php } ?>

<?php } ?>

<br><br>
<a href="dashboard.php">Kembali</a>
</div>

<div class="kanan">
<h3>History Kehadiran</h3>

<?php
if(isset($_SESSION['history'])){
    foreach($_SESSION['history'] as $h){
        echo "<hr>";
        echo "Matkul: ".$h['matkul']."<br>";
        echo "Jam: ".$h['jam']."<br>";
        echo "Status: ".$h['status']."<br>";
    }
}else{
    echo "Belum ada absensi.";
}
?>

</div>

</div>

<script>
<?php if(!$absen_ditutup && !$sudah_absen){ ?>

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
const btnAbsen = document.getElementById('btnAbsen');

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => video.srcObject = stream)
.catch(err => alert("Kamera tidak bisa diakses!"));

function ambilFoto(){
    context.drawImage(video, 0, 0, 320, 240);
    btnAbsen.disabled = false;
    alert("Foto berhasil diambil! Sekarang bisa absen.");
}

<?php } ?>
</script>

</body>
</html>