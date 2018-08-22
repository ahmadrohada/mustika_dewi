<?php
session_start();
ob_start();
//Koneksi ke database

	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'../kelas/pustaka.php';
	require_once('../config/conn_pdo.php');

	date_default_timezone_set('Asia/Jakarta');
	$d 	= New FormatTanggal();
	$tgl = date('Y'."-".'m'."-".'d');
	$waktu = date('H'.":".'i'.":".'s');

	$penjualan_id 			= isset($_GET['penjualan_id'])?$_GET['penjualan_id']: 0;
	

	if ( $penjualan_id == 0 ){
		$query = $koneksi->prepare(" SELECT 	
						a.id as penjualan_id,
						a.no_nota,
						a.tgl_nota,
						a.type_bayar,
						a.total_belanja,
						a.total_komisi,
						a.total_tambahan,
						a.keterangan,
						b.nama as nama_pelanggan,
						b.alamat,
						b.no_tlp,
						c.nama as nama_user

						
						FROM penjualan a 
						LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
						LEFT JOIN users c ON c.id = a.user_id


						ORDER BY a.id DESC	
						
						
						LIMIT 1 ");
	}else{
		$query = $koneksi->prepare(" SELECT 	
				a.id as penjualan_id,
				a.no_nota,
				a.tgl_nota,
				a.type_bayar,
				a.total_belanja,
				a.total_komisi,
				a.total_tambahan,
				a.keterangan,
				b.nama as nama_pelanggan,
				b.alamat,
				b.no_tlp,
				c.nama as nama_user

				
				FROM penjualan a 
				LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
				LEFT JOIN users c ON c.id = a.user_id


				WHERE a.id = 	'$penjualan_id'	
				
				
				LIMIT 1 ");
	}
	


		
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);
	
	
?>

<table class="kop" border="0">
	<tr>
		<td width="54%" valign="top">
			<font style=" font-size:12pt; font-weight:bold; font-family:arial; letter-spacing:0.3pt;  ">PD. MUSTIKA DEWI</font>
		</td>
		<td width="22%" valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavuserif;">
				Tanggal
			</font>
		</td>
		<td width="1%" valign="top">:</td>
		<td width="22%" valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavusansmono;">
				<?php  echo $d->tgl($x->tgl_nota); ?>
			</font>
		</td>
	</tr>
	<tr>
		<td valign="bottom" >
			<font style=" font-size:7pt; font-family:arial; letter-spacing:0.4pt;">
			PASAR INDUK BERAS JOHAR NO. 4
			</font>
		</td>
		<td valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavuserif;">
				Tuan / Toko
			</font>
		</td>
		<td valign="top">:</td>
		<td valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavusansmono;">
				<?php  echo $x->nama_pelanggan; ?>
			</font>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<font style="font-size:7pt; font-family:arial; letter-spacing:0.2pt;">
			TLP. (0267) 414087 - 405903
			</font>
		</td>
		<td valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavuserif;">
				Tlp
			</font>
		</td>
		<td valign="top">:</td>
		<td valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavusansmono;">
				<?php  echo $x->no_tlp; ?>
			</font>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<font style="font-size:7pt; font-family:arial; letter-spacing:1pt;">
			KARAWANG
			</font>
		</td>
		<td valign="top" align="right">
			
		</td>
		<td valign="top"></td>
		<td valign="top" align="right">
			<font style=" font-size:7pt; font-family:dejavusansmono;">
				<?php  echo $x->no_tlp; ?>
			</font>
		</td>
	</tr>
	<tr height="40px;">
		<td colspan="4" valign="bottom" align="center">
			
		</td>
	</tr>
	<tr height="40px;">
		<td colspan="4" valign="bottom" align="center">
			<font style=" font-size:8pt; font-weight:bold; font-family:arial;">
				<u>NOTA PENJUALAN</u>
			</font>
		</td>
	</tr>

</table>
<br>

			<font style=" font-size:8pt; font-weight:bold; font-family:norasi;  ">Nota No : </font>
			<font style=" font-size:8pt; font-family:dejavusansmono;">
			 <?php  echo $x->no_nota; ?>
			</font>
	
	<table class="cetak_report" width="100%">
	<thead>
		<tr>
            <th width="14%">Banyak nya</th>
            <th width="">Nama Barang</th>
            <th width="18%">Harga Satuan</th>
			<th width="23%">Jumlah</th>
		</tr>
	</thead>
	<?php
	
	$query = $koneksi->prepare(" SELECT 	
									a.*,
									b.label AS jenis_beras

									FROM item_transaksi a
									LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id

									WHERE no_nota = '$x->no_nota'
									
									ORDER by a.id ASC");
		
		
		$query->execute();
		
		while($dt = $query->fetch(PDO::FETCH_OBJ)) {
				echo "<tr>
						<td style='font-family:dejavusansmono;' align='center'>".$dt->qty."</td>
							
						<td style='font-family:dejavusansmono;'>".$dt->nama_karung.'@'.$d->tonase($dt->tonase).' / '.$dt->qty*$dt->tonase. ' Kg'."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format($dt->harga,'0',',','.')."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format(($dt->harga*$dt->tonase)*$dt->qty,'0',',','.')."</td>
					</tr>";	
					

		}

		$query_2 = $koneksi->prepare(" SELECT 	
									a.*

									FROM item_tambahan a
									WHERE no_nota = '$x->no_nota'
									
									ORDER by a.id ASC");
		
		
		$query_2->execute();
		
		while($dt = $query_2->fetch(PDO::FETCH_OBJ)) {
				echo "<tr>
						<td style='font-family:dejavusansmono;' align='center'>".$dt->qty."</td>
							
						<td style='font-family:dejavusansmono;'>".$dt->item_tambahan."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format($dt->harga_satuan,'0',',','.')."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format(($dt->harga_satuan)*$dt->qty,'0',',','.')."</td>
						</tr>";	
					

		}

	
	?>

	</table>

<table class="kop" border="0" style="margin-top:10px;">
	<tr>
		<td width="60%">
			<font style=" font-size:8pt; font-family:dejavuserif;">
				Keterangan : 
			</font>
		</td>
		<td align="right"  width="20%">
			<font style=" font-size:9pt;  font-weight:bold; font-family:dejavuserif;">
				TOTAL
			</font>
		</td>
		<td width="3%"> </td>
		<td align="right" width="19%">
			<font style=" font-size:9pt;  font-weight:bold; font-family:dejavusansmono;">
				<?php  echo number_format(($x->total_belanja)+$x->total_tambahan,'0',',','.'); ?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<font style=" font-size:8pt; font-family:dejavusansmono;">
				<?php echo $x->keterangan; ?>
			</font>
		</td>
		<td colspan="3" >
			
		</td>
	</tr>
	<tr>
		<td>
			
		</td>
		<td colspan="3" >
			
		</td>
	</tr>
	<tr>
		<td>
			
		</td>
		<td colspan="3" >
			
		</td>
	</tr>
	
</table>

 
<?php
		
		$out = ob_get_contents();
		ob_end_clean();
		include("../mpdf/mpdf.php");
		$mpdf = new mPDF('utf-8', array(115,130), 0,0,14,12,5);

		$mpdf->SetHTMLFooter('
		<table width="100%" border="0">
			<tr>
				<td width="50%" style="text-align: left; font-size:6px;">Nama User: '.$x->nama_user.'</td>
				<td rowspan="2" width="50%" style="text-align: right; font-size:10px;font-family:dejavuserif; ">( H. ACEP.S )</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:6px;">Tgl cetak: '.$d->balik($tgl).'  / '.$waktu.'</td>
			</tr>
		</table>');
		//$mpdf->SetWatermarkImage('../assets/images/form/watermark.png');
		$mpdf->showWatermarkImage = true;
		
		$mpdf->shrink_tables_to_fit = 1;
		
		$mpdf->SetDisplayMode('fullpage');
		$stylesheet = file_get_contents('../assets/css/table_print.css');
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->WriteHTML($out);
		$mpdf->SetJS('this.print();');
		$filename=$x->no_nota.".pdf";//You might be not adding the extension, 
		$mpdf->Output($filename,'I');
		
		
?>
		
		
		