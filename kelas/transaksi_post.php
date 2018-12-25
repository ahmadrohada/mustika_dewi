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


		//INSERT INTO STOK table 
		$cek_data = $koneksi->prepare(" SELECT * FROM stok_beras 	
															WHERE jenis_beras_id 	= '$x->jenis_beras_id' 
															AND nama_karung			= '$x->nama_karung'
															AND tonase				= '$x->tonase'
															AND harga_beli			= '$x->harga'
															
															ORDER by id ASC");
		$cek_data->execute();
		$ck = $cek_data->fetch(PDO::FETCH_OBJ);

		//jika ada update,,jika null insert
		if ( $ck->id == 0 ){
			//iNSERT NEW RECORD
			$query_2 = $koneksi->prepare("INSERT INTO stok_beras  (jenis_beras_id,nama_karung,tonase,harga_beli,qty_stok,supplier_id,tgl_beli)
			VALUES(:a,:b,:c,:d,:e,:f,:g)");
			$query_2->execute(array(
										"a" => $x->jenis_beras_id,
										"b" => strtoupper($x->nama_karung),
										"c" => $x->tonase,
										"d" => $x->harga,
										"e" => $x->qty,
										"f" => $supplier_id,
										"g" => date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s')
										));	


		}else{
			//UPDATE RECORD
			$update_stok = $koneksi->prepare("UPDATE stok_beras
												SET 	qty_stok		= :a,
														tgl_beli		= :b

												WHERE   id			= :id ");
			$update_stok->execute(array(
									"a" 		=> $ck->qty_stok + $x->qty,
									"b" 		=> date('Y'."-".'m'."-".'d'." ".'H'.":".'i'.":".'s'),
									"id" 		=> $ck->id
			));	





		} 


			
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
		$query_2 = $koneksi->prepare("INSERT INTO item_transaksi  (no_nota, jenis_transaksi ,nama_karung,qty,tonase,harga,upah_kuli,komisi)
											VALUES(:a,:b,:c,:d,:e,:f,:g,:h)");
		$query_2->execute(array(
							"a" => $x->no_nota,
							"b" => $x->jenis_transaksi,
							"c" => $x->nama_karung,
							"d" => $x->qty,
							"e" => $x->tonase,
							"f" => $x->harga,
							"g" => $x->upah_kuli,
							"h" => $x->komisi
						));	



		//KURANGI DATA STOK
		$update = $koneksi->prepare("UPDATE stok_beras
					SET 	qty_stok	= stok_beras.qty_stok - :qty
					WHERE   id			= :id ");
		$update->execute(array(
				"qty" 		=> $x->qty,
				"id" 		=> $x->stok_beras_id
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
case "hapus_transaksi_penjualan":
	
	$penjualan_id 		= $_POST['penjualan_id'];

	//cari no nota nya
	$query_1 = $koneksi->prepare(" SELECT 	
										a.id,
										a.no_nota 
										FROM penjualan a 
										WHERE id = 	'$penjualan_id'	
										
										LIMIT 1 ");


	$query_1->execute();
	$x = $query_1->fetch(PDO::FETCH_OBJ);
	if ($x){
		//echo $x->id;
		
		//hapus item transaksi
		$query_a = $koneksi->prepare("DELETE FROM item_transaksi  WHERE no_nota = :a AND jenis_transaksi = :b ");
		$query_a->execute(array(
							"a" => $x->no_nota,
							"b" => 'penjualan'
						));	

		//hapus item tambahan
		$query_b = $koneksi->prepare("DELETE FROM item_tambahan  WHERE no_nota = :a  ");
		$query_b->execute(array(
							"a" => $x->no_nota
						));	

		//hapus piutang
		
		$query_c = $koneksi->prepare("DELETE FROM bayar_piutang  WHERE nota_id = :a  ");
		$query_c->execute(array(
							"a" => $x->id
						));	

		//hapus data penjualan
		
		$query_d = $koneksi->prepare("DELETE FROM penjualan  WHERE id = :a  ");
		$query_d->execute(array(
							"a" => $penjualan_id
						));	

						
		header('HTTP/1.1 200 Sukses'); //if sukses

	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	
break;

case "hapus_transaksi_pembelian":
	
	$pembelian_id 		= $_POST['pembelian_id'];

	//cari no nota nya
	$query_1 = $koneksi->prepare(" SELECT 	
										a.id,
										a.no_nota 
										FROM pembelian a 
										WHERE id = 	'$pembelian_id'	
										
										LIMIT 1 ");


	$query_1->execute();
	$x = $query_1->fetch(PDO::FETCH_OBJ);
	if ($x){
		//echo $x->id;
		
		//hapus item transaksi
		$query_a = $koneksi->prepare("DELETE FROM item_transaksi  WHERE no_nota = :a AND jenis_transaksi = :b ");
		$query_a->execute(array(
							"a" => $x->no_nota,
							"b" => 'pembelian'
						));	

		//hapus item tambahan
		$query_b = $koneksi->prepare("DELETE FROM item_tambahan  WHERE no_nota = :a  ");
		$query_b->execute(array(
							"a" => $x->no_nota
						));	

		//hapus hutan
		
		$query_c = $koneksi->prepare("DELETE FROM bayar_hutang  WHERE nota_id = :a  ");
		$query_c->execute(array(
							"a" => $x->id
						));	

		//hapus data penjualan
		
		$query_d = $koneksi->prepare("DELETE FROM pembelian  WHERE id = :a  ");
		$query_d->execute(array(
							"a" => $pembelian_id
						));	

						
		header('HTTP/1.1 200 Sukses'); //if sukses

	}else{
		header('HTTP/1.1 402 error'); //if error
	}

	

break;


default;
header('HTTP/1.1 400 request error');
break;
}
?>