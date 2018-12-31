<?php
	//header("Content-Type:application/json");
	session_start();

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');
	
	
	$d 	= New FormatTanggal();
	$n 	= New Nota();
	$s 	= New selisih();
		
	
	

	try {
		$data				= isset($_POST['op'])?$_POST['op']:null;
	}

	catch(Exception $e) {
		$data = null;
		echo 'Message: ' .$e->getMessage();
	}	
	
switch($data){
case "add_item_pembelian":
		

	$no_nota 			= $_POST['no_nota'];	
	$nama_karung 		= $_POST['nama_karung'];	
	$jenis_beras_id 	= preg_replace('/[^0-9]/', '', $_POST['jenis_beras']);	
	$harga 				= preg_replace('/[^0-9]/', '', $_POST['harga']);	
	$tonase 			= $_POST['tonase'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	

	if ( ($nama_karung != "")&( $jenis_beras_id != "") ){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_transaksi  (no_nota, jenis_transaksi, jenis_beras_id,nama_karung,qty,tonase,harga,upah_kuli)
													VALUES(:a,:b,:c,:d,:e,:f,:g ,:h)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => 'pembelian',
								"c" => $jenis_beras_id,
								"d" => $nama_karung,
								"e" => $qty,
								"f" => $tonase,
								"g" => $harga,
								"h" => 10
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

	

break;
case "add_item_penjualan":
		

	$no_nota 			= $_POST['no_nota'];
	$data_k 			= $_POST['nama_karung'];
	
	//==cari stok_beras_id
	if ( $data_k != null ){
		$dt 	 	  = explode("|",$data_k);
		$stok_beras_id = $dt[0];
		//$tonase 	 = $dt[1];
	}else{
		$stok_beras_id = "";
	}


	//cari nama karung nya
	$query = $koneksi->prepare(" SELECT nama_karung
											FROM stok_beras
											
											WHERE id = '$stok_beras_id'
											 ");
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);
	$nama_karung = $x->nama_karung;

	$harga 				= preg_replace('/[^0-9]/', '', $_POST['harga']);	
	$tonase 			= $_POST['tonase'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	

	if ( ($nama_karung != "")&( $stok_beras_id != "") ){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_transaksi  (no_nota, jenis_transaksi, stok_beras_id,nama_karung,qty,tonase,harga)
													VALUES(:a,:b,:c,:d,:e,:f,:g)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => 'penjualan',
								"c" => $stok_beras_id,
								"d" => $nama_karung,
								"e" => $qty,
								"f" => $tonase,
								"g" => $harga
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 400 error'); //if error
		}
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

	

break;
case "update_qty_tmp":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 	= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_transaksi
										SET 	qty			= :qty
										WHERE id		= :id ");
		$update->execute(array(
								"qty" 		=> $qty,
								"id" 		=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_tonase_tmp":
		
	$tonase  	= $_POST['tonase'];
	$id 		= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_transaksi
										SET 	tonase	= :tonase
										WHERE   id		= :id ");
		$update->execute(array(
								"tonase" 	=> $tonase,
								"id" 		=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_harga_tmp":
		
	$harga  	= preg_replace('/[^0-9]/', '', $_POST['harga']);
	$id 		= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_transaksi
										SET 	harga	= :harga
										WHERE   id		= :id ");
		$update->execute(array(
								"harga" 	=> $harga,
								"id" 		=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_upah_kuli_tmp":
		
	$upah_kuli  	= preg_replace('/[^0-9]/', '', $_POST['upah_kuli']);
	$id 		= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_transaksi
										SET 	upah_kuli	= :upah_kuli
										WHERE   id			= :id ");
		$update->execute(array(
								"upah_kuli" 	=> $upah_kuli,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_komisi_tmp":
		
	$komisi  	= preg_replace('/[^0-9]/', '', $_POST['komisi']);
	$id 		= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_transaksi
										SET 	komisi		= :komisi
										WHERE   id			= :id ");
		$update->execute(array(
								"komisi" 		=> $komisi,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "delete_from_tmp":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['tmp_transaksi_id']);		
	
	try{
	$query = $koneksi->prepare("DELETE FROM tmp_transaksi  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "add_item_tambahan":
		

	$no_nota 			= $_POST['no_nota'];	
	$item_tambahan 		= $_POST['item_tambahan'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	$harga_satuan		= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);	
	

	if ( $item_tambahan != ""){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_tambahan  (no_nota,item_tambahan,qty,harga_satuan)
													VALUES(:a,:b,:c,:d)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => $item_tambahan,
								"c" => $qty,
								"d" => $harga_satuan
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	

break;
case "add_item_tambahan_beli":
		

	$no_nota 			= $_POST['no_nota'];	
	$item_tambahan 		= $_POST['item_tambahan'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	$harga_satuan		= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);	
	

	if ( $item_tambahan != ""){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_tambahan_beli  (no_nota,item_tambahan,qty,harga_satuan)
													VALUES(:a,:b,:c,:d)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => $item_tambahan,
								"c" => $qty,
								"d" => $harga_satuan
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	

break;
case "update_qty_tmp_tambahan":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_tambahan
										SET 	qty		= :qty
										WHERE   id		= :id ");
		$update->execute(array(
								"qty" 			=> $qty,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_qty_tmp_tambahan_beli":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_tambahan_beli
										SET 	qty		= :qty
										WHERE   id		= :id ");
		$update->execute(array(
								"qty" 			=> $qty,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_harga_satuan_tmp_tambahan":
		
	$harga_satuan  	= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_tambahan
										SET 	harga_satuan		= :harga_satuan
										WHERE   id					= :id ");
		$update->execute(array(
								"harga_satuan" 	=> $harga_satuan,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_harga_satuan_tmp_tambahan_beli":
		
	$harga_satuan  	= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_tambahan_beli
										SET 	harga_satuan		= :harga_satuan
										WHERE   id					= :id ");
		$update->execute(array(
								"harga_satuan" 	=> $harga_satuan,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "delete_from_tmp_tambahan":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['tmp_transaksi_tambahan_id']);		
	
	try{
	$query = $koneksi->prepare("DELETE FROM tmp_tambahan  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "delete_from_tmp_tambahan_beli":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['tmp_transaksi_tambahan_id']);		
	
	try{
	$query = $koneksi->prepare("DELETE FROM tmp_tambahan_beli  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;



case "add_item_pengurangan":
		

	$no_nota 			= $_POST['no_nota'];	
	$item_pengurangan 		= $_POST['item_pengurangan'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	$harga_satuan		= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);	
	

	if ( $item_pengurangan != ""){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_pengurangan  (no_nota,item_pengurangan,qty,harga_satuan)
													VALUES(:a,:b,:c,:d)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => $item_pengurangan,
								"c" => $qty,
								"d" => $harga_satuan
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	

break;
case "add_item_pengurangan_beli":
		

	$no_nota 			= $_POST['no_nota'];	
	$item_pengurangan 		= $_POST['item_pengurangan'];	
	$qty 				= preg_replace('/[^0-9]/', '', $_POST['qty']);	
	$harga_satuan		= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);	
	

	if ( $item_pengurangan != ""){
		try{
			$query = $koneksi->prepare("INSERT INTO tmp_pengurangan_beli  (no_nota,item_pengurangan,qty,harga_satuan)
													VALUES(:a,:b,:c,:d)");
			$query->execute(array(
								"a" => $no_nota,
								"b" => $item_pengurangan,
								"c" => $qty,
								"d" => $harga_satuan
							));	
			  
						}
		catch ( PDOException $e)
		{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	

break;
case "update_qty_tmp_pengurangan":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_pengurangan
										SET 	qty		= :qty
										WHERE   id		= :id ");
		$update->execute(array(
								"qty" 			=> $qty,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_qty_tmp_pengurangan_beli":
		
	$qty  	= preg_replace('/[^0-9]/', '', $_POST['qty']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_pengurangan_beli
										SET 	qty		= :qty
										WHERE   id		= :id ");
		$update->execute(array(
								"qty" 			=> $qty,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_harga_satuan_tmp_pengurangan":
		
	$harga_satuan  	= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_pengurangan
										SET 	harga_satuan		= :harga_satuan
										WHERE   id					= :id ");
		$update->execute(array(
								"harga_satuan" 	=> $harga_satuan,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "update_harga_satuan_tmp_pengurangan_beli":
		
	$harga_satuan  	= preg_replace('/[^0-9]/', '', $_POST['harga_satuan']);
	$id 			= preg_replace('/[^0-9]/', '', $_POST['id']);		
	

	try{
		$update = $koneksi->prepare("UPDATE tmp_pengurangan_beli
										SET 	harga_satuan		= :harga_satuan
										WHERE   id					= :id ");
		$update->execute(array(
								"harga_satuan" 	=> $harga_satuan,
								"id" 			=> $id
							));	
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "delete_from_tmp_pengurangan":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['tmp_transaksi_pengurangan_id']);		
	
	try{
	$query = $koneksi->prepare("DELETE FROM tmp_pengurangan  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "delete_from_tmp_pengurangan_beli":
		

	$id = preg_replace('/[^0-9]/', '', $_POST['tmp_transaksi_pengurangan_id']);		
	
	try{
	$query = $koneksi->prepare("DELETE FROM tmp_pengurangan_beli  WHERE id = :a ");
	$query->execute(array(
						"a" => $id
					));	
		  
	}	  
	catch ( PDOException $e)
	{
		header('HTTP/1.1 400 error'); //if error
	}

break;
default;
header('HTTP/1.1 400 request error');
break;
}
?>