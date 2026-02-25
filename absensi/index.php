<!DOCTYPE html>
<html>
<head>
<title>Login Mahasiswa</title>
<style>
body{font-family:Arial;background:#f4f4f4;display:flex;justify-content:center;align-items:center;height:100vh}
.card{background:white;padding:25px;border-radius:10px;width:300px}
select,input,button{width:100%;padding:8px;margin:5px 0}
button{background:#2c3e50;color:white;border:none}
</style>
</head>
<body>

<div class="card">
<h3>Login Mahasiswa</h3>

<form action="dashboard.php" method="POST">

<input type="text" name="nim" placeholder="NIM" required>

<select name="jurusan" id="jurusan" required onchange="updateProdi()">
<option value="">-- Pilih Jurusan --</option>
<option value="Bisnis">Bisnis</option>
<option value="Teknik">Teknik</option>
</select>

<select name="prodi" id="prodi" required>
<option value="">-- Pilih Prodi --</option>
</select>

<button type="submit">Masuk</button>
</form>
</div>

<script>
function updateProdi(){
let jurusan=document.getElementById("jurusan").value;
let prodi=document.getElementById("prodi");
prodi.innerHTML="<option value=''>-- Pilih Prodi --</option>";

if(jurusan==="Bisnis"){
prodi.innerHTML+="<option value='Bisnis Digital'>Bisnis Digital</option>";
prodi.innerHTML+="<option value='Manajemen'>Manajemen</option>";
}

if(jurusan==="Teknik"){
prodi.innerHTML+="<option value='Informatika'>Informatika</option>";
prodi.innerHTML+="<option value='Sipil'>Teknik Sipil</option>";
}
}
</script>

</body>
</html>