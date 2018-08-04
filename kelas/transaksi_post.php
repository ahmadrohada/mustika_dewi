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
																	keterangan)
									VALUES(:a,:b,:c,:d,:e,:f,:g)");
		$query_3->execute(array(
							"a" => $no_nota,
							"b" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
							"c" => $supplier_id,
							"d" => $user_id,
							"e" => $total_harga,
							"f" => $total_upah_kuli,
							"g" => $keterangan

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
		
	
	
	$no_nota  		= preg_replace('/[^0-9]/', '', $_POST['no_nota']);
	$pelanggan_id 	= $_POST['pelanggan_id']	;
	$user_id		= $_POST['user_id'];
	
	$grand_total  	= preg_replace('/[^0-9]/', '', $_POST['grand_total']);
	$bayar_x 		= preg_replace('/[^0-9]/', '', $_POST['bayar']);
	$total_komisi 	= preg_replace('/[^0-9]/', '', $_POST['total_komisi']);

	if ( $bayar_x > $grand_total ){
		$bayar = $grand_total;
		$sisa  = 0; 
	}else{
		$bayar = $bayar_x;
		$sisa  = $grand_total - ( $bayar_x + $total_komisi );
	}

	$income 		= $bayar - $total_komisi;
	$type_pembayaran= $_POST['type_pembayaran'];

	$keterangan		= $_POST['keterangan'];

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
	//=================================================================================================//


	if ( $no >= 1 ){

		$query_3 = $koneksi->prepare("INSERT INTO penjualan  (      no_nota,
																	tgl_nota,
																	pelanggan_id,
																	user_id,
																	grand_total, 
																	bayar,
																	komisi,
																	income,
																	sisa,
																	type_pembayaran,
																	keterangan)
									VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k)");
		$query_3->execute(array(
							"a" => $no_nota,
							"b" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
							"c" => $pelanggan_id,
							"d" => $user_id,
							"e" => $grand_total,
							"f" => $bayar,
							"g" => $total_komisi,
							"h" => $income,
							"i" => $sisa,
							"j" => $type_pembayaran,
							"k" => $keterangan

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
default;
header('HTTP/1.1 400 request error');
break;
}
?>