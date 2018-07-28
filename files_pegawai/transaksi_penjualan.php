
<?php
	$user_id = isset($_SESSION['md_user_id']) ? $_SESSION['md_user_id'] : '';
?>




<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa  fa-tags"></i> Informasi Nota</h3>
                </div>
                <div class="box-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No Nota</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm no_nota" id="no_nota" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm tgl_nota" id="tgl_nota" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">User</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" id="nama_user" disabled>
                            <input type="hidden" value="<?php echo $user_id ?>" class="user_id" id="user_id" name="user_id" >
                        </div>
                    </div>

                </form>
                </div>
            </div>


            <div class="box box-default">
                <div class="box-header with-border">
                <h3 class="box-title"><i class="fa  fa-user"></i> Informasi Pelanggan</h3>
                </div>
                <div class="box-body">

                    

                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-4 control-label text-right">Pelanggan</label>
                            <label class="col-sm-8">
                                <span id="no_tlp" class="md_label pelanggan">-</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label text-right">Tlp / HP</label>
                            <label class="col-sm-8">
                                <span id="no_tlp" class="md_label tlp">-</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label text-right">Alamat</label>
                            <label class="col-sm-8">
                                <span id="no_tlp" class="md_label alamat">-</span>
                            </label>
                        </div>

                         <div class="form-group">
                            <label class="col-sm-4 control-label text-right">Info lain</label>
                            <label class="col-sm-8">
                                <span id="no_tlp" class="md_label info">-</span>
                            </label>
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
                    
                    
                   <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Beras</label>
                            <select  class="form-control jenis_beras"></select>
                        </div>
                   </div>

                   <div class="col-md-2">
                        <div class="form-group">
                            <label>Harga/Kg</label>
                            <input type="text" class="form-control harga_beras" disabled>
                        </div>
                   </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Discount</label>
                            <div class="input-group " style="width:100px;" >
                                <input type="text" value="0" class="form-control input-sm discount" style="text-align:center;" disabled>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>
                    </div>

                   <div class="col-md-2">
                        <div class="form-group">
                            <label>QTY ( Kg ) / Stok</label>
                            <div class="input-group " >
                                <input type="text" class="form-control input-sm qty" style="text-align:center;">
                                <span class="input-group-addon stok" style="width:80px;"> stok </span>
                            </div>
                        </div>
                   </div>
                       
                   <div class="col-md-2">
                            <button type="button" class="btn btn-block btn-sm btn-warning add_item" style="margin-top:24px;">ADD ITEM</button>
                   </div>
                   

                    <div class="col-md-12" style="margin-top:10px;">
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
                            <input type="hidden" class="grand_total">
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



                                <div class="form-group">
                                    <label class="col-sm-4 control-label" >Pelanggan</label>
                                    <div class="col-sm-8">
                                        <select class="form-control input-sm nama_pelanggan" name="nama_pelanggan" ></select>
                                    </div>
                                </div>


                                <div class="form-group" >
                                    <label class="col-sm-4 control-label" >Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control input-sm bayar"  value="" id="bayar" style="text-align:right;">
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
                                            <input type="text" value="0" class="form-control input-sm komisi" style="text-align:center; width:40px;">
                                            <span class="input-group-addon">%</span>
                                            <input type="text" value="0" class="form-control input-sm besar_komisi" style="text-align:right;" disabled>
                                        </div>
                                    </div>
                                </div> 

                                <div class="form-group"  style="margin-top:-10px;">
                                    <label class="col-sm-4 control-label">Kembali</label>
                                    <div class="col-sm-8">
                                        <input type="text"  class="form-control input-sm kembali" value="0" style="text-align:right;" disabled>
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
   
    
 

    $.ajax({
			url         : "./kelas/new_transaksi_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'new_transaksi',user_id:user_id},
			success     : function(data) {

				$('#no_nota').val(data['no_nota']);
                $('#tgl_nota').val(data['tgl_nota']);
                $('#nama_user').val(data['nama_user']);

                
				
			},
			error: function(data){
					
			}
	});

//=========================  P E L A N G G G A N ==================================//   
    $('.nama_pelanggan').select2({
        placeholder         : "Ketik Nama Pelanggan",
        minimumInputLength  : 3,
        ajax: {
            url: './kelas/pelanggan_get.php',
            dataType: 'json',
            quietMillis: 250,
            data: function (params) {
                var queryParameters = {
                    op: 'pelanggan',
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
        },
        language: {
            inputTooShort: function (args) {
                // args.minimum is the minimum required length
                // args.input is the user-typed text
                var min = args.minimum;
                var inp = args.input.length;
                var cur = min - inp;
                return "input minimal " + cur + " Karakter";
            },
            inputTooLong: function (args) {
                // args.maximum is the maximum allowed length
                // args.input is the user-typed text
                return "input maximal";
            },
            errorLoading: function () {
                return "Nama Pelanggan tidak ditemukan";
            },
            loadingMore: function () {
                return "Loading lebih banyak data";
            },
            noResults: function () {
                return "Tidak ada hasil";
            },
            searching: function () {
                return "Searching...";
            },
            maximumSelected: function (args) {
                // args.maximum is the maximum number of items the user may select
                return "Error loading data";
            }
        } 

    });

    $(".nama_pelanggan").change(function(){
        var pelanggan_id = $(".nama_pelanggan option:selected").val();
        //alert(pelanggan_id);

        $.ajax({
            url     : "./kelas/pelanggan_get.php",
            type    : "GET",
            dataType: "json",
            data    : { op  : "detail_pelanggan", pelanggan_id : pelanggan_id },
            success: function (data) {
                $(".tlp").html(data['tlp']);
                $(".alamat").html(data['alamat']);
                $(".info").html(data['info_lain']);
                $(".pelanggan").html(data['nama']);

                $('.bayar').focus();

                
            },
            error: function (data) {
                
            }

        }); 
        
    });

   

//========================= JENIS BERAS  =============================// 
    document.addEventListener('keydown', function(event) {
        if (event.code == 'F1') {
            $('.jenis_beras').select2('open');
        }
    });

    $('.jenis_beras').select2({
        placeholder         : "Ketik Jenis Beras",
        minimumInputLength  : 2,
        allowClear          : true,
        ajax: {
            url: './kelas/jenis_beras_get.php',
            dataType: 'json',
            quietMillis: 250,
            data: function (params) {
                var queryParameters = {
                    op: 'jenis_beras',
                    label: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        
                        return {
                            text: item.label,
						    id: item.id,
                        }
                        
                    })
                };
                
                
            }
        },
        language: {
            inputTooShort: function (args) {
                // args.minimum is the minimum required length
                // args.input is the user-typed text
                var min = args.minimum;
                var inp = args.input.length;
                var cur = min - inp;
                return "input minimal " + cur + " Karakter";
            },
            inputTooLong: function (args) {
                // args.maximum is the maximum allowed length
                // args.input is the user-typed text
                return "input maximal";
            },
            errorLoading: function () {
                return "Jenis Beras tidak ditemukan";
            },
            loadingMore: function () {
                return "Loading lebih banyak data";
            },
            noResults: function () {
                return "Tidak ada hasil";
            },
            searching: function () {
                return "Searching...";
            },
            maximumSelected: function (args) {
                // args.maximum is the maximum number of items the user may select
                return "Error loading data";
            }
        } 

    });


    $(".jenis_beras").change(function(){

        var jenis_beras_id = $(".jenis_beras option:selected").val();
      
        $.ajax({
            url     : "./kelas/jenis_beras_get.php",
            type    : "GET",
            dataType: "json",
            data    : { op  : "harga_beras", jenis_beras_id : jenis_beras_id },
            success: function (data) {
                $(".harga_beras").val(data['harga_jual']);
                $(".stok").html(data['stok']);

                $('.qty').focus();
            },
            error: function (data) {
                
            }

        }); 
        
    });


//===================================   JUMLAH PEMBELIAN  =============================================// 


    $('.qty').on('keydown', function(e) {
        if ( (e.which == 13)|(e.which == 9)) {
            //e.preventDefault();
            add_item();
        }
    });

   /*  $('.qty').on('blur', function(e) {
        alert();
    }); */

    $(document).on('click','.add_item',function(e){
        add_item();
      
    });

     function add_item(){


        if ( $('.jenis_beras option:selected').val() == null ){
            $('.jenis_beras').select2('open');
        }else{
            $.ajax({
                url     : "./kelas/transaksi_post.php",
                type    : "POST",
                data    : { op              : "add_to_tmp",
                            no_nota         : $('#no_nota').val(),
                            jenis_beras_id  : $('.jenis_beras option:selected').val(),
                            qty             : $('.qty').val(),
                            harga           : $('.harga_beras').val(),
                            discount        : $('.discount').val()

                        
                        },
                success: function (data) {
                    load_data_penjualan();

                    $('.jenis_beras').val('').trigger('change');
                    $('.harga_beras').val('');
                    $('.qty').val('');
                    $(".stok").html("stok");


                    $('.jenis_beras').select2('open');


                  


                
                },
                error: function (data) {
                    
                }

            }); 
        }


    }
 


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
                    align:'center',
                    width:120,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'" value="'+row.harga+'" class="form-control input-sm harga" style="width:120px; text-align:right;">' 
								];
					}

					
                }, 
                /* {
					field: 'discount',
					title: 'DISC (%)',
					halign:'center',
                    align:'center',
                    width:80,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'" value="'+row.discount+'" class="form-control input-sm potongan" style="width:70px; text-align:center;">' 
								];
					}

					
				},  */
				{
					field: 'qty',
					title: 'QTY / KG',
					halign:'center',
                    align:'center',
                    width:80,
                    formatter: function (value, row) {
					    return 	[  	'<input type="text" id="'+row.id+'"  value="'+row.qty+'"  class="form-control input-sm quantity" style="width:70px; text-align:center;">' 
								];
					}
				}, 
                {
					field: 'jumlah',
					title: 'JUMLAH',
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
					    return 	[  	'<button  style="margin:1px;" class="btn btn-danger btn-xs hapus" value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Hapus"><span class="fa fa-remove"></span></button>' 
									
								];
					}
				}
				]
	});



    $(document).on('keydown','.harga',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            harga = $(this).val();
            id = $(this).attr('id');
            update_harga_table(id,harga);
          
        } 
    });

   $(document).on('blur','.harga',function(e){
            harga = $(this).val();
            id = $(this).attr('id');
            update_harga_table(id,harga);
    });

    function update_harga_table(id,harga){
       
           
        $.ajax({
                url         :"./kelas/transaksi_post.php",
                type        : "POST",
                data        :{op:"update_harga_tmp",harga:harga,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                    
                
                },
        }); 
    }




    $(document).on('keydown','.potongan',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            //harga = $(this).val();
            discount = $(this).val();
            id = $(this).attr('id');
            update_potongan_table(id,discount);
           
            
        } 
    });

    $(document).on('blur','.potongan',function(e){
            discount = $(this).val();
            id = $(this).attr('id');
            update_potongan_table(id,discount);
    });


    function update_potongan_table(id,discount){
        $.ajax({
                url         :"./kelas/transaksi_post.php",
                type        : "POST",
                data        :{op:"update_discount_tmp",discount:discount,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                    
                
                },
        }); 
    }




    $(document).on('keydown','.quantity',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            
            qty = $(this).val();
            id = $(this).attr('id');
            update_qty_table(id,qty);
            

        } 
    });


    $(document).on('blur','.quantity',function(e){
            qty = $(this).val();
            id = $(this).attr('id');
            update_qty_table(id,qty);
    });

    function update_qty_table(id,qty){
        $.ajax({
                url         :"./kelas/transaksi_post.php",
                type        : "POST",
                data        :{op:"update_qty_tmp",qty:qty,id:id},
                cache       :false,
                success:function(data){
                    load_data_penjualan();
                },
        }); 

    }


    $(document).on('click','.hapus',function(e){
        //e.preventDefault();
       
		detail_penjualan_tmp_id = $(this).val();
	
        //alert(detail_penjualan_tmp_id);


		$.ajax({
			url         :"./kelas/transaksi_post.php",
			type        : "POST",
			data        :{op:"delete_from_tmp",detail_penjualan_tmp_id:detail_penjualan_tmp_id},
			cache       :false,
			success:function(data){
                load_data_penjualan();
                
			
			},
		});
		
    });

    
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

                    $('.bayar').val("");
                    $('.kembali').val("0");
				
			},
			error: function(data){
					$('#table').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
					$('#list_penjualan').bootstrapTable('removeAll');
				
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
	
    $(document).on('click','.bayar',function(e){

        //$(".kembali").val('0');
      
    });



    $(document).on('keydown','.bayar',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            hitung_kembalian();
        } 
    });

   /*  $(document).on('keyup','.bayar',function(e){
        bayar       = parseInt($(".bayar").val().replace(/[^,\d]/g, '').toString());
        grand_total = parseInt($(".grand_total").val().replace(/[^,\d]/g, '').toString());
        hitung_kembalian(bayar,grand_total);
    }); */

     $(document).on('blur','.bayar',function(e){
        hitung_kembalian();
    });

    function hitung_kembalian(bayar,grand_total){

        bayar       = parseInt($(".bayar").val().replace(/[^,\d]/g, '').toString());
        grand_total = parseInt($(".grand_total").val().replace(/[^,\d]/g, '').toString());
        if (bayar < grand_total){
            $(".komisi").val("0");
            $(".komisi").attr("disabled", true);
            kembali = Intl.NumberFormat().format(bayar-grand_total); 

            $(".kembali").val(kembali);
        }else{
            $(".komisi").attr("disabled", false);

            komisi       = parseInt($(".komisi").val().replace(/[^,\d]/g, '').toString());
            besar_komisi = (komisi/100)*grand_total;

            kembali = Intl.NumberFormat().format((bayar-grand_total)+besar_komisi); 

            $(".kembali").val(kembali);
        }
    }



    $(document).on('keydown','.komisi',function(e){
        if ( (e.which == 13)|(e.which == 9)) {
            hitung_komisi();
        } 
    });

    $(document).on('blur','.komisi',function(e){
        hitung_komisi();
    });

    function hitung_komisi(){
        komisi       = $(".komisi").val().replace(/[^,\d]/g, '').toString();
        bayar       = $(".bayar").val().replace(/[^,\d]/g, '').toString();
        grand_total = $(".grand_total").val().replace(/[^,\d]/g, '').toString();

        besar_komisi= (komisi/100)*grand_total;
        kembali = Intl.NumberFormat().format((bayar-grand_total)+besar_komisi); 
        $(".kembali").val(kembali);
        $(".besar_komisi").val(Intl.NumberFormat().format(besar_komisi));
    }



    
 

    $(document).on('click','.simpan_transaksi',function(e){
        e.preventDefault();
        user_id             = $(".user_id").val();
        pelanggan_id        = $(".nama_pelanggan").val();
        no_nota             = $(".no_nota").val();

        grand_total         = parseInt($(".grand_total").val().replace(/[^,\d]/g, '').toString());
        bayar               = parseInt($(".bayar").val().replace(/[^,\d]/g, '').toString());
        kembali             = $(".kembali").val();

        hutang             = $(".kembali").val().replace('-', '');

      
        

        if ( grand_total == 0 ){
           
            swal({
				
				text: "Tidak Ada List Barang yang dibeli",
				type: "warning"
			}).then (function(){
                $('.jenis_beras').select2('open');		
			});
        }else if ( pelanggan_id == null ){
            swal({
				
				text: "Nama pelanggan harus diisi",
				type: "warning"
			}).then (function(){
                $('.nama_pelanggan').select2('open');		
			});
            
        }else if ( $(".bayar").val() == "") {
            swal({
				
				text: "Kolom bayar harus terisi",
				type: "warning"
			}).then (function(){
                $('.bayar').focus();		
			});
        }else if ( bayar < grand_total ){
            swal({
				
                html                : "Pembayaran yang dilakukan kurang dari Jumlah yang harus dibayar"
                                    +"<br>Transaksi ini akan dianggap sebagai hutang<br>"
                                    +"sisa yang belum dibayar sebesar Rp. <b>"+hutang+"</b>",
				type                : "question",
                showCancelButton	: true,
                cancelButtonText	: "Batal",
			}).then (function(){
                simpan_transaksi('1');		    
			});

        }else{
            simpan_transaksi('0');
        }
    });


    function simpan_transaksi(status_hutang){
        user_id             = $(".user_id").val();
        pelanggan_id        = $(".nama_pelanggan").val();
        no_nota             = $(".no_nota").val();

        grand_total         = $(".grand_total").val();
        bayar               = $(".bayar").val();
        komisi              = $(".komisi").val();
        
        keterangan          = $(".keterangan").val();


          $.ajax({
			url         : "./kelas/transaksi_post.php",
			type        : "POST",
			data        : { op           : "simpan_transaksi",
                            user_id      : user_id,
                            pelanggan_id : pelanggan_id, 
                            no_nota      : no_nota,
                            grand_total  : grand_total,
                            bayar        : bayar,
                            komisi       : komisi,
                            status_hutang:status_hutang,
                            keterangan   :keterangan
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