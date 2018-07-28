<?php if(!isset($_SERVER['HTTP_REFERER'])) { ?><script type="text/javascript">document.location  = "./home.php";</script><?php exit(); }  ?>

<?php
$con=mysqli_connect("localhost","root","","db_simpeg");
$request=isset($_GET['request'])?$_GET['request']:null;

		
	
switch($request){
case "admin_skpd":



	$sql = "SELECT 	id,
					nipbaru,
					gelardpn,
					nama,
					gelarblk 
					
					FROM pegawai
					
					WHERE nama LIKE '%".$_GET['data']."%' or nipbaru LIKE '".$_GET['data']."%'
					ORDER BY nama ASC
					LIMIT 10 "; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	$json = [];
	while($row = $result->fetch_assoc()){
		
		if ( $row['gelarblk'] == null ) 
			{ $koma = ""; } else { $koma = ", ";};
		if ( $row['gelardpn'] == null ) 
			{ $titik = ""; } else { $titik = ". ";};
		
		$nama = $row['gelardpn'].$titik.ucwords(strtolower($row['nama'])).$koma.$row['gelarblk'];
		
		
		$json[] = $nama." - ".$row['nipbaru'];
	}

	echo json_encode($json);

break;
case "detail_admin_skpd":
	
	$nip = trim($_GET['nip']);  //user_id
	
	$sql = "SELECT 				nama,
								gelardpn,
								gelarblk,
								nipbaru,
								gol_terakhir,
								nama_jabatan,
								eselon
								
								FROM pegawai 
								WHERE nipbaru ='$nip' 
								";
	
	$result    = mysqli_query($con,$sql);
	
	if ( mysqli_num_rows($result) != 0 ){
		$x = mysqli_fetch_object($result);
		
		
		if ($x->gelarblk == null ) 
			{ $koma = ""; } else { $koma = ", ";};
		if ($x->gelardpn == null ) 
			{ $titik = ""; } else { $titik = ". ";};
			$nama = $x->gelardpn.$titik.ucwords(strtolower($x->nama)).$koma.$x->gelarblk;
		
		
		
		$data= array(
				"nip"				=>$x->nipbaru,
				"nama"				=>$nama,
				"golongan"			=>$x->gol_terakhir,
				"jabatan"			=>$x->nama_jabatan,
				"eselon"			=>$x->eselon
			  );
		echo json_encode($data);	
		
	}else{
		header('HTTP/1.1 500 Internal Server Error');
	}

break;

case "nama_skpd":


	$sql = "SELECT id_unor,nama_unor FROM master_unor
			WHERE nama_unor LIKE '%".$_GET['query']."%'
			ORDER BY id_unor ASC
			LIMIT 10"; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	$json = [];
	while($row = $result->fetch_assoc()){
		
		
		$json[] = $row['id_unor']."-".$row['nama_unor'];
	}

	echo json_encode($json);

break;
case "unit_kerja":
	
	
	
	
	$sql = "SELECT nama_skpd,kode_opd FROM master_skpd WHERE kode_opd ='".$_GET['kode_opd']."' "; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	while( $x = mysqli_fetch_array($result) ){
		if ( ( $_GET['kode_opd'] != "" )&&( $x['kode_opd'] == $_GET['kode_opd']) ){
			echo "<option value='$x[nama_skpd]' selected>$x[nama_skpd]</option>";
		}else{
			echo "<option value='$x[nama_skpd]'>$x[nama_skpd]</option>";
		}
		
	}
	
break;
case "unit_kerja_list":
	

	$sql = "SELECT nama_skpd FROM master_skpd WHERE nama_skpd ='".$_GET['unit_kerja']."' LIMIT 1"; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	while( $x = mysqli_fetch_array($result) ){
		if ( ( $_GET['unit_kerja'] != "" )&&( trim($x['nama_skpd']) == trim($_GET['unit_kerja'])) ){
			echo "<option value='$x[nama_skpd]' selected>$x[nama_skpd]</option>";
		}else{
			echo "<option value='$x[nama_skpd]'>$x[nama_skpd]</option>";
		}
		
	}
	
break;
case "unit_kerja_skpd":
	
	
	$unit_kerja	= isset($_GET['unit_kerja'])?$_GET['unit_kerja']:null;
	
	$keyword  	= isset($_GET['keyword'])? $_GET['keyword']:  "x";
	
	
	if ( $keyword == "x" ){
		$sql = "SELECT 
						b.nama_skpd
						FROM master_unor a
						LEFT JOIN master_skpd b ON b.kode_opd = a.id_unor
						WHERE a.nama_unor ='".$_GET['skpd']."'";
	}else{
		$sql = "SELECT 
						b.nama_skpd
						FROM master_unor a
						LEFT JOIN master_skpd b ON b.kode_opd = a.id_unor and b.nama_skpd LIKE '%".$_GET['keyword']."%'
						WHERE a.nama_unor ='".$_GET['skpd']."'";
	}
	
	 
						
						
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	while( $x = mysqli_fetch_array($result) ){
		if ( ( $unit_kerja != "" )&&( trim($x['nama_skpd']) == trim($unit_kerja) ) ){
			echo "<option value='$x[nama_skpd]' selected>$x[nama_skpd]</option>";
		}else{
			echo "<option value='$x[nama_skpd]'>$x[nama_skpd]</option>";
		}
	}
	
break;
case "unit_kerja_filter":
	
	
	
	
	$sql = "SELECT nama_skpd,kode_opd FROM master_skpd WHERE kode_opd ='".$_GET['kode_opd']."' "; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
			echo "<option value='all'>all</option>";
	while( $x = mysqli_fetch_array($result) ){
		
			echo "<option value='$x[nama_skpd]'>$x[nama_skpd]</option>";
	
	}
	
break;
case "foto_pegawai":
	$con=mysqli_connect("localhost","root","","db_simpeg");
	$sql = "SELECT 
						b.isi
						FROM pegawai a
						LEFT JOIN foto b ON b.nipbaru = a.nipbaru
						WHERE a.nipbaru ='".$_GET['nipbaru']."'"; 
	$result    = mysqli_query($con,$sql);
	//$result = $mysqli->query($sql);
	
	$x = mysqli_fetch_object($result);
	
	//FOTO
	if ( $x->isi != NULL ){
		$foto =  '<img src="data:image/jpeg;base64,'.base64_encode( $x->isi ).'" class="round"/>';
	}else{
		$foto = '<img src="images/form/sample.jpg" class="round"/>';
	}
	
	$item = array(
					"foto"	=> $foto
			);
		
	echo json_encode($item);
	
break;
}
?>