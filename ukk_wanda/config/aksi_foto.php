<?php 
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
	$judulfoto = $_POST['judulfoto'];
	$deskripsifoto = $_POST['deskripsifoto'];
	$tanggalunggah = date('Y-m-d');
	$albumid = $_POST['albumid'];
	$userid = $_SESSION['userid'];
	$foto = $_FILES['lokasifoto']['name'];
	$tmp = $_FILES['lokasifoto']['tmp_name'];
	$lokasi = '../assets/img/';
	$namafoto = rand().'-'.$foto;

	move_uploaded_file($tmp, $lokasi.$namafoto);

	$sql = mysqli_query($koneksi, "INSERT INTO foto VALUES('', '$judulfoto', '$deskripsifoto', '$tanggalunggah','$namafoto', '$albumid','$userid')");

	echo "<script>
	alert('Data berhasil disimpan!');
	location.href='../admin/foto.php';
	</script>"; 
}

if (isset($_POST['edit'])) 
	$fotoid  = $_POST['fotoid'];
	$judulfoto = $_POST['judulfoto'];
	$deskripsifoto = $_POST['deskripsifoto'];
	$tanggalunggah = date('Y-m-d');
	$albumid = $_POST['albumid'];
	$userid = $_SESSION['userid'];
	$foto = $_FILES['lokasifoto']['name'];
	$tmp = $_FILES['lokasifoto']['tmp_name'];
	$lokasi = '../assets/img/';
	$namafoto = rand().'-'.$foto;

	if ($foto == null) {
		$sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto',deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', albumid='$albumid' WHERE fotoid='$fotoid'");
	}else{
		$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
		$data = mysqli_fetch_array($query);
		if (is_file('../assets/img/'.$data['lokasifoto'])) {
			unlink('../assets/img/'.$data['lokasifoto']);
		}
		move_uploaded_file($tmp, $lokasi.$namafoto);
		$sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto',deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', lokasifoto='$namafoto', albumid='$albumid' WHERE fotoid='$fotoid'");
	}
	echo "<script>
	alert('Data berhasil diperbarui!');
	location.href='../admin/foto.php';
	</script>"; 

if (isset($_POST['hapus'])) {
	$fotoid = $_POST['fotoid'];
	$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
		$data = mysqli_fetch_array($query);
		if (is_file('../assets/img/'.$data['lokasifoto'])) {
			unlink('../assets/img/'.$data['lokasifoto']);
		}

		$sql = mysqli_query($koneksi, "DELETE FROM foto WHERE fotoid='$fotoid'");
		echo "<script>
	alert('Data berhasil diperbarui!');
	location.href='../admin/foto.php';
	</script>"; 

}
?>