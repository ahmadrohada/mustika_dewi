<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Pembelian</h3>
                </div>
                <div class="box-body">

                    <div id="toolbar">
						<div class="form-inline" role="form">
							<button class="btn btn-warning btn-sm transaksi_pembelian"><span class="fa fa-plus"></span>&nbsp;&nbsp; Transaksi</button>
						</div>
					</div>
				

                    <table
						id="table_pembelian"
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


    $(document).on('click','.transaksi_pembelian',function(e){
		window.location.assign("home.php?page=transaksi_pembelian");
	});

	$('#table_pembelian').bootstrapTable({
		columns:[	
				{
					field: 'no',
					title: 'NO',
					halign:'center',
					align:'center'
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

					
				}, 
				{
					field: 'nama_supplier',
					title: 'NAMA SUPPLIER',
					halign:'center',
					sortable:true,
					width:130,
				}, 
                {
					field: 'total_harga',
					title: 'TOTAL',
					halign:'center',
                    align:'right',
					width:110,
				}, 
				{
					field: 'total_upah_kuli',
					title: 'UPAH KULI',
					halign:'center',
                    align:'right',
					width:110,
				},
				{
					field: 'jumlah_bayar',
					title: 'JM BAYAR',
					halign:'center',
                    align:'right',
					width:110,
				},
				{
					field: 'type_bayar',
					title: 'STATUS',
					halign:'center',
					width:100,
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
                    align:'right'
				},
				{
					field: 'Status',
					title: '<i class="glyphicon glyphicon-cog"></i>',
					halign:'center',
					align:'center',
					width:90,
					formatter: function (value, row) {
						
                        return 	[  	'<button  style="margin:1px;  margin-top:-5px;" class="btn btn-success 	btn-xs lihat" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Lihat"><span class="fa fa-eye"></span></button>' 
									+'<button  style="margin:1px; margin-top:-5px;" class="btn btn-info		btn-xs cetak" 		value="'+row.id+'" data-toggle="tooltip" data-placement="top" title="Cetak" ><span class="fa fa-print"></span></button>'
								];
                      		
					}
				}
				]
	});



    load_data_pembelian();
    function load_data_pembelian(){
		
		$.ajax({
			url         : "./kelas/pembelian_get.php",
			type        : "GET",
			dataType    : "json",
			data        : {data:'pembelian_list'},
			success     : function(data) {
				
					$('#table_pembelian').bootstrapTable('load',{data: data['pembelian_list'] });
					$('[data-toggle="tooltip"]').tooltip();
					$('.fixed-table-loading').fadeOut(100);
				
			},
			error: function(data){
					$('#table_pembelian').bootstrapTable('removeAll');
					$('.fixed-table-loading').fadeOut(100);
					$('[data-toggle="tooltip"]').tooltip();
				
			}
		});
    }



	$(document).on('click','.lihat',function(e){
        e.preventDefault();
        pembelian_id   = $(this).val();

		window.location.assign("home.php?page=detail_transaksi_pembelian&pembelian_id="+pembelian_id);

	});

	$(document).on('click','.cetak',function(e){
        e.preventDefault();
        pembelian_id   = $(this).val();

		window.open("./print_out/cetak_nota_pembelian.php?pembelian_id="+pembelian_id, "print_nota","width=600,height=800,top=50,left=250" );          

	});

});
</script>		