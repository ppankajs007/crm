<script src="https://code.highcharts.com/8.0.0/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript">
	// Create the chart
	Highcharts.chart('campaignReport', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Leads report for January, 2020'
	    },
	    subtitle: {
	        text: 'Click on bar to see more'
	    },
	    accessibility: {
	        announceNewData: {
	            enabled: true
	        }
	    },
	    xAxis: {
	        type: 'category'
	    },
	    yAxis: {
	        title: {
	            text: 'Total number of leads'
	        }
	    },
	    legend: {
	        enabled: false
	    },
	    plotOptions: {
	        series: {
	            borderWidth: 0,
	            dataLabels: {
	                enabled: true,
	                format: '{point.y}'
	            }
	        }
	    },

	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>  leads<br/>'
	    },
	    series: [
	        {
	            name: "Campaign",
	            colorByPoint: true,
	            data: <?php echo json_encode($campaign); ?>,
		        dataLabels: {
		            enabled: true,
		            // color: '#FFFFFF',
		            format: '{point.y}', // one decimal
		            style: {
		                fontSize: '13px',
		                fontFamily: 'Verdana, sans-serif'
		            }
		        }
	        }
	    ],
	    drilldown: {
	        series: [
	        	<?php 
	        		foreach ($campaign as $cKey => $cValue) { ?>
		            {
		                name: "<?php echo $cValue['name']; ?>",
		                id: "<?php echo $cValue['name']; ?>",
		                data: <?php echo $cValue['drillArr']; ?>
		            },
        		<?php } ?>

            ]
        }
	});
</script>
<script type="text/javascript">
	// Create the chart
	Highcharts.chart('campaignPieVar', {
	    chart: {
	        type: 'variablepie'
	    },
	    title: {
	        text: 'Leads report by campaign'
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>  leads<br/>'
	    },
	    series: [
	        {
	            name: "Campaign",
                minPointSize: 10,
		        innerSize: '50%',
		        zMin: 0,
	            data: <?php echo json_encode($campaign); ?>,
	        }
	    ],
	});
</script>
<script type="text/javascript">
	// Create the chart
	Highcharts.chart('campaignPie', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: 'Leads report by Ad Set'
	    },
	    tooltip: {
	        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
	        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>  leads<br/>'
	    },
	    accessibility: {
	        point: {
	            valueSuffix: '%'
	        }
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
		            color: '#000000',
	                distance: -0,
	            }
	        },
	        series: {
                point: {
                    events: {
                        click: function() {
                            location.href = this.options.url;
                        }
                    }
                }
            }
	    },
	    series: [
	        {
	            name: "Leads",
				data: [
			            { name: 'Toms River 40_65_Women', y: 20 , url: 'http://bing.com/search?q=foo'},
			            { name: 'Middletown ', y: 15, url: 'http://bing.com/search?q=foo' },
			            { name: 'All Areas 30_50_Women', y: 31, url: 'http://bing.com/search?q=foo' },
			            { name: 'MT 40_65_Women', y: 46, url: 'http://bing.com/search?q=foo' },
			            { name: 'TR  40_65_Women', y: 51, url: 'http://bing.com/search?q=foo' },
			            { name: 'Basking Ridge 40_65_Women', y: 75, url: 'http://bing.com/search?q=foo' }
			        ]	       
	        }
	    ],
	});
</script>
<script type="text/javascript">
	Highcharts.chart('growthChart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Average Growth 2019'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Total Leads'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Leads',
        data: [7, 10, 12, 15, 26, 80, 46, 49, 60, 26, 19, 26]
    }]
});
</script>

<script>
	$('#daterange').daterangepicker({
	    ranges: {
	        'Today': [moment(), moment()],
	        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	        'This Month': [moment().startOf('month'), moment().endOf('month')],
	        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	    },
	    locale: {
	      format: 'DD MMM YYYY'
	    },
	    "alwaysShowCalendars": true,
	    "startDate": moment().startOf('month'),
	    "endDate": moment().endOf('month')
		}, function(start, end, label) {

	  		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});

	$('#daterange').on('apply.daterangepicker', function(ev, picker) {
  		$('#date_filter').submit()
	});

</script>