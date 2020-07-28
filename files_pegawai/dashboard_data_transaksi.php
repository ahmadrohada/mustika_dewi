<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">DATA TRANSAKSI</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-maroon transaksi_penjualan" style="cursor:pointer;">
                                <div class="inner">
                                    <h3><span class="total_transaksi_penjualan">*</span></h3>
                                    <p>PENJUALAN</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-cart"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <!-- small box -->
                            <div class="small-box bg-teal transaksi_pembelian" style="cursor:pointer;">
                                <div class="inner">
                                    <h3><span class="total_transaksi_pembelian">*</span></h3>
                                    <p> PEMBELIAN</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="small-box bg-green piutang" style="cursor:pointer;">
                                <div class="inner">
                                    <h3><span class="jm_piutang">*</span></h3>
                                    <p> PIUTANG</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-undo"></i>
                                </div>
                                <a href="./home.php?page=dashboard&chart=2" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
</section>



<script>
    $(document).on('click', '.transaksi_pembelian', function(e) {
        window.location.assign("home.php?page=pembelian");
    });

    $(document).on('click', '.transaksi_penjualan', function(e) {
        window.location.assign("home.php?page=penjualan");
    });

    $(document).on('click','.piutang',function(e){
		window.location.assign("home.php?page=piutang");
	});
</script>