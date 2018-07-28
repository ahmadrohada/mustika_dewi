<?php
    $penjualan_id = isset($_GET['penjualan_id']) ? $_GET['penjualan_id'] : '';
?>
<input type="hidden" value="<?php echo $penjualan_id ?>" class="penjualan_id" id="penjualan_id" name="penjualan_id" >



<!-- Main content -->
<section class="content">
    <div class="row">


        <div class="col-md-3">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-tags"></i> Informasi Nota</h3>
                </div>
                
                <form class="form-horizontal">
                <div class="box-body" style="padding-left:20px;">
                    <div class="form-group">
                        <label class="col-sm-5 text-align">No Nota</label>
                        <div class="col-sm-7">
                            <span class="span_label no_nota"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 text-align">Tgl Transaksi</label>
                        <div class="col-sm-7">
                            <span class="span_label tgl_nota"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 text-align">Waktu</label>
                        <div class="col-sm-7">
                            <span class="span_label waktu"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 text-align">Pelanggan</label>
                        <div class="col-sm-7">
                            <span class="span_label nama_pelanggan"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 text-align">Status</label>
                        <div class="col-sm-7">
                            <span class="span_label status"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 text-align">User</label>
                        <div class="col-sm-7">
                            <span class="span_label nama_user"></span>
                        </div>
                    </div>
                    
                </div>
                <!-- /.box-footer -->
                </form>

                 
            </div>
        </div>

        <div class="col-md-9">
            
        
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-th-list"></i> Detail Transaksi Penjualan</h3>
                </div>
                <div class="box-body">
                    
                    
                    <div class="col-md-12" style="margin-top:10px;" >
                        <table
                            id="list_penjualan"
                            data-class="table table-striped table-hover" 
                            >
                        
                        </table>

                    </div>

                    <div class="col-md-12" style="margin-top:10px; text-align:right;">
                        <div class="col-md-8" style="margin-top:12px;">
                            <span class="grand_total_text" >Total</span>
                        </div>
                        <div class="col-md-4">
                            <span class="grand_total total_harga"></span>
                            
                        </div>
                        
                    </div>

                    <div class="col-md-12 no-padding" style="margin-top:10px; ">
                        <div class="col-md-7">
                           
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control keterangan" rows="2" placeholder="Keterangan tambahan" style="width:70%;" disabled></textarea>
                        </div>

                            
                        </div>
                        <div class="col-md-5">
                            <form class="form-horizontal">
                                <div class="form-group" >
                                    <label class="col-sm-4 control-label" >Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm bayar" style="text-align:right;" disabled>
                                    </div>
                                </div>

                                <!-- 
                                <div class="form-group" style="margin-top:-10px;">
                                    <label class="col-sm-4 control-label">Discount</label>
                                    <div class="col-sm-8">
                                        <div class="input-group " style="width:100px;" >
                                            <input type="text" value="0" class="form-control input-sm" style="text-align:center;">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                -->
                                <div class="form-group" style="margin-top:-10px;">
                                    <label class="col-sm-4 control-label">Komisi</label>
                                    <div class="col-sm-8">
                                        <div class="input-group "  >
                                            <input type="text" value="0" class="form-control input-sm komisi" style="text-align:center; width:40px;" disabled>
                                            <span class="input-group-addon">%</span>
                                            <input type="text" value="0" class="form-control input-sm besar_komisi" style="text-align:right;" disabled>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group"  style="margin-top:-10px;">
                                    <label class="col-sm-4 control-label"><span class="txt-kembali">Kembali</span></label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control input-sm kembali" value="0" style="text-align:right;" disabled>
                                    </div>
                                </div>
                            </form>
                           
                        </div>

                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<script>
$(document).ready(function () {
	
    penjualan_id = $('.penjualan_id').val();
    

    
    $.ajax({
			url         : "./kelas/penjualan_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'detail_transaksi_penjualan',penjualan_id:penjualan_id},
			success     : function(data) {

				$('.no_nota').html(data['no_nota']);
                $('.tgl_nota').html(data['tgl_nota']);
                $('.waktu').html(data['jam']);
                $('.nama_pelanggan').html(data['nama_pelanggan']);
                $('.status').html(data['status']);
                $('.nama_user').html(data['nama_user']);

                $('.bayar').val(data['bayar']);
                $('.komisi').val(data['komisi']);
                $('.besar_komisi').val(data['besar_komisi']);
                $('.keterangan').html(data['keterangan']);

                $('.total_harga').html(data['grand_total']);


                if ( data['status'] == 'kredit'){
                    $('.txt-kembali').html("Sisa Hutang");  
                    $('.kembali').val(data['sisa']);
                }else{
                    $('.kembali').val(data['kembali']);
                }

                

                

                load_data_penjualan(data['no_nota']);
				
			},
			error: function(data){
					
			}
	});

    $('#list_penjualan').bootstrapTable({
		columns:[	
				{
					field: 'no',
					title: 'NO',
					halign:'center',
					align:'center',
                    width:70,
				}, 
				{
					field: 'jenis_beras',
					title: 'JENIS BERAS',
					halign:'center'
					
				}, 
				{
					field: 'harga',
					title: 'HARGA',
					halign:'center',
                    align:'right',
                    width:120

					
                }, 
               /*  {
					field: 'discount',
					title: 'DISC (%)',
					halign:'center',
                    align:'center',
                    width:80

					
				},  */
				{
					field: 'qty',
					title: 'QTY / KG',
					halign:'center',
                    align:'center',
                    width:80
				}, 
                {
					field: 'jumlah',
					title: 'JUMLAH',
					halign:'center',
                    align:'right',
				}
				]
	});


    
    function load_data_penjualan(no_nota){
		
		$.ajax({
			url         : "./kelas/penjualan_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'transaksi_penjualan_list_item',no_nota:no_nota},
			success     : function(data) {
				
					$('#list_penjualan').bootstrapTable('load',{data: data['tmp_penjualan_list'] });
					$('[data-toggle="tooltip"]').tooltip();
					$('.fixed-table-loading').fadeOut(100);


                    //$('.total_harga').html(data['detail_penjualan_list'][0]['total']);
                  
				
			},
			error: function(data){
					$('#table').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
					$('#list_penjualan').bootstrapTable('removeAll');
				
			}
		});
    }

});
</script>		