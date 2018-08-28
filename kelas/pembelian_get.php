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
case "pembelian_list":
		
	$query = $koneksi->prepare(" SELECT 	
								a.id as nota_id,
								a.no_nota,
								a.tgl_nota,
								a.user_id,
								a.supplier_id,
								a.total_harga,
								a.total_upah_kuli,
								a.type_bayar,
								a.jumlah_dp,
								a.keterangan,
								b.nama
								FROM pembelian a
								LEFT JOIN supplier b ON b.id = a.supplier_id
								
								ORDER by a.tgl_nota DESC");
	
	$no = 0;
	$response = array();
	$response["pembelian_list"] = array();

	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

		
		$jumlah_bayar  = $x->total_harga - $x->total_upah_kuli;

		switch($x->type_bayar)
			{
			case 1 : $type = 'Cash';
				break;
			case 2 : $type = 'Hutang';
				break;
			}
	
		if ( $x->type_bayar == '2'){
			$sisa 	= $jumlah_bayar - $x->jumlah_dp ; 
		}else{
			$sisa   =  0 ;
		}

			$no++;
			$h['no']				= $no;
			$h['id']				= $x->nota_id;
			$h['tgl_nota']			= $d->tgl_jam($x->tgl_nota);
			$h['no_nota']			= $x->no_nota;
			$h['nama_supplier']		= $x->nama;


			$h['total_harga']		= number_format($x->total_harga,'0',',','.');
			$h['total_upah_kuli']	= number_format($x->total_upah_kuli,'0',',','.');
			$h['jumlah_bayar']		= number_format($jumlah_bayar,'0',',','.');
			$h['type_bayar']		= $type;
			$h['sisa']			    = number_format($sisa,'0',',','.');
			$h['keterangan']		= $x->keterangan;
							
			array_push($response["pembelian_list"], $h);
	}	
		  
	if ( $no != 0){
		echo json_encode($response);
		//header('HTTP/1.1 200 Sukses'); //if sukses
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "tmp_pembelian_list":
	

	$no_nota =  $_GET['no_nota'];
	$query = $koneksi->prepare(" SELECT 	
								a.id,
								a.nama_karung,
								a.qty,
								a.tonase,
								a.harga,
								a.upah_kuli,
								b.label AS jenis_beras

								FROM tmp_transaksi a
								LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id

								WHERE jenis_transaksi = 'pembelian' AND no_nota = '$no_nota'
								
								ORDER by a.id ASC");
	
	$no = 0;
	$response = array();
	$response["tmp_pembelian_list"] = array();
	$response["detail_pembelian_list"] = array();
	$total					= 0;
	$total_upah_kuli		= 0;
	$total_bayar			= 0;
	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

			/* if ( $x->discount > 0 ){
				$potongan   = ($x->discount/100)*$x->harga;
				$jumlah		= ($x->harga-$potongan)*$x->qty;
			}else{
				$jumlah		= $x->harga*$x->qty;
			} */
			
			$jumlah	 		= $x->qty*$x->tonase*$x->harga  ;
			$upah 			= $x->qty*$x->tonase*$x->upah_kuli ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['nama_karung']	= $x->nama_karung;
			$h['jenis_beras']	= $x->jenis_beras;
			$h['qty']			= $x->qty;
			$h['tonase']		= $d->tonase($x->tonase);
			$h['upah_kuli']		= $x->upah_kuli;
			$h['harga']			= number_format($x->harga,'0',',','.');
			
			$h['jumlah']		= number_format($jumlah,'0',',','.');
							
			array_push($response["tmp_pembelian_list"], $h);

			$total				= $total + $jumlah;
			$total_upah_kuli	= $total_upah_kuli + $upah;
			
	}	



	$gt['total']				= number_format($total,'0',',','.');

	$gt['total_upah_kuli']		= number_format($total_upah_kuli,'0',',','.');
	$gt['total_bayar']			= number_format($total-$total_upah_kuli,'0',',','.');


	array_push($response["detail_pembelian_list"], $gt);
		  
	if (mysql_errno() == 0){
		echo json_encode($response);
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case "transaksi_pembelian_list_item":

	$no_nota =  $_GET['no_nota'];
	$query = $koneksi->prepare(" SELECT 	
						a.id,
						a.nama_karung,
						a.qty,
						a.tonase,
						a.harga,
						a.upah_kuli,
						b.label AS jenis_beras

						FROM item_transaksi a
						LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id

						WHERE a.no_nota = '$no_nota'

						ORDER by a.id ASC");

	$no = 0;
	$response = array();
	$response["tmp_pembelian_list"] = array();
	$response["detail_pembelian_list"] = array();
	$total					= 0;
	$total_upah_kuli		= 0;
	$total_bayar			= 0;
	$query->execute();

	while($x = $query->fetch(PDO::FETCH_OBJ)) {

			/* if ( $x->discount > 0 ){
			$potongan   = ($x->discount/100)*$x->harga;
			$jumlah		= ($x->harga-$potongan)*$x->qty;
			}else{
			$jumlah		= $x->harga*$x->qty;
			} */

			$jumlah	 		= $x->qty*$x->tonase*$x->harga  ;
			$upah 			= $x->qty*$x->tonase*$x->upah_kuli ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['nama_karung']	= $x->nama_karung;
			$h['jenis_beras']	= $x->jenis_beras;
			$h['qty']			= $x->qty;
			$h['tonase']		= $d->tonase($x->tonase);
			$h['upah_kuli']		= $x->upah_kuli;
			$h['harga']			= number_format($x->harga,'0',',','.');

			$h['jumlah']		= number_format($jumlah,'0',',','.');

			array_push($response["tmp_pembelian_list"], $h);

			$total				= $total + $jumlah;
			$total_upah_kuli	= $total_upah_kuli + $upah;

	}	



	$gt['total']				= number_format($total,'0',',','.');

	$gt['total_upah_kuli']		= number_format($total_upah_kuli,'0',',','.');
	$gt['total_bayar']			= number_format($total-$total_upah_kuli,'0',',','.');


	array_push($response["detail_pembelian_list"], $gt);

	if (mysql_errno() == 0){
		echo json_encode($response);
	}else{
		header('HTTP/1.1 400 error'); //if error
	}


break;
case"detail_transaksi_pembelian":

	$pembelian_id = $_GET['pembelian_id'];
	$query = $koneksi->prepare(" SELECT 	
								a.*,
								b.nama as nama_supplier,
								b.no_tlp,
								b.alamat,
								c.nama as nama_user

								
								FROM pembelian a 
								LEFT JOIN supplier b ON b.id = a.supplier_id
								LEFT JOIN users c ON c.id = a.user_id


								WHERE a.id = 	'$pembelian_id'	
								
								
								LIMIT 1 ");


		
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);

	if ($x){
		
		
		$detail_pembelian = array(
					'no_nota'		=> $x->no_nota,
					'tgl_nota'		=> $d->tgl($x->tgl_nota),
					'jam'			=> $d->jam($x->tgl_nota),
					'nama_supplier' => $x->nama_supplier,
					'no_tlp'		=> $x->no_tlp,
					'nama_user'		=> $x->nama_user,
					

		);

	}else{
		
		$detail_pembelian = array(
			'no_nota'		=> "",
			'tgl_nota'		=> "",
			'jam'			=> "",
			'nama_supplier' => "",
			'no_tlp'		=> "",
			'nama_user'		=> "",
		);

	}
	
				
	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
		echo json_encode($detail_pembelian);
				
	}else{
				header('HTTP/1.1 400 error'); //if error
	}

break;

default;
header('HTTP/1.1 400 request error');
break;
}
?>