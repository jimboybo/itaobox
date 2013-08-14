$(function () {
    var chart;
    $(document).ready(function () {
    	// 客户
        $('#highcharts_customer').highcharts({
            chart: {
                type:'pie'
            },
			title:{
				text:'',
				floating:true,
				verticalAlign: 'bottom'
			},
			exporting:{
				enabled:false	
			},
			credits:{
				enabled:false
			},
			legend:{
				borderWidth:1
			},
			plotOptions:{
				pie:{
					dataLabels: {
						enabled: false
					}
				}
			},
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
            	percentageDecimals: 1
            },
            series: [{
                name: '占比',
                data: [
                    ['普通客户',45.0],
                    ['铜牌客户',26.8],
					['银牌客户',12.8]
                ],
				showInLegend:true
            }]
        });
		
		//销售
        $('#highcharts_sales').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [
                    '今日销售',
                    '昨日销售',
                    '一周销售'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: '销售'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f} 元</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: '订单数',
                data: [100,200,500]
    
            }, {
                name: '销售额',
                data: [2000,3000,5000]
    
            }, {
                name: '毛利润',
                data: [200,300,500]
    
            }]
        });
    

    });
});