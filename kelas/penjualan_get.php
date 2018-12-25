<?php
	//header("Content-Type:application/json");
	session_start();

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');
	
	
	$d 	= New FormatTanggal();
	$s 	= New selisih();
		
	
	

	try {
		$data				= isset($_GET['data'])?$_GET['data']:null;
	}

	//catch exception
	catch(Exception $e) {
		$data = null;
		echo 'Message: ' .$e->getMessage();
	}	
	
switch($data){
case "penjualan_list":
		
	$query = $koneksi->prepare(" SELECT 	
								a.id as nota_id,
								a.no_nota,
								a.tgl_nota,
								a.user_id,
								a.pelanggan_id,
								a.total_belanja,
								a.total_komisi,
								a.total_tambahan,
								a.bayar,
								a.type_bayar,
								b.nama,
								a.keterangan
								FROM penjualan a
								LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
								
								ORDER by a.tgl_nota DESC");
	
	$no = 0;
	$response = array();
	$response["penjualan_list"] = array();

	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

		

		switch($x->type_bayar)
			{
			case 1 : $type = 'Cash';
				break;
			case 2 : $type = 'Hutang';
				break;
			}
	
		if ( $type == 'Hutang'){
			$sisa = (($x->total_belanja - $x->total_komisi)+$x->total_tambahan)-$x->bayar;
		}else{
			$sisa = 0;
		}
		

			$no++;
			$h['no']				= $no;
			$h['id']				= $x->nota_id;
			$h['tgl_nota']			= $d->tgl_jam($x->tgl_nota);
			$h['no_nota']			= $x->no_nota;
			$h['pelanggan']			= $x->nama;


			$h['total_belanja']		= number_format($x->total_belanja,'0',',','.');
			$h['total_komisi']		= number_format($x->total_komisi,'0',',','.');
			$h['total_tambahan']	= number_format($x->total_tambahan,'0',',','.');
			$h['bayar']				= number_format($x->bayar,'0',',','.');
			$h['type_bayar']		= $type;
			$h['sisa']				= number_format($sisa,'0',',','.');
			$h['keterangan']		= $x->keterangan;
							
			array_push($response["penjualan_list"], $h);
	}	
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "tmp_penjualan_list":
		

	$no = 0;
	$response = array();
	$response["tmp_penjualan_list"] = array();
	$response["detail_penjualan_list"] = array();
	$total					= 0;
	$total_komisi			= 0;

	$query = $koneksi->prepare(" SELECT 	
									a.id,
									a.stok_beras_id,
									a.nama_karung,
									a.qty,
									a.tonase,
									a.harga,
									a.komisi,
									c.label AS jenis_beras

									FROM tmp_transaksi a
									LEFT JOIN stok_beras b ON b.id = a.stok_beras_id
									LEFT JOIN jenis_beras c ON c.id = b.jenis_beras_id

									WHERE jenis_transaksi = 'penjualan'

									ORDER by a.id ASC");

	

	$query->execute();

	while($x = $query->fetch(PDO::FETCH_OBJ)) {
			
			$jumlah	 		= $x->qty*$x->tonase*$x->harga  ;
			$komisi 		= $x->qty*$x->tonase*$x->komisi ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['stok_beras_id']	= $x->stok_beras_id;
			$h['nama_karung']	= $x->nama_karung;
			$h['jenis_beras']	= $x->jenis_beras;
			$h['qty']			= $x->qty;
			$h['tonase']		= $d->tonase($x->tonase);
			$h['komisi']		= $x->komisi;
			$h['harga']			= number_format($x->harga,'0',',','.');
			
			$h['jumlah']		= number_format($jumlah,'0',',','.');
							
			array_push($response["tmp_penjualan_list"], $h);

			$total				= $total + $jumlah;
			$total_komisi		= $total_komisi + $komisi;
			
	}	



	$gt['total']				= number_format($total,'0',',','.');

	$gt['total_komisi']			= number_format($total_komisi,'0',',','.');


	array_push($response["detail_penjualan_list"], $gt);
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "tmp_tambahan_list":
		

	$no = 0;
	$response = array();
	$response["tmp_tambahan_list"] = array();
	$response["detail_tambahan_list"] = array();
	$total_tambahan	= 0;

	$query = $koneksi->prepare(" SELECT 	
									a.id,
									a.no_nota,
									a.item_tambahan,
									a.qty,
									a.harga_satuan

									FROM tmp_tambahan a
									ORDER by a.id ASC");

	

	$query->execute();

	while($x = $query->fetch(PDO::FETCH_OBJ)) {

			/* if ( $x->discount > 0 ){
				$potongan   = ($x->discount/100)*$x->harga;
				$jumlah		= ($x->harga-$potongan)*$x->qty;
			}else{
				$jumlah		= $x->harga*$x->qty;
			} */
			
			$jumlah	 		= $x->qty*$x->harga_satuan  ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['item_tambahan']	= $x->item_tambahan;
			$h['qty']			= $x->qty;
			$h['harga_satuan']	= number_format($x->harga_satuan,'0',',','.');
			$h['jumlah']		= number_format($jumlah,'0',',','.');
			

			array_push($response["tmp_tambahan_list"], $h);

			$total_tambahan	= $total_tambahan + $jumlah;
			
	}	



	$gt['total_tambahan']				= number_format($total_tambahan,'0',',','.');


	array_push($response["detail_tambahan_list"], $gt);
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "transaksi_penjualan_list_item":


	$no_nota =  $_GET['no_nota'];
	$query = $koneksi->prepare(" SELECT 	
								a.*,
								b.label AS jenis_beras

								FROM item_transaksi a
								LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id
								
								WHERE a.no_nota = '$no_nota'
								ORDER by a.id ASC");
	
	$no = 0;
	$response = array();
	$response["tmp_penjualan_list"] = array();
	$response["detail_penjualan_list"] = array();
	$total					= 0;
	$total_komisi			= 0;
	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

			/* if ( $x->discount > 0 ){
				$potongan   = ($x->discount/100)*$x->harga;
				$jumlah		= ($x->harga-$potongan)*$x->outcome;
			}else{
				$jumlah		= $x->harga*$x->outcome;
			} */

			$jumlah	 		= $x->qty*$x->tonase*$x->harga  ;
			$komisi 		= $x->qty*$x->tonase*$x->komisi ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['nama_karung']	= $x->nama_karung;
			$h['jenis_beras']	= $x->jenis_beras;
			$h['qty']			= $x->qty;
			$h['tonase']		= $d->tonase($x->tonase);
			$h['komisi']		= $x->komisi;
			$h['harga']			= number_format($x->harga,'0',',','.');
			
			$h['jumlah']		= number_format($jumlah,'0',',','.');
							
							
			array_push($response["tmp_penjualan_list"], $h);

			$total				= $total + $jumlah;
			$total_komisi		= $total_komisi + $komisi;
	}	



	$gt['total']				= number_format($total,'0',',','.');

	$gt['total_komisi']			= number_format($total_komisi,'0',',','.');


	array_push($response["detail_penjualan_list"], $gt);
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case"detail_transaksi_penjualan":

	$penjualan_id = $_GET['penjualan_id'];
	$query = $koneksi->prepare(" SELECT 	
								a.id as penjualan_id,
								a.no_nota,
								a.tgl_nota,
								a.type_bayar,
								a.total_belanja,
								a.total_komisi,
								a.total_tambahan,
								a.bayar,
								a.keterangan,
								b.nama as nama_pelanggan,
								b.no_tlp,
								b.alamat,
								c.nama as nama_user

								
								FROM penjualan a 
								LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
								LEFT JOIN users c ON c.id = a.user_id


								WHERE a.id = 	'$penjualan_id'	
								
								
								LIMIT 1 ");


		
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);

	if ($x){
		
		/* if ( $x->komisi > 0 ){
			$besar_komisi = ($x->komisi/100)*$x->grand_total;
			$kembali 	  = number_format(($x->bayar-$x->grand_total)+$besar_komisi,'0',',','.');
		}else{
			$kembali 	  = number_format($x->bayar-$x->grand_total,'0',',','.');
			$besar_komisi = 0;
		}
		 */
		$total_bayar = ($x->total_belanja-$x->total_komisi)+$x->total_tambahan;
		$kembali 	 = $x->bayar - $total_bayar;

		$detail_penjualan = array(
					'no_nota'		=> $x->no_nota,
					'tgl_nota'		=> $d->tgl($x->tgl_nota),
					'jam'			=> $d->jam($x->tgl_nota),
					'nama_pelanggan'=> $x->nama_pelanggan,
					'no_tlp'		=> $x->no_tlp,
					'status'		=> $x->type_bayar,
					'nama_user'		=> $x->nama_user,
					'total_belanja'	=> number_format($x->total_belanja,'0',',','.'),
					'total_komisi'	=> number_format($x->total_komisi,'0',',','.'),
					'total_tambahan'=> number_format($x->total_tambahan,'0',',','.'),
					'total_bayar'   => number_format($total_bayar,'0',',','.'),
					'bayar'			=> number_format($x->bayar,'0',',','.'),
					'kembali'		=> number_format($kembali,'0',',','.'),
					'sisa'		    => number_format(str_replace('-','',$kembali),'0',',','.'),
					
					'keterangan'	=> $x->keterangan,
					'keterangan'	=> $x->keterangan

		);

	}else{
		
		$detail_penjualan = array(
			'no_nota'		=> "",
			'tgl_nota'		=> "",
			'jam'			=> "",
			'nama_pelanggan'=> "",
			'no_tlp'		=> "",
			'status'		=> "",
			'nama_user'		=> "",
			'grand_total'	=> "",
			'bayar'			=> "",
			'komisi'		=> "",
			'keterangan'	=> "",
			'sisa'			=> "",
			'kembali'		=> "",
			'besar_komisi'	=> "",
			"keterangan"	=> ""
		);

	}
	
				
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
		echo json_encode($detail_penjualan);
				
	}else{
				header('HTTP/1.1 400 error'); //if error
	}

break;
case "transaksi_tambahan_list_item":


	$no_nota =  $_GET['no_nota'];
	$query = $koneksi->prepare(" SELECT 	
								a.*
								FROM item_tambahan a
								
								WHERE a.no_nota = '$no_nota'
								ORDER by a.id ASC");
	
	$no = 0;
	$response = array();
	$response["tmp_tambahan_list"] = array();
	$response["tmp_tambahan_detail"] = array();
	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

			
			$no++;
			$h['no']			= $no;
			$h['item_tambahan']	= $x->item_tambahan;
			$h['qty']			= $x->qty;
			$h['harga_satuan']	= number_format($x->harga_satuan,'0',',','.');
			$h['qty']			= $x->qty;
			$h['jumlah']		= number_format($x->harga_satuan*$x->qty,'0',',','.');
							
							
			array_push($response["tmp_tambahan_list"], $h);
	}	

			if ( $no > 0){
				$x['data_table'] = 'show';
			}else{
				$x['data_table'] = 'hide';
			}
			array_push($response["tmp_tambahan_detail"], $x);
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
default;
header('HTTP/1.1 400 request error');
break;
}
?>