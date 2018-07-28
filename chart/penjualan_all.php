

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">DATA PENJUALAN</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body ">
        <div class="table-responsive">
            <div id="chartdiv" style="width: 600px; height: 400px;"></div>
        </div>
       
    </div>
</div>

<script src="./assets/js/amcharts.js" type="text/javascript"></script>
<script src="./assets/js/serial.js" type="text/javascript"></script>
<script src="./assets/js/responsive.min.js"></script>
 

<script>
$(document).ready(function () {
             

            
    $.ajax({
			url		    : "./kelas/dashboard.php",
			type        : "GET",
			data	    : {op:"chart_penjualan_setahun"},
			dataType    : "json",
			cache	    : false,
			success	    : function(chartData){

                var chart = AmCharts.makeChart("chartdiv",{
                    "type": "serial",
                    "categoryField": "bulan",
                    "startDuration" : 1,
                    "creditsPosition" : "top-right",

                    "graphs": [
                        {
                        "valueField": "total_penjualan",
                        "colorField": "color",
                        "balloonText" : "<b>[[category]]: [[value]] Kg</b>",
                        "type" : "column",
                        "lineAlpha" : 0,
                        "fillAlphas" : 1
                        }
                    ],
                    "dataProvider": chartData['penjualan_all'],
                    "categoryAxis":[
                            {
                                "labelRotation" : 45,
                                "gridAlpha" : 0,
                                "fillAlpha" : 1,
                                "fillColor" : "#FAFAFA",
                                "gridPosition" : "start",
                            }
                    ]
                });
				
			}
	});
           
});
</script>