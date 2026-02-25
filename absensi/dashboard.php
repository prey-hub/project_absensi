<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if(isset($_POST['nim'])){
$_SESSION['nim']=$_POST['nim'];
$_SESSION['jurusan']=$_POST['jurusan'];
$_SESSION['prodi']=$_POST['prodi'];
}

if(!isset($_SESSION['nim'])){
header("Location:index.php");
exit();
}

$hari=date("l");

$hari_indonesia=[
"Monday"=>"Senin",
"Tuesday"=>"Selasa",
"Wednesday"=>"Rabu",
"Thursday"=>"Kamis",
"Friday"=>"Jumat",
"Saturday"=>"Sabtu",
"Sunday"=>"Minggu"
];

$hari_ini=$hari_indonesia[$hari];

// Jadwal hanya untuk Bisnis Digital
$jadwal=[];

if($_SESSION['prodi']=="Bisnis Digital"){

$jadwal=[
"Senin"=>[
["matkul"=>"WORKSHOP APLIKASI MOBILE","jam"=>"07:00"],
["matkul"=>"MRBD","jam"=>"13:00"],
["matkul"=>"PMRBD","jam"=>"15:00"]
],

"Selasa"=>[
["matkul"=>"DDA","jam"=>"13:00"],
["matkul"=>"MSDM","jam"=>"15:00"]
],

"Rabu"=>[
["matkul"=>"TECHNO SOCIO","jam"=>"07:00"],
["matkul"=>"KEAMANAN JARINGAN","jam"=>"09:00"]
],

"Kamis"=>[
["matkul"=>"WORKSHOP APLIKASI MOBILE","jam"=>"13:00"]
]
];

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body{font-family:Arial}
.card{background:#f4f4f4;padding:20px;border-radius:10px;width:450px}
a{display:block;margin:8px 0;padding:8px;background:#2c3e50;color:white;text-decoration:none;border-radius:5px}
</style>
</head>
<body>

<div class="card">
<h2>NIM: <?= $_SESSION['nim']; ?></h2>
<p>Jurusan: <?= $_SESSION['jurusan']; ?></p>
<p>Prodi: <?= $_SESSION['prodi']; ?></p>

<h3>Hari Ini: <?= $hari_ini; ?></h3>
<h3>Jadwal Mata Kuliah</h3>

<?php
if($_SESSION['prodi']!="Bisnis Digital"){
echo "Jadwal hanya tersedia untuk Prodi Bisnis Digital.";
}
else{
if(isset($jadwal[$hari_ini])){
foreach($jadwal[$hari_ini] as $mk){
echo '<a href="absen.php?matkul='.$mk['matkul'].'&jam='.$mk['jam'].'">';
echo $mk['matkul']." (".$mk['jam'].")";
echo '</a>';
}
}else{
echo "Tidak ada jadwal hari ini.";
}
}
?>

<br>
<a href="logout.php" style="background:red;">Logout</a>
</div>

</body>
</html>