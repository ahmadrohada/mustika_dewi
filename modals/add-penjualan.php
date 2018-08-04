<div class="modal fade add-item_penjualan" id="addItem" role="dialog"  aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                ITEM PENJUALAN
                            </h4>
                        </div>

                        <form  id="form-add-item" method="POST" action="">
                        <input type="hidden" class="" value="add_item_penjualan" name="op">
                        <input type="hidden" class="no_nota" value="" name="no_nota">

                        <div class="modal-body">
							
						
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group nama ">
                                    <label class="control-label">Nama Karung :</label>
                                    <select  class="form-control nama_karung" name="nama_karung" id="nama_karung" style="width:100%;"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Tonase</label>
                                    <div class="input-group input-group">
                                    <input type="text" name="tonase" id="tonase" required class="form-control tonase" onkeypress='return angka(event)'>
                                    <span class="input-group-addon">Kg / Karung</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group nama ">
                                    <label>Jenis Beras</label>
                                    <select  class="form-control jenis_beras" name="jenis_beras" id="jenis_beras" style="width:100%;"></select>
                                </div>
                            </div>
                        </div>
						

                        <div class="row">
                            
                            <div class="col-md-4">
                                <label class="control-label">Harga</label>
                                <div class="input-group input-group">
                                <input type="text" name="harga" id="harga" required class="form-control f_harga" onkeypress='return angka(event)'>
                                <span class="input-group-addon">/Kg</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Jumlah</label>
                                <div class="input-group input-group">
                                <input type="text" name="qty" id="qty" required class="form-control f_qty" onkeypress='return angka(event)'>
                                <span class="input-group-addon">Karung</span>
                                </div>
                            </div>

                        </div>

                       
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-block btn-warning simpan_item" id="simpan_item" style="margin-top:24px;">TAMBAH</button>
                          
                        </div>

                        </form>
                    </div>
                </div>
            </div>







<script type="text/javascript">
$(document).ready(function() {


    $('.add-item_penjualan').on('hidden.bs.modal', function(){
        $('#jenis_beras').select2("val", "");
        $('.nama_karung').val("");
        $('.qty').val("");
        $('.tonase').val("");
        $('.harga').val("");




	});

//========================= NAMA KARUNG  =============================// 
    $('#jenis_beras').select2();
    $('#jenis_beras').attr('disabled', true);
    

    $('#nama_karung').select2({
        
        allowClear          : true,
        ajax: {
            url: './kelas/nama_karung_get.php',
            dataType: 'json',
            quietMillis: 250,
            data: function (params) {
                var queryParameters = {
                    op: 'nama_karung',
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



    $("#nama_karung").change(function(){

    var nama_karung = $("#nama_karung option:selected").val();
    //alert(nama_karung);
    $('#jenis_beras').attr('disabled', false);
    $('#jenis_beras').val(null).trigger('change');

    $('#tonase').val(nama_karung.split('|')[1]);

    $('#jenis_beras').select2({
            allowClear  : true,
            ajax        : {
                            url: './kelas/jenis_beras_get.php',
                            dataType: 'json',
                            quietMillis: 250,
                            data: function (params) {
                                var queryParameters = {
                                    op: 'jenis_beras',
                                    nama_karung : nama_karung,
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
                          }
            });


    });
//=========================================================================// 

    

    $("#jenis_beras").change(function(){
        var jenis_beras_id = $("#jenis_beras option:selected").val();
        
        //alert(jenis_beras_id);
        $.ajax({
            url     : "./kelas/jenis_beras_get.php",
            type    : "GET",
            dataType: "json",
            data    : { op  : "harga_beras", jenis_beras_id : jenis_beras_id },
            success: function (data) {
                $(".f_harga").val(data['harga_jual']);
                
                $('.f_qty').focus();
            },
            error: function (data) {
                
            }

        }); 
    });



//================= SIMPAN ITEM PEMBELIAN =============================//

    $(document).on('click', '#simpan_item', function(){
		
        var data = $('#form-add-item').serialize();
		$.ajax({
			url     :"./kelas/item_post.php",
			type	: 'POST',
			data	:  data,
			success	: function(data , textStatus, jqXHR) {
				
				swal({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							$('.add-item_penjualan').modal('hide');
						}
					}
			)	
			},
			error: function(jqXHR , textStatus, errorThrown) {
                swal({
					title: "",
					text: "Gagal",
					type: "error",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick : false,
					timer:1500
				}).then(function () {
					
					
				},
					
					function (dismiss) {
						if (dismiss === 'timer') {
							
						}
					}
			    )	
			}
			
		  });
		
    });


});
</script>