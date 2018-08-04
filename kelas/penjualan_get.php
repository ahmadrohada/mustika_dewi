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
								a.grand_total,
								a.bayar,
								a.komisi,
								a.sisa,
								a.type_pembayaran,
								b.nama
								FROM penjualan a
								LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
								
								ORDER by a.tgl_nota DESC");
	
	$no = 0;
	$response = array();
	$response["penjualan_list"] = array();

	$query->execute();
	
	while($x = $query->fetch(PDO::FETCH_OBJ)) {

		
		if ( $x->sisa > 0) {
			$sisa_bayar = number_format($x->sisa,'0',',','.');
		}else{
			$sisa_bayar = "lunas";
		}

			$no++;
			$h['no']				= $no;
			$h['id']				= $x->nota_id;
			$h['tgl_nota']			= $d->tgl_jam($x->tgl_nota);
			$h['no_nota']			= $x->no_nota;
			$h['nama_pelanggan']	= $x->nama;


			$h['cash']				= number_format($x->bayar,'0',',','.');
			$h['total']				= number_format($x->grand_total,'0',',','.');
			$h['komisi']			= number_format($x->komisi,'0',',','.');
			$h['sisa']				= $sisa_bayar;
			$h['type_pembayaran']	= $x->type_pembayaran;
							
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
		
$query = $koneksi->prepare(" SELECT 	
									a.id,
									a.nama_karung,
									a.qty,
									a.tonase,
									a.harga,
									a.komisi,
									b.label AS jenis_beras

									FROM tmp_transaksi a
									LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id

									WHERE jenis_transaksi = 'penjualan'

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
				$jumlah		= ($x->harga-$potongan)*$x->qty;
			}else{
				$jumlah		= $x->harga*$x->qty;
			} */
			
			$jumlah	 		= $x->qty*$x->tonase*$x->harga  ;
			$komisi 		= $x->qty*$x->tonase*$x->komisi ;

			$no++;
			$h['no']			= $no;
			$h['id']			= $x->id;
			$h['nama_karung']	= $x->nama_karung;
			$h['jenis_beras']	= $x->jenis_beras;
			$h['qty']			= $x->qty;
			$h['tonase']		= $x->tonase;
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
			$h['tonase']		= $x->tonase;
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
								a.type_pembayaran,
								a.grand_total,
								a.bayar,
								a.komisi,
								a.keterangan,
								a.sisa,
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

		$detail_penjualan = array(
					'no_nota'		=> $x->no_nota,
					'tgl_nota'		=> $d->tgl($x->tgl_nota),
					'jam'			=> $d->jam($x->tgl_nota),
					'nama_pelanggan'=> $x->nama_pelanggan,
					'no_tlp'		=> $x->no_tlp,
					'status'		=> $x->type_pembayaran,
					'nama_user'		=> $x->nama_user,
					'grand_total'	=> number_format($x->grand_total,'0',',','.'),
					'bayar'			=> number_format($x->bayar,'0',',','.'),
					'komisi'		=> number_format($x->komisi,'0',',','.'),
					'keterangan'	=> $x->keterangan,
					'sisa'			=> number_format($x->sisa,'0',',','.'),
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

default;
header('HTTP/1.1 400 request error');
break;
}
?>