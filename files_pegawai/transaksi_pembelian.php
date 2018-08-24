
<?php
	$user_id = isset($_SESSION['md_user_id']) ? $_SESSION['md_user_id'] : '';
?>




<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-tags"></i> Informasi Nota Pembelian</h3>
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
                    <h3 class="box-title"><i class="fa  fa-users"></i> Informasi Supplier</h3>
                    <div class="box-tools pull-right">
                        <span  data-toggle="tooltip" title="Tambah Supplier"><a  style="margin-top:5px !important;" class="btn btn-warning btn-xs add_supplier" data-toggle="modal" data-target=".add-supplier"><i class="fa fa-plus" ></i></a></span>
                    </div>
                </div>
                <div class="box-body">
                
                    <div class="form-group nama ">
                        <label>Nama Supplier</label>
                        <select  class="form-control supplier_id" name="supplier_id" id="supplier" style="width:100%;">
                            <option value="1" selected>Cash</option>
                        </select>
                    </div>

                    <div class="detail_supplier" hidden>
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
                    <h3 class="box-title"><i class="fa  fa-th-list"></i> Transaksi Pembelian</h3>
                </div>
                <div class="box-body">
                    
                    
                    
                    <div class="col-md-12" style="margin-top:10px;">
                        
                  
                        <div id="toolbar">
                            <span  data-toggle="tooltip" title="Tambah Item Pembelian"><a class="btn btn-warning btn-sm add_item_pembelian" data-toggle="modal" data-target=".add-item_pembelian"><i class="fa fa-plus" ></i> TAMBAH ITEM</a></span>
					    </div>
                        <table
                            id="list_pembelian"
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
                            <input type="hidden" class="total_harga">
                        </div>
                        
                    </div>

                    <div class="col-md-12 no-padding" style="margin-top:10px; ">
                        <div class="col-md-7">
                           
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control keterangan" rows="2" placeholder="Keterangan tambahan" style="width:70%;"></textarea>
                        </div>



                            
                        </div>
                        <div class="col-md-5">
                            <form class="form-horizontal">
                                <div class="form-group" style="margin-top:20px;">
                                    <label class="col-sm-6 control-label">Total Upah Kuli</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control input-sm total_upah_kuli" value="0" style="text-align:right; margin-top:5px;" disabled>
                                    </div>
                                </div> 

                                <div class="form-group"  style="margin-top:-10px;">
                                    <label class="col-sm-6 control-label">Total Bayar</label>
                                    <div class="col-sm-6">
                                        <input type="text"  class="form-control input-sm total_bayar" value="0" style="text-align:right; margin-top:2px;" disabled>
                                    </div>
                                </div>

                                <div class="form-group"  style="margin-top:-10px;">
                                    <label class="col-sm-6 control-label">Type Bayar</label>
                                    <div class="col-sm-6">
                                       
                                        <select class="form-control type_bayar" name="type_bayar" style="width:100%">
                                            <option value="1" selected>Cash</option>
                                            <option value="2">Hutang</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group jumlah_dp"  style="margin-top:-10px;" hidden>
                                    <label class="col-sm-6 control-label">DP</label>
                                    <div class="col-sm-6">
                                        <input type="text"  id="dp" class="form_bayar form-control input-sm txt_jm_dp" value="" style="text-align:right;" name="jumlah_dp" style="text-align:right; margin-top:2px;">
                                    </div>
                                </div>


                            </form>
                           
                        </div>

                        
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-warning simpan_transaksi" style="margin-top:24px;">SIMPAN</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>



<?php
    include "modals/add-pembelian.php";
    include "modals/add-supplier.php";
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
   
    
    $('.add-item_pembelian').on('hidden.bs.modal', function(){
		load_data_pembelian();
	});

    $.ajax({
			url         : "./kelas/new_transaksi_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'new_transaksi_pembelian',user_id:user_id},
			success     : function(data) {

				$('.no_nota').val(data['no_nota']);
                $('#tgl_nota').val(data['tgl_nota']);
                $('#nama_user').val(data['nama_user']);

                
				
			},
			error: function(data){
					
			}
	});


//=========================  S U P P L I E R  =============================// 

    $('#supplier').select2({
       
        allowClear          : true,
        ajax: {
            url: './kelas/supplier_get.php',
            dataType: 'json',
            quietMillis: 250,
            data: function (params) {
                var queryParameters = {
                    op: 'supplier_list',
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

    $("#supplier").change(function(){
        var supplier_id = $("#supplier option:selected").val();
        $.ajax({
            url     : "./kelas/supplier_get.php",
            type    : "GET",
            dataType: "json",
            data    : { op  : "detail_supplier", supplier_id : supplier_id },
            success: function (data) {
                

                $(".no_tlp").html(data['no_tlp']);
                $(".alamat").html(data['alamat']);

                $('.detail_supplier').show(); 

                //$('.simpan_transaksi').prop('disabled',false); 
            },
            error: function (data) {
               // $('.simpan_transaksi').prop('disabled',true);
                $('.detail_supplier').hide(); 
            }
        }); 
    });




//======================== TABLE   ===================================//
    $('#list_pembelian').bootstrapTable({
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
					title: 'KULI @Kg',
					halign:'center',
                    align:'center',
                    width:100,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'" value="'+row.upah_kuli+'" class="form-control input-sm tbl_upah_kuli" style="width:100px; text-align:right; margin-top:-4px;">' 
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
                    load_data_pembelian();
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
                    load_data_pembelian();
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
                    load_data_pembelian();
                },
        }); 

    }

//=======================================================================//
//==================== UPDATE UPAH KULI  PADA TABLE ====================================//
$(document).on('keydown','.tbl_upah_kuli',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            upah_kuli = $(this).val();
            id = $(this).attr('id');
            update_upah_kuli_table(id,upah_kuli);
        } 
    });

    $(document).on('blur','.tbl_upah_kuli',function(e){
        upah_kuli = $(this).val();
            id = $(this).attr('id');
            update_upah_kuli_table(id,upah_kuli);
    });

    function update_upah_kuli_table(id,upah_kuli){
        $.ajax({
                url         :"./kelas/item_post.php",
                type        : "POST",
                data        :{op:"update_upah_kuli_tmp",upah_kuli:upah_kuli,id:id},
                cache       :false,
                success:function(data){
                    load_data_pembelian();
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
                load_data_pembelian();
			},
		});
		
    });

//====================== TABLE LIST ITEM ===================================//   
    load_data_pembelian();
    function load_data_pembelian(){
		
		$.ajax({
			url         : "./kelas/pembelian_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'tmp_pembelian_list'},
			success     : function(data) {
				
					$('#list_pembelian').bootstrapTable('load',{data: data['tmp_pembelian_list'] });
					$('[data-toggle="tooltip"]').tooltip();
					$('.fixed-table-loading').fadeOut(100);


                    $('.total_harga').html(data['detail_pembelian_list'][0]['total']);
                    $('.grand_total').val(data['detail_pembelian_list'][0]['total']);

                    $('.total_upah_kuli').val(data['detail_pembelian_list'][0]['total_upah_kuli']);
                    $('.total_bayar').val(data['detail_pembelian_list'][0]['total_bayar']);
                   
				
			},
			error: function(data){
					$('#table').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
					$('#list_penjualan').bootstrapTable('removeAll');
				
			}
		});
    }


//=========================== T Y P E   B A Y A R =================================================//
    $('.type_bayar').select2();
    $(".type_bayar").change(function(){
        var type = $(".type_bayar option:selected").val();


        if ( type == 2 ){
            $('.jumlah_dp').show();
        }else{
            $('.jumlah_dp').hide();
        }


    });


    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('dp');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
        tanpa_rupiah.value = formatRupiah(this.value);
        
	});


//======================= SIMPAN TRANSAKSI PEMBELIAN ===============================================//
    $(document).on('click','.simpan_transaksi',function(e){
        e.preventDefault();

        

        user_id             = $(".user_id").val();
        supplier_id         = $(".supplier_id").val();
        no_nota             = $(".no_nota").val();

        total_harga         = parseInt($(".total_harga").val().replace(/[^,\d]/g, '').toString());
        total_upah_kuli     = parseInt($(".total_upah_kuli").val().replace(/[^,\d]/g, '').toString());
     
        type_bayar          = $(".type_bayar").val();
        jumlah_dp           = parseInt($(".txt_jm_dp").val().replace(/[^,\d]/g, '').toString());
      
        //alert(user_id+supplier_id+no_nota+total_harga+total_upah_kuli);
       
        if ( total_harga == 0 ){
           
            swal({
				
				text: "List Item Pembelian Masih Kosong",
				type: "warning"
			}).then (function(){
                	
			});
        }else if ( ( type_bayar != '1' ) & (supplier_id == '1') ){
            swal({
				
				text: "Nama Supplier tidak boleh Cash",
				type: "warning"
			}).then (function(){
                $('#supplier').select2('open');		
			});
            
        }else{
            simpan_transaksi();
        }
    });


    function simpan_transaksi(){
        user_id             = $(".user_id").val();
        supplier_id         = $(".supplier_id").val();
        no_nota             = $(".no_nota").val();

        total_harga         = parseInt($(".total_harga").val().replace(/[^,\d]/g, '').toString());
        total_upah_kuli     = parseInt($(".total_upah_kuli").val().replace(/[^,\d]/g, '').toString());
        
        keterangan          = $(".keterangan").val();

        type_bayar          = $(".type_bayar").val();
        jumlah_dp           = parseInt($(".txt_jm_dp").val().replace(/[^,\d]/g, '').toString());

          $.ajax({
			url         : "./kelas/transaksi_post.php",
			type        : "POST",
			data        : { op              : "simpan_transaksi_pembelian",
                            user_id         : user_id,
                            supplier_id     : supplier_id, 
                            no_nota         : no_nota,
                            total_harga     : total_harga,
                            total_upah_kuli : total_upah_kuli,
                            type_bayar      : type_bayar,
                            jumlah_dp       : jumlah_dp,
                            keterangan      :keterangan
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

                            window.open("./print_out/cetak_nota_pembelian.php", "print_nota","width=900,height=800,top=50,left=250" );
						
                            window.location.reload();
                            
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