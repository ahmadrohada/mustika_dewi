<?php
	//header("Content-Type:application/json");
	session_start();

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');
	$tgl_now = date('Y'."-".'m'."-".'d');
	
	$d 		= New FormatTanggal();
	$n 		= New Nota();
	$s 		= New selisih();
		
	
$op				= isset($_GET['op'])?$_GET['op']:null;

switch($op){
case"dashboard_detail":

	$response["dashboard"] = array();

	//======penjualan today =================//
	$ttpt = $koneksi->prepare(" SELECT 	count(id) as jm FROM transaksi WHERE outcome > 0 and date(created_at) ='$tgl_now' ");
	$ttpt->execute();
	$total_transaksi_penjualan_today  = $ttpt->fetch(PDO::FETCH_OBJ);
	
    $h['total_transaksi_penjualan_today']	    = $total_transaksi_penjualan_today->jm;

	

	//======penjualan ALL =================//
	$ttp = $koneksi->prepare(" SELECT 	count(id) as jm FROM transaksi WHERE outcome > 0 ");
	$ttp->execute();
	$total_transaksi_penjualan  = $ttp->fetch(PDO::FETCH_OBJ);
	
    $h['total_transaksi_penjualan']	    = $total_transaksi_penjualan->jm;

	array_push($response["dashboard"], $h);
	
	


	

	if (mysql_errno() == 0){
		header('HTTP/1.1 200 Sukses'); //if sukses
		echo json_encode($response);
				
	}else{
		header('HTTP/1.1 400 error'); //if error
	}

break;
case"chart_stok":

		$query = $koneksi->prepare(" SELECT 	
								        a.id as jenis_beras_id,
								        a.label
								        FROM jenis_beras a

								        ORDER by a.label ASC ");

				
            $no = 0;
            $response["jenis_beras"] = array();
			$query->execute();
			while($x = $query->fetch(PDO::FETCH_OBJ)) {

                //cari jumlah kg nya
                $stok_out_query = $koneksi->prepare(" SELECT 	sum(outcome) as jm FROM transaksi WHERE jenis_beras_id = '$x->jenis_beras_id' ");
				$stok_out_query->execute();
				$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_OBJ);

                $h['jenis_beras']	= $x->label;
                $h['jumlah']	    = $stok_total_out->jm;

                array_push($response["jenis_beras"], $h);
			}	
                
         


			if (mysql_errno() == 0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($response);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
case"chart_penjualan_today":

		$query = $koneksi->prepare(" SELECT 	
								        a.id as jenis_beras_id,
								        a.label
								        FROM jenis_beras a

								        ORDER by a.label ASC ");

				
            $no = 0;
            $response["jenis_beras"] = array();
			$query->execute();
			while($x = $query->fetch(PDO::FETCH_OBJ)) {

				//cari jumlah kg nya dalam transaksi
				
                $stok_out_query = $koneksi->prepare(" SELECT sum(outcome) AS jm FROM transaksi WHERE jenis_beras_id = '$x->jenis_beras_id' and date(created_at) ='$tgl_now' ");
				$stok_out_query->execute();
				$stok_total_out  = $stok_out_query->fetch(PDO::FETCH_OBJ);

                $h['jenis_beras']	= $x->label;
                $h['jumlah']	    = $stok_total_out->jm;

                array_push($response["jenis_beras"], $h);
			}	
                
         


			if (mysql_errno() == 0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($response);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;

case"chart_penjualan_setahun":

	$no = 0;
    $response["penjualan_all"] = array();
	


	$warna = [ "white","#FF0F00","#FF6600","#FF9E01","#FCD202","#F8FF01","#B0DE09","#04D215","#0D8ECF","#0D52D1","#2A0CD0","#8A0CCF","#CD0D74"];
	

	for ( $i=1 ; $i <= 12 ; $i++) {

		$bulan = $i;

		$total_penjualan = $koneksi->prepare(" SELECT sum(outcome) AS jm FROM transaksi WHERE MONTH(created_at) = '$bulan' ");
		$total_penjualan->execute();
		$total_out  = $total_penjualan->fetch(PDO::FETCH_OBJ);

				$h['bulan']	    			= $d->bulan($bulan);
				$h['total_penjualan']	    = $total_out->jm;
				$h['color']	    			= $warna[$i];

                array_push($response["penjualan_all"], $h );
	}	
                
         


			if (mysql_errno() == 0){
				header('HTTP/1.1 200 Sukses'); //if sukses
				echo json_encode($response);
				
			}else{
				header('HTTP/1.1 400 error'); //if error
			}

break;
}
?>