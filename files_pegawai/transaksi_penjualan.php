
<?php
	$user_id = isset($_SESSION['md_user_id']) ? $_SESSION['md_user_id'] : '';
?>




<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-tags"></i> Informasi Nota Penjualan</h3>
                </div>
                <div class="box-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Nota</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm no_nota" id="no_nota" style="margin-top:3px;" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm tgl_nota" id="tgl_nota"  style="margin-top:3px;"  readonly>
                        </div>
                    </div>

                    <input type="hidden" value="<?php echo $user_id ?>" class="user_id" id="user_id" name="user_id" >

                    

                </form>
                </div>
            </div>



            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-users"></i> Informasi Pelanggan</h3>
                    <div class="box-tools pull-right">
                        <span  data-toggle="tooltip" title="Tambah Pelanggan"><a  style="margin-top:5px !important;" class="btn btn-warning btn-xs add_pelanggan" data-toggle="modal" data-target=".add-pelanggan"><i class="fa fa-plus" ></i></a></span>
                    </div>
                </div>
                <div class="box-body">
                
                    <div class="form-group nama ">
                        <label>Nama Pelanggan</label>
                        <select  class="form-control pelanggan_id" name="pelanggan_id" id="pelanggan" style="width:100%;"></select>
                    </div>

                    <div class="detail_pelanggan" hidden>
                        <div class="form-group nama ">
                            <label>No Tlp / HP</label>
                            <span class="form-control no_tlp"></span>
                        </div>

                        <div class="form-group nama ">
                            <label>Alamat</label>
                            <span class="form-control alamat" rows="2" placeholder="alamat" style="height:50px; width:100%;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            
        
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-th-list"></i> Transaksi Penjualan</h3>
                </div>
                <div class="box-body">
                    
                       
                 
                    <div class="col-md-12" style="margin-top:10px;">



                         <div id="toolbar">
                            <span  data-toggle="tooltip" title="Tambah Item Penjualan"><a class="btn btn-warning btn-sm add_item_penjualan" data-toggle="modal" data-target=".add-item_penjualan"><i class="fa fa-plus" ></i> TAMBAH ITEM</a></span>
					    </div>
                        <table
                            id="list_penjualan"
                            class="table-striped" 
							data-toolbar="#toolbar"
							data-toolbar-align="right"  
                            >
                        
                        </table>




                    </div>

                    <div class="col-md-12" style="margin-top:10px; text-align:right;">
                        <div class="col-md-8" style="margin-top:6px;">
                            <span class="grand_total_text" >Total</span>
                        </div>
                        <div class="col-md-4">
                            <span class="grand_total total_harga"></span>
                            <input type="hidden" class="grand_total">
                        </div>
                        
                    </div>

                    <div class="col-md-12 no-padding" style="margin-top:10px; ">
                        <div class="col-md-7">
                           
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control keterangan" rows="2" placeholder="Keterangan tambahan" style="width:100%;"></textarea>
                        </div>







                            
                        </div>
                        <div class="col-md-5">
                            <form class="form-horizontal">

                                <div class="form-group" >
                                    <label class="col-sm-6 control-label" >Bayar</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form_bayar form-control input-sm bayar"  value="" id="bayar" style="text-align:right;">
                                    </div>
                                </div>

                                <div class="form-group" style="margin-top:20px;">
                                    <label class="col-sm-6 control-label">Total Komisi</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control input-sm total_komisi" value="0" style="text-align:right;" disabled> 
                                    </div>
                                </div> 


                                

                                <div class="form-group"  style="margin-top:-10px;">
                                    <label class="col-sm-6 control-label">Kembali</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control input-sm kembali" value="0" style="text-align:right;" disabled>
                                    </div>
                                </div>
                            </form>
                           
                        </div>

                        
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-warning simpan_transaksi" style="margin-top:24px;" disabled>SIMPAN</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>



<?php
    include "modals/add-pelanggan.php";
    include "modals/add-penjualan.php";
?>





<script>

    

	
	/* Fungsi */
	function formatRupiah(angka, prefix)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
    
$(document).ready(function () {
	
    user_id = $('.user_id').val();
   
    $('.add-item_penjualan').on('hidden.bs.modal', function(){
		load_data_penjualan();
	});
 

    $.ajax({
			url         : "./kelas/new_transaksi_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'new_transaksi_penjualan',user_id:user_id},
			success     : function(data) {

				$('.no_nota').val(data['no_nota']);
                $('#tgl_nota').val(data['tgl_nota']);
                $('#nama_user').val(data['nama_user']);

                
				
			},
			error: function(data){
					
			}
	});

//=========================  P E L A N G G A N  =============================// 

    $('#pelanggan').select2({
        
        allowClear          : true,
        ajax: {
            url: './kelas/pelanggan_get.php',
            dataType: 'json',
            quietMillis: 250,
            data: function (params) {
                var queryParameters = {
                    op: 'pelanggan_list',
                    nama: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text: item.nama,
						    id: item.id,
                        }
                        
                    })
                };
            }
        }
    });

    $("#pelanggan").change(function(){
        var pelanggan_id = $("#pelanggan option:selected").val();
        $.ajax({
            url     : "./kelas/pelanggan_get.php",
            type    : "GET",
            dataType: "json",
            data    : { op  : "detail_pelanggan", pelanggan_id : pelanggan_id },
            success: function (data) {
                

                $(".no_tlp").html(data['no_tlp']);
                $(".alamat").html(data['alamat']);

                $('.detail_pelanggan').show(); 

                $('.simpan_transaksi').prop('disabled',false); 
            },
            error: function (data) {
                $('.simpan_transaksi').prop('disabled',true);
                $('.detail_pelanggan').hide(); 
            }
        }); 
    });

   
    //======================== TABLE   ===================================//
    $('#list_penjualan').bootstrapTable({
		columns:[	
				{
					field: 'no',
					title: 'NO',
					halign:'center',
					align:'center',
                    width:30,
				}, 
				
                {
					field: 'nama_karung',
					title: 'NM KARUNG',
					halign:'center',
                    align:'center',
					
				}, 
                {
					field: 'jenis_beras',
					title: 'JENIS BERAS',
					halign:'center'
					
				}, 
                {
					field: '',
					title: 'QTY KARUNG',
					halign:'center',
                    align:'center',
                    width  : 80,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'"  value="'+row.qty+'"  class="form-control input-sm tbl_qty" style="width:80px; text-align:center; margin-top:-4px;">' 
								];
					}
					
				}, 
                {
					field: '',
					title: '@TONASE',
					halign:'center',
                    align:'center',
                    width  : 80,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'"  value="'+row.tonase+'"  class="form-control input-sm tbl_tonase" style="width:80px; text-align:center; margin-top:-4px;">' 
								];
					}
					
				}, 
				{
					field: '',
					title: 'HARGA @Kg',
					halign:'center',
                    align:'center',
                    width:100,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'" value="'+row.harga+'" class="form-control input-sm tbl_harga" style="width:100px; text-align:right; margin-top:-4px;">' 
								];
					}

					
                }, 
                {
					field: '',
					title: 'KOMISI @Kg',
					halign:'center',
                    align:'center',
                    width:100,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'" value="'+row.komisi+'" class="form-control input-sm tbl_komisi" style="width:100px; text-align:right; margin-top:-4px;">' 
								];
					}

					
                }, 
                {
					field: 'jumlah',
					title: 'JUMLAH HARGA',
					halign:'center',
                    align:'right',
				}, 
				{
					field: 'Status',
					title: '<i class="glyphicon glyphicon-cog"></i>',
					halign:'center',
					align:'center',
					width:60,
					formatter: function (value, row) {
					    return 	[  	'<button  style="margin-top:-4px;" class="btn btn-danger btn-xs tbl_hapus" value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Hapus"><span class="fa fa-remove"></span></button>' 
									
								];
					}
				}
				]
	});



//==================== UPDATE QTY PADA TABLE ====================================//

    $(document).on('keydown','.tbl_qty',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            
            qty = $(this).val();
            id = $(this).attr('id');
            update_qty_table(id,qty);
            

        } 
    });


    $(document).on('blur','.tbl_qty',function(e){
            qty = $(this).val();
            id = $(this).attr('id');
            update_qty_table(id,qty);
    });

    function update_qty_table(id,qty){
        $.ajax({
                url         :"./kelas/item_post.php",
                type        : "POST",
                data        :{op:"update_qty_tmp",qty:qty,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                },
        }); 

    }
//=============================================================================//



//==================== UPDATE TONASE  PADA TABLE ====================================//
 $(document).on('keydown','.tbl_tonase',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            tonase = $(this).val();
            id = $(this).attr('id');
            update_tonase_table(id,tonase);
        } 
    });

    $(document).on('blur','.tbl_tonase',function(e){
            tonase = $(this).val();
            id = $(this).attr('id');
            update_tonase_table(id,tonase);
    });

    function update_tonase_table(id,tonase){
        $.ajax({
                url         :"./kelas/item_post.php",
                type        : "POST",
                data        :{op:"update_tonase_tmp",tonase:tonase,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                },
        }); 

    }

//=============================================================================//



//==================== UPDATE HARGA  PADA TABLE ====================================//
$(document).on('keydown','.tbl_harga',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            harga = $(this).val();
            id = $(this).attr('id');
            update_harga_table(id,harga);
        } 
    });

    $(document).on('blur','.tbl_harga',function(e){
            harga = $(this).val();
            id = $(this).attr('id');
            update_harga_table(id,harga);
    });

    function update_harga_table(id,harga){
        $.ajax({
                url         :"./kelas/item_post.php",
                type        : "POST",
                data        :{op:"update_harga_tmp",harga:harga,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                },
        }); 

    }

//=======================================================================//
//==================== UPDATE KOMISI  PADA TABLE ====================================//
$(document).on('keydown','.tbl_komisi',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            komisi = $(this).val();
            id = $(this).attr('id');
            update_komisi_table(id,komisi);
        } 
    });

    $(document).on('blur','.tbl_komisi',function(e){
        komisi = $(this).val();
            id = $(this).attr('id');
            update_komisi_table(id,komisi);
    });

    function update_komisi_table(id,komisi){
        $.ajax({
                url         :"./kelas/item_post.php",
                type        : "POST",
                data        :{op:"update_komisi_tmp",komisi:komisi,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                },
        }); 

    }


//==============================================================================//
//==================== HAPUS ITEM PEMBELIAN  ====================================//
    $(document).on('click','.tbl_hapus',function(e){
        //e.preventDefault();
		tmp_transaksi_id = $(this).val();
		$.ajax({
			url         :"./kelas/item_post.php",
			type        : "POST",
			data        :{op:"delete_from_tmp",tmp_transaksi_id:tmp_transaksi_id},
			cache       :false,
			success:function(data){
                load_data_penjualan();
			},
		});
		
    });

//====================== TABLE LIST ITEM ===================================//   
    load_data_penjualan();
    function load_data_penjualan(){
		
		$.ajax({
			url         : "./kelas/penjualan_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'tmp_penjualan_list'},
			success     : function(data) {
				
					$('#list_penjualan').bootstrapTable('load',{data: data['tmp_penjualan_list'] });
					$('[data-toggle="tooltip"]').tooltip();
					$('.fixed-table-loading').fadeOut(100);


                    $('.total_harga').html(data['detail_penjualan_list'][0]['total']);
                    $('.grand_total').val(data['detail_penjualan_list'][0]['total']);

                    $('.total_komisi').val(data['detail_penjualan_list'][0]['total_komisi']);

                    $('.bayar').val("");
                    $('.kembali').val("0");
				
			},
			error: function(data){
					$('#list_penjualan').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
				
			}
		});
    }



//=============================== B   A   Y   A   R ========================================//
    document.addEventListener('keydown', function(event) {
        if (event.code == 'F2') {
            $('.bayar').focus();
            //$('.jenis_beras').select2('close');
        }
    });


    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('bayar');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
        tanpa_rupiah.value = formatRupiah(this.value);
        
	});
	

    $(document).on('keydown','.bayar',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            hitung_kembalian();
        } 
    });

     $(document).on('blur','.bayar',function(e){
        hitung_kembalian();
    });

    function hitung_kembalian(bayar,grand_total){

        bayar       = parseInt($(".bayar").val().replace(/[^,\d]/g, '').toString());
        grand_total = parseInt($(".grand_total").val().replace(/[^,\d]/g, '').toString());
        if (bayar < grand_total){
           
            total_komisi    = parseInt($(".total_komisi").val().replace(/[^,\d]/g, ''));
            kembali = Intl.NumberFormat().format(total_komisi+bayar-grand_total); 

            $(".kembali").val(kembali);
            
        }else if (bayar >= grand_total){
            
            total_komisi    = parseInt($(".total_komisi").val().replace(/[^,\d]/g, '').toString());
            kembali         = Intl.NumberFormat().format((bayar-grand_total)+total_komisi); 

            $(".kembali").val(kembali);
        }else{
            total_komisi    = parseInt($(".total_komisi").val().replace(/[^,\d]/g, '').toString());
            kembali         = Intl.NumberFormat().format(( 0 -grand_total)+total_komisi); 

            $(".kembali").val(kembali);
        } 
    }


//============================== PROSES SIMPAN TRANSAKSI =============================//
    $(document).on('click','.simpan_transaksi',function(e){
        e.preventDefault();
        user_id             = $(".user_id").val();
        pelanggan_id        = $("#pelanggan").val();
        no_nota             = $(".no_nota").val();

        grand_total         = parseInt($(".grand_total").val().replace(/[^,\d]/g, '').toString());
        bayar               = parseInt($(".bayar").val().replace(/[^,\d]/g, '').toString());
        total_komisi        = parseInt($(".total_komisi").val().replace(/[^,\d]/g, '').toString());

        kembali             = $(".kembali").val();

        hutang             = $(".kembali").val().replace('-', '');

       

        if ( grand_total == 0 ){
           
            swal({
				
				text: "Tidak Ada List Barang yang dibeli",
				type: "warning"
			}).then (function(){
                	
			});
        }else if ( pelanggan_id == null ){
            swal({
				
				text: "Nama pelanggan harus diisi",
				type: "warning"
			}).then (function(){
                $('#pelanggan').select2('open');		
			});
            
        }else if ( $(".bayar").val() == "") {
            swal({
				
				text: "Kolom bayar harus terisi",
				type: "warning"
			}).then (function(){
                $('.bayar').focus();		
			});
        }else if ( (bayar < grand_total)&(kembali != 0) ){


            swal({
				
                html                : "Pembayaran yang dilakukan kurang dari Jumlah yang harus dibayar"
                                    +"<br>Transaksi ini akan dianggap sebagai hutang<br>"
                                    +"sisa yang belum dibayar sebesar Rp. <b>"+hutang+"</b><br>",
				type                : "question",
                //customClass         : 'swal2-overflow',
                showCancelButton	: true,
                cancelButtonText	: "Batal",
			}).then (function(){
                simpan_transaksi('hutang');	
                
			}); 


        }else{
            simpan_transaksi('tunai');
        }
         
    });


    function simpan_transaksi(type_pembayaran){
        user_id             = $(".user_id").val();
        pelanggan_id        = $("#pelanggan").val();
        no_nota             = $(".no_nota").val();

        grand_total         = $(".grand_total").val();
        bayar               = $(".bayar").val();
        total_komisi        = $(".total_komisi").val();
        kembali             = $(".kembali").val();
        hutang             = $(".kembali").val().replace('-', '');

        keterangan          = $(".keterangan").val();


          $.ajax({
			url         : "./kelas/transaksi_post.php",
			type        : "POST",
			data        : { op           : "simpan_transaksi_penjualan",
                            user_id      : user_id,
                            pelanggan_id : pelanggan_id, 
                            no_nota      : no_nota,
                            grand_total  : grand_total,
                            bayar        : bayar,
                            total_komisi : total_komisi,
                            type_pembayaran: type_pembayaran,
                            kembali      : kembali,
                            hutang       : hutang,
                            keterangan   : keterangan
                          },
			cache       :false,
			success:function(data){
                swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer: 900
					}).then(function () {
										
					},
					function (dismiss) {
						if (dismiss === 'timer') {
                            window.location.assign("home.php?page=penjualan");
						}
					}
				)
                
			
			},
            error: function(e) {
					swal({
						title: "Gagal",
						text: "",
						type: "warning"
					}).then (function(){
						
					});
				}
		}); 
    }



   
});
</script>		