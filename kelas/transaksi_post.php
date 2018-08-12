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
case "simpan_transaksi_pembelian":
		
	$total_harga  	= preg_replace('/[^0-9]/', '', $_POST['total_harga']);
	$total_upah_kuli= preg_replace('/[^0-9]/', '', $_POST['total_upah_kuli']);
	
	$no_nota  		= preg_replace('/[^0-9]/', '', $_POST['no_nota']);
	$supplier_id 	= $_POST['supplier_id']	;
	$user_id		= $_POST['user_id'];
	$type_bayar		= $_POST['type_bayar'];
	$jumlah_dp		= preg_replace('/[^0-9]/', '', $_POST['jumlah_dp']);
	$keterangan		= $_POST['keterangan'];



	//====================================   insert data dari tmp  ======================================//
	$query = $koneksi->prepare(" SELECT * FROM tmp_transaksi WHERE no_nota = '$no_nota' ORDER by id ASC");
	$no = 0;
	$response = array();
	$query->execute();
	while($x = $query->fetch(PDO::FETCH_OBJ)) {
		//INSERT KE TABLE REAL ITEM TRANSAKSI
		$query_2 = $koneksi->prepare("INSERT INTO item_transaksi  (no_nota, jenis_transaksi ,jenis_beras_id,nama_karung,qty,tonase,harga,upah_kuli,komisi)
											VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i)");
		$query_2->execute(array(
							"a" => $x->no_nota,
							"b" => $x->jenis_transaksi,
							"c" => $x->jenis_beras_id,
							"d" => $x->nama_karung,
							"e" => $x->qty,
							"f" => $x->tonase,
							"g" => $x->harga,
							"h" => $x->upah_kuli,
							"i" => $x->komisi
						));	
		$no++;
	}	
	//=================================================================================================//


	if ( $no >= 1 ){

		$query_3 = $koneksi->prepare("INSERT INTO pembelian  (      no_nota,
																	tgl_nota,
																	supplier_id,
																	user_id,
																	total_harga, 
																	total_upah_kuli,
																	type_bayar,
																	jumlah_dp,
																	keterangan)
									VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i)");
		$query_3->execute(array(
							"a" => $no_nota,
							"b" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
							"c" => $supplier_id,
							"d" => $user_id,
							"e" => $total_harga,
							"f" => $total_upah_kuli,
							"g" => $type_bayar,
							"h" => $jumlah_dp,
							"i" => $keterangan

							));	

		if (mysql_errno() == 0){


			$query = $koneksi->prepare("DELETE FROM tmp_transaksi  WHERE no_nota = :a ");
			$query->execute(array(
								"a" => $no_nota
							));	

			header('HTTP/1.1 200 Sukses'); //if sukses
		}else{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

  
	

break;
case "simpan_transaksi_penjualan":
		
	
	
	$no_nota  			= preg_replace('/[^0-9]/', '', $_POST['no_nota']);
	$pelanggan_id 		= $_POST['pelanggan_id']	;
	$user_id			= $_POST['user_id'];
	
	$total_belanja  	= preg_replace('/[^0-9]/', '', $_POST['total_belanja']);
	$total_komisi 		= preg_replace('/[^0-9]/', '', $_POST['total_komisi']);
	$total_tambahan 	= preg_replace('/[^0-9]/', '', $_POST['total_tambahan']);
	$bayar 				= preg_replace('/[^0-9]/', '', $_POST['bayar']);
	$kembali 			= preg_replace('/[^0-9]/', '', $_POST['kembali']);

	$type_bayar     	= $_POST['type_bayar'];
	$keterangan 		= $_POST['keterangan'];

	
	//====================================   insert data dari tmp  ======================================//
	$query = $koneksi->prepare(" SELECT * FROM tmp_transaksi WHERE no_nota = '$no_nota' ORDER by id ASC");
	$no = 0;
	$response = array();
	$query->execute();
	while($x = $query->fetch(PDO::FETCH_OBJ)) {
		//INSERT KE TABLE REAL ITEM TRANSAKSI
		$query_2 = $koneksi->prepare("INSERT INTO item_transaksi  (no_nota, jenis_transaksi ,jenis_beras_id,pembelian_id,nama_karung,qty,tonase,harga,upah_kuli,komisi)
											VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j)");
		$query_2->execute(array(
							"a" => $x->no_nota,
							"b" => $x->jenis_transaksi,
							"c" => $x->jenis_beras_id,
							"d" => $x->pembelian_id,
							"e" => $x->nama_karung,
							"f" => $x->qty,
							"g" => $x->tonase,
							"h" => $x->harga,
							"i" => $x->upah_kuli,
							"j" => $x->komisi
						));	
		$no++;
	}	

//====================================   insert data dari tmp tambahan  ======================================//
	$query_x = $koneksi->prepare(" SELECT * FROM tmp_tambahan WHERE no_nota = '$no_nota' ORDER by id ASC");
	$response = array();
	$query_x->execute();
	while($x = $query_x->fetch(PDO::FETCH_OBJ)) {
		//INSERT KE TABLE REAL ITEM TRANSAKSI
		$query_y = $koneksi->prepare("INSERT INTO item_tambahan  (no_nota, item_tambahan ,qty,harga_satuan)
											VALUES(:a,:b,:c,:d)");
		$query_y->execute(array(
							"a" => $x->no_nota,
							"b" => $x->item_tambahan,
							"c" => $x->qty,
							"d" => $x->harga_satuan
						));	
	}	
	//=================================================================================================//


	if ( $no >= 1 ){

		$query_3 = $koneksi->prepare("INSERT INTO penjualan  (      no_nota,
																	tgl_nota,
																	pelanggan_id,
																	user_id,
																	total_belanja, 
																	total_komisi,
																	total_tambahan,
																	bayar,
																	type_bayar,
																	keterangan)
									VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j)");
		$query_3->execute(array(
							"a" => $no_nota,
							"b" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
							"c" => $pelanggan_id,
							"d" => $user_id,
							"e" => $total_belanja,
							"f" => $total_komisi,
							"g" => $total_tambahan,
							"h" => $bayar,
							"i" => $type_bayar,
							"j" => $keterangan

							));	

		if (mysql_errno() == 0){


			$query_a = $koneksi->prepare("DELETE FROM tmp_transaksi  WHERE no_nota = :a ");
			$query_a->execute(array(
								"a" => $no_nota
							));	

			$query_b = $koneksi->prepare("DELETE FROM tmp_tambahan  WHERE no_nota = :a ");
			$query_b->execute(array(
								"a" => $no_nota
							));	
			header('HTTP/1.1 200 Sukses'); //if sukses
		}else{
			header('HTTP/1.1 401 error'); //if error
		}
	}else{
		header('HTTP/1.1 402 error'); //if error
	}

  
	

break;
default;
header('HTTP/1.1 400 request error');
break;
}
?>