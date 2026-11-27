<?php
$c = @new mysqli("proxysql", "appuser", "apppass", "appdb", 6033);
echo "<h1>Aplikasi Web UTS</h1>";
if ($c->connect_error) {
  echo "Koneksi database GAGAL: " . $c->connect_error;
} else {
  echo "Koneksi database via ProxySQL BERHASIL";
}
