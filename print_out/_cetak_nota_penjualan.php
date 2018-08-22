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

	$penjualan_id 			= isset($_GET['penjualan_id'])?$_GET['penjualan_id']: '0';
	
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
								c.nama as nama_user

								
								FROM penjualan a 
								LEFT JOIN pelanggan b ON b.id = a.pelanggan_id
								LEFT JOIN users c ON c.id = a.user_id


								WHERE a.id = 	'$penjualan_id'	
								
								
								LIMIT 1 ");


		
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);
	
	
?>

<table class="kop" border="1" >
<tr>
	<td style="height:25px;">
	<FONT style=" font-size:13pt; font-weight:bold; font-family:norasi;  ">TOKO BERAS MUSTIKA DEWI</FONT>
	</td>
</tr>
<tr>
	<td >
		<FONT style="font-size:10pt; font-family:norasi; ">PASAR INDUK JOHAR - KARAWANG</FONT>
	</td>
</tr>
</table>








<table class="kop" border="1">
<tr>
	<td colspan="6" align="center" valign="top" style="height:40px;">
		<FONT style=" font-size:13pt; font-weight:bold; font-family:Trebuchet MS; letter-spacing:1.2pt;  "><u>NOTA PENJUALAN</u></FONT>
	</td>
</tr>
<tr>
	<td width="13%">
		<FONT style=" font-size:9pt;  font-weight:bold; font-family:dejavuserif;">
			No Nota
		</font>
	</td>
	<td width="2%">:</td>
	<td width="47%">
		<FONT style=" font-size:9pt;  font-weight:bold; font-family:dejavusansmono;">
			<?php  echo $x->no_nota; ?>
		</font>
	</td>
	<td width="20%">
		<FONT style=" font-size:9pt;font-family:dejavuserif;">
		Nama Pelanggan
		</font>
	</td>
	<td width="2%">:</td>
	<td width="18%">
		<FONT style=" font-size:9pt; font-family:dejavusansmono;">
			<?php  echo $x->nama_pelanggan; ?>
		</font>
	</td>
</tr>
<tr>
	<td>
		<FONT style=" font-size:9pt; font-family:dejavuserif;">
			Tgl Transaksi
		</font>
	</td>
	<td>:</td>
	<td>
		<FONT style=" font-size:9pt; font-family:dejavusansmono;">
			<?php  echo $d->tgl_jam($x->tgl_nota); ?>
		</font>
	</td>
	<td>
		<FONT style=" font-size:9pt;font-family:dejavuserif;">
		Alamat
		</font>
	</td>
	<td>:</td>
	<td>
		<FONT style=" font-size:9pt; font-family:dejavusansmono;">
			karawang
		</font>
	</td>
</tr>
<tr>
	<td>
		<FONT style=" font-size:9pt; font-family:dejavuserif;">
			Pembayaran
		</font>
	</td>
	<td>:</td>
	<td>
		<FONT style=" font-size:9pt; font-family:dejavusansmono;">
			<?php  echo strtoupper($x->type_bayar); ?>
		</font>
	</td>
	<td>
		
	</td>
	<td></td>
	<td>
	
	</td>
</tr>


</table>


	<table class="cetak_report" style="margin-top:15px;" width="100%">
	<thead>
		<tr>
            <th width="5%">NO</th>
            <th >JENIS BERAS</th>
            <th width="12%">QTY (Kg)</th>
            <th width="16%">HARGA</th>
           <!--  <th width="10%">DISC %</th>
			<th width="16%">DISC (Rp)</th> -->
			<th width="18%">JUMLAH</th>
		</tr>
	</thead>

	<?php
	
	$query = $koneksi->prepare(" SELECT 	
									a.id,
									a.harga,
									a.qty,
									b.label AS jenis_beras

									FROM item_transaksi a
									LEFT JOIN jenis_beras b ON b.id = a.jenis_beras_id

									WHERE no_nota = '$x->no_nota'
									
									ORDER by a.id ASC");
		
		$no = 1;
		$total	= 0;
		$query->execute();
		
		while($dt = $query->fetch(PDO::FETCH_OBJ)) {
			$potongan = ($dt->discount/100)*$dt->harga;

				/* echo "<tr>
						<td align='center'>".$no."</td>
						<td style='font-family:dejavusansmono;'>".$dt->jenis_beras."</td>
						<td style='font-family:dejavusansmono;' align='center'>".$dt->qty."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format($dt->harga,'0',',','.')."</td>
						<td style='font-family:dejavusansmono;' align='center'>".$dt->discount."</td>
						<td style='font-family:dejavusansmono;' align='right'>".$potongan."</td>  
						<td style='font-family:dejavusansmono;' align='right'>".number_format(($dt->harga-$potongan)*$dt->qty,'0',',','.')."</td>
					</tr>";	 */		

					echo "<tr>
						<td align='center'>".$no."</td>
						<td style='font-family:dejavusansmono;'>".$dt->jenis_beras."</td>
						<td style='font-family:dejavusansmono;' align='center'>".$dt->qty."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format($dt->harga,'0',',','.')."</td>
						<td style='font-family:dejavusansmono;' align='right'>".number_format(($dt->harga)*$dt->qty,'0',',','.')."</td>
					</tr>";	
					

			$total				= $total + ($dt->harga*$dt->qty);
			$no++;
		}	

	
	?>

	</table>

<table class="kop" border="0" style="margin-top:10px;">
	<tr>
		<td width="60%">
			<font style=" font-size:10pt; font-family:dejavuserif;">
				Keterangan : 
			</font>
		</td>
		<td align="right"  width="20%">
			<font style=" font-size:10pt;  font-weight:bold; font-family:dejavuserif;">
				TOTAL
			</font>
		</td>
		<td width="3%">:</td>
		<td align="right" width="19%">
			<font style=" font-size:11pt;  font-weight:bold; font-family:dejavusansmono;">
				<?php  echo number_format($x->grand_total,'0',',','.'); ?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<font style=" font-size:10pt; font-family:dejavusansmono;">
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
		//$mpdf = new mPDF('c','A5-L','');
		$mpdf = new mPDF('utf-8', array(90,140), 0,0,5,5,5);

		$mpdf->SetHTMLFooter('
		<table width="100%">
			<tr>
				<td width="50%" style="text-align: left; font-size:10px;">Nama User: '.$x->nama_user.'</td>
				<td width="50%" style="text-align: right; font-size:10px;">Tgl cetak: '.$d->balik($tgl).'  / '.$waktu.'</td>
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
		
		
		