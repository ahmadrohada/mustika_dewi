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

	$pembelian_id 			= isset($_GET['pembelian_id'])?$_GET['pembelian_id']: 0;
	

	if ( $pembelian_id == 0 ){
		$query = $koneksi->prepare(" SELECT 	
						a.id as pembelian_id,
						a.no_nota,
						a.tgl_nota,
						a.total_harga,
						a.total_upah_kuli,
						a.keterangan,
						b.nama as nama_supplier,
						b.alamat,
						b.no_tlp,
						c.nama as nama_user

						
						FROM pembelian a 
						LEFT JOIN supplier b ON b.id = a.supplier_id
						LEFT JOIN users c ON c.id = a.user_id


						ORDER BY a.id DESC
						
						
						LIMIT 1 ");
	}else{
		$query = $koneksi->prepare(" SELECT 	
						a.id as pembelian_id,
						a.no_nota,
						a.tgl_nota,
						a.total_harga,
						a.total_upah_kuli,
						a.keterangan,
						b.nama as nama_supplier,
						b.alamat,
						b.no_tlp,
						c.nama as nama_user

						
						FROM pembelian a 
						LEFT JOIN supplier b ON b.id = a.supplier_id
						LEFT JOIN users c ON c.id = a.user_id


						WHERE a.id = 	'$pembelian_id'	
						
						
						LIMIT 1 ");
	}
	


		
	$query->execute();
	$x = $query->fetch(PDO::FETCH_OBJ);
	
	
?>

<table class="kop" border="0">
	<tr>
		<td width="50%" valign="bottom">
			<font style=" font-size:13pt; font-weight:bold; font-family:arial; letter-spacing:0.3pt;  ">PD. MUSTIKA DEWI</font>
		</td>
		<td width="22%" valign="top" align="right">
			<font style=" font-size:8pt; font-family:arial;">
				Tanggal
			</font>
		</td>
		<td width="1%" valign="top">:</td>
		<td width="26%" valign="top" align="right">
			<font style=" font-size:8pt; font-family:arial;">
				<?php  echo $d->tgl($x->tgl_nota); ?>
			</font>
		</td>
	</tr>
	<tr>
		<td valign="bottom" >
			<font style=" font-size:7pt; font-family:arial; letter-spacing:0.2pt;">
			PASAR INDUK BERAS JOHAR NO. 4
			</font>
		</td>
		<td valign="top" align="right">
			<font style=" font-size:8pt; font-family:arial;">
				Tuan / Toko
			</font>
		</td>
		<td valign="top">:</td>
		<td valign="top" align="right">
			<font style=" font-size:8pt; font-family:arial;">
				<?php  echo $x->nama_supplier; ?>
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
			<font style=" font-size:8pt; font-family:arial;">
				Tlp
			</font>
		</td>
		<td valign="top">:</td>
		<td valign="top" align="right">
			<font style=" font-size:8pt; font-family:arial;">
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
			
		</td>
	</tr>
	<tr height="40px;">
		<td colspan="4" valign="bottom" align="center">
			
		</td>
	</tr>
	<tr height="40px;">
		<td colspan="4" valign="bottom" align="center">
			<font style=" font-size:9pt; font-weight:bold; letter-spacing:1pt; font-family:arial;">
				NOTA PEMBELIAN
			</font>
		</td>
	</tr>

</table>
<br>

			<font style=" font-size:8pt;font-family:arial;  ">Nota No : </font>
			<font style=" font-size:8pt; font-family:arial;">
			 <?php  echo $x->no_nota; ?>
			</font>
	
	<table class="cetak_report" width="100%">
	<thead>
		<tr>
            <th width="14%">Banyak nya</th>
            <th width="">Nama Barang</th>
            <th width="15%">Harga Satuan</th>
			<th width="20%">Jumlah</th>
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
		$jm_karung = 0;
		$jm_tonase = 0;
		while($dt = $query->fetch(PDO::FETCH_OBJ)) {
				echo "<tr>
						<td align='center'><font style=' font-size:8pt; font-family:arial;'>".$dt->qty."</font></td>
							
						<td><font style=' font-size:8pt; font-family:arial;'>".$dt->nama_karung.'@'.$d->tonase($dt->tonase).' / '.$dt->qty*$dt->tonase. ' Kg'."</font></td>
						<td align='right'><font style=' font-size:8pt; font-family:arial;'>".number_format($dt->harga,'0',',','.')."</font></td>
						<td align='right'><font style=' font-size:8pt; font-family:arial;'>".number_format(($dt->harga*$dt->tonase)*$dt->qty,'0',',','.')."</font></td>
					</tr>";	


				if ( $dt->upah_kuli != '0'){
					echo "<tr>
						<td align='center'></td>
							
						<td><font style=' font-size:8pt; font-family:arial;'>Upah Kuli</font></td>
						<td align='right'><font style=' font-size:8pt; font-family:arial;'>".number_format($dt->upah_kuli,'0',',','.')."</font></td>
						<td align='right'><font style=' font-size:8pt; font-family:arial;'>".number_format(($dt->upah_kuli*$dt->tonase)*$dt->qty,'0',',','.')."</font></td>
					</tr>";	
				}
					

				$jm_karung = $jm_karung + $dt->qty;
				$jm_tonase = $jm_tonase + ($dt->qty*$dt->tonase);

				

		}

					echo "<tr>
							<td align='center'><font style=' font-size:8pt; font-family:arial;'>".number_format($jm_karung,'0',',','.')."</font></td>
								
							<td colspan='3'><font style=' font-size:8pt; font-family:arial;'>Total tonase ".number_format($jm_tonase,'0',',','.')." Kg</font></td>
							
					  	 </tr>";	
	
	?>

	</table>

<table class="kop" border="0" style="margin-top:10px;">
	<tr>
		<td width="60%">
			<font style=" font-size:8pt; font-family:arial;">
				Keterangan : 
			</font>
		</td>
		<td align="right"  width="20%">
			<font style=" font-size:9pt; font-family:arial;">
				TOTAL
			</font>
		</td>
		<td width="3%"> </td>
		<td align="right" width="19%">
			<font style=" font-size:9pt; font-family:arial;">
				<?php  echo number_format($x->total_harga-$x->total_upah_kuli,'0',',','.'); ?>
			</font>
		</td>
	</tr>
	<tr>
		<td>
			<font style=" font-size:8pt; font-family:arial;">
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
		$mpdf = new mPDF(   
				'c',    // mode - default ''
                'A6',    // format - A6, for example, default ''
                0,     // font size - default 0
                '',    // default font family
                5,    // margin_left
                6,    // margin right
                8,     // margin top
                20,    // margin bottom
                0,     // margin header
                23,     // margin footer
                'P' );  // L - landscape, P - portrait

		
		//$mpdf->SetWatermarkImage('../assets/images/form/watermark.png');
		$mpdf->showWatermarkImage = true;
		
		$mpdf->shrink_tables_to_fit = 1;
		
		$mpdf->SetDisplayMode('fullpage');
		$stylesheet = file_get_contents('../assets/css/table_print.css');
		$mpdf->WriteHTML($stylesheet,1);
		$mpdf->WriteHTML($out);
		$mpdf->SetJS('this.print();');
		$filename=$x->no_nota.".pdf";//You might be not adding the extension, 
		$mpdf->SetHTMLFooter('
		<table width="100%" border="0">
			<tr>
				<td width="50%" style="text-align: left; font-size:6px;"></td>
				<td rowspan="2" width="50%" style="text-align: right; font-size:8pt;font-family:arial; ">( H. ACEP.S )</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:6pt;font-family:arial;">Tgl cetak: '.$d->balik($tgl).'  / '.$waktu.'</td>
			</tr>
		</table>');
		$mpdf->Output($filename,'I');
		
		
?>
		
		