<?php
$c = @new mysqli("proxysql", "appuser", "apppass", "appdb", 6033);
if ($c->connect_error) { die("Koneksi database GAGAL: " . $c->connect_error); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['tambah'])) {
    $s = $c->prepare("INSERT INTO kamar (nama, harga, fasilitas, status) VALUES (?,?,?,?)");
    $s->bind_param("siss", $_POST['nama'], $_POST['harga'], $_POST['fasilitas'], $_POST['status']);
    $s->execute();
  } elseif (isset($_POST['hapus'])) {
    $s = $c->prepare("DELETE FROM kamar WHERE id=?");
    $s->bind_param("i", $_POST['id']);
    $s->execute();
  } elseif (isset($_POST['toggle'])) {
    $s = $c->prepare("UPDATE kamar SET status = IF(status='Kosong','Terisi','Kosong') WHERE id=?");
    $s->bind_param("i", $_POST['id']);
    $s->execute();
  }
  header("Location: /");
  exit;
}
$rows = $c->query("SELECT * FROM kamar ORDER BY id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kos Mulyana</title>
<style>
body{font-family:Arial,sans-serif;max-width:900px;margin:30px auto;padding:0 15px;background:#f4f6f8;color:#222}
h1{color:#1a5276}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{padding:10px;border:1px solid #ddd;text-align:left}
th{background:#1a5276;color:#fff}
.k{color:#1e8449;font-weight:bold}.t{color:#c0392b;font-weight:bold}
form.inline{display:inline}
input,select{padding:7px;margin:3px}
button{padding:7px 12px;border:0;background:#1a5276;color:#fff;border-radius:4px;cursor:pointer}
button.d{background:#c0392b}
.box{background:#fff;padding:15px;margin-top:20px;border:1px solid #ddd}
</style>
</head>
<body>
<h1>Kos Mulyana - Informasi Kamar</h1>
<p>Server: <?= gethostname() ?> | Database via ProxySQL</p>
<table>
<tr><th>Kamar</th><th>Harga/bulan</th><th>Fasilitas</th><th>Status</th><th>Aksi</th></tr>
<?php while($r = $rows->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($r['nama']) ?></td>
<td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
<td><?= htmlspecialchars($r['fasilitas']) ?></td>
<td class="<?= $r['status']=='Kosong'?'k':'t' ?>"><?= $r['status'] ?></td>
<td>
<form class="inline" method="post"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button name="toggle">Ubah Status</button></form>
<form class="inline" method="post" onsubmit="return confirm('Hapus kamar ini?')"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="d" name="hapus">Hapus</button></form>
</td>
</tr>
<?php endwhile; ?>
</table>
<div class="box">
<h3>Tambah Kamar</h3>
<form method="post">
<input name="nama" placeholder="Nama kamar" required>
<input name="harga" type="number" placeholder="Harga" required>
<input name="fasilitas" placeholder="Fasilitas">
<select name="status"><option>Kosong</option><option>Terisi</option></select>
<button name="tambah">Tambah</button>
</form>
</div>
</body>
</html>
