<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Penjualan</h3>
                </div>
                <div class="box-body">

                    <div id="toolbar">
						<div class="form-inline" role="form">
							<button class="btn btn-warning btn-sm transaksi_penjualan"><span class="fa fa-plus"></span>&nbsp;&nbsp; Transaksi</button>
						</div>
					</div>
				

                    <table
						id="table_penjualan"
                        data-class="table-striped" 
						data-pagination="true"
						data-search="true"
						data-toolbar="#toolbar"
						data-search="true"
						>
					
					</table>
                </div>
            </div>
        </div>
    </div>
</section>











<script>
$(document).ready(function () {


	

    $(document).on('click','.transaksi_penjualan',function(e){
		window.location.assign("home.php?page=transaksi_penjualan");
	});

	$('#table_penjualan').bootstrapTable({
		columns:[	
				{
					field: 'no',
					title: 'NO',
					halign:'center',
					align:'center',
					width:40,
				}, 
				{
					/** class: 'hidden-xs', **/
					field: 'tgl_nota',
					title: 'TGL TRANSAKSI',
					halign:'center',
					align:'center',
					sortable:true,
					width:180,
					
				}, 
				{
					field: 'no_nota',
					title: 'NO NOTA',
					halign:'center',
					align:'center',
					sortable:true,
					width:110,

					
				}, 
				{
					field: 'pelanggan',
					title: 'PELANGGAN',
					halign:'center',
					sortable:true,
					width:130,
				}, 
                {
					field: 'total_belanja',
					title: 'TOTAL BELANJA',
					halign:'center',
                    align:'right',
					width:110,
				}, 
				{
					field: 'total_komisi',
					title: 'KOMISI',
					halign:'center',
                    align:'right',
					width:80,
				},
				{
					field: 'total_tambahan',
					title: 'TAMBAHAN',
					halign:'center',
                    align:'right',
					width:80,
				},
				{
					field: 'type_bayar',
					title: 'STATUS',
					halign:'center',
					width:100,
					sortable:true,
				},
				{
					field: 'sisa',
					title: 'SISA',
					halign:'center',
                    align:'right',
					sortable:true,
					width:110,
				},
				{
					field: 'keterangan',
					title: 'KETERANGAN',
					halign:'center',
				},
				{
					field: 'Status',
					title: '<i class="glyphicon glyphicon-cog"></i>',
					halign:'center',
					align:'center',
					width:80,
					formatter: function (value, row) {
						if ( row.type_pembayaran == 'hutang'){
                            return 	[  	'<button  style="margin:1px; margin-top:-5px;" class="btn btn-danger 	btn-xs bayar" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Bayar"><span class="fa fa-edit"></span></button>' 
										+'<button  style="margin:1px; margin-top:-5px;" class="btn btn-info		btn-xs cetak" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Cetak" ><span class="fa fa-print"></span></button>'
									];
                        }else{
                            return 	[  	'<button  style="margin:1px;  margin-top:-5px;" class="btn btn-success 	btn-xs lihat" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Lihat"><span class="fa fa-eye"></span></button>' 
										+'<button  style="margin:1px; margin-top:-5px;" class="btn btn-info		btn-xs cetak" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Cetak" ><span class="fa fa-print"></span></button>'
									];
                        }	                                
								
								
					}
				}
			
				]
	});



    load_data_penjualan();
    function load_data_penjualan(){
		
		$.ajax({
			url         : "./kelas/penjualan_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'penjualan_list'},
			success     : function(data) {
				
					$('#table_penjualan').bootstrapTable('load',{data: data['penjualan_list'] });
					$('[data-toggle="tooltip"]').tooltip();
					$('.fixed-table-loading').fadeOut(100);
				
			},
			error: function(data){
					$('#table_penjualan').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
				
			}
		});
    }



	$(document).on('click','.lihat',function(e){
        e.preventDefault();
        penjualan_id   = $(this).val();

		window.location.assign("home.php?page=detail_transaksi_penjualan&penjualan_id="+penjualan_id);

	});

	$(document).on('click','.cetak',function(e){
        e.preventDefault();
        penjualan_id   = $(this).val();

		window.open("./print_out/cetak_nota_penjualan.php?penjualan_id="+penjualan_id, "print_nota","width=900,height=800,top=50,left=250" );          

	});


});
</script>		