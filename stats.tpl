{capture name=tabs}
		<li class="active"><a href="{url module=StatsAdmin}">Статистика</a></li>
{/capture}
{$meta_title='Статистика' scope=parent}

{* On document load *}
{literal}
<script src="design/js/highcharts/js/highcharts.js" type="text/javascript"></script>
<script src="design/js/datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="design/js/datetimepicker/jquery.datetimepicker.css" type="text/css" media="screen" />

<script>
var chart;

$(function() {

$('input[name="date_from"],input[name="date_to"]').datetimepicker({
	lang:'ru',
	timepicker:false,
	format:'Y-m-d',
    dayOfWeekStart:1
});
$('#show').on('click', function() {
    get_info();
});

function get_info() {
    params = '?type='+$('[name="type"]').val();
    date_from = $('[name="date_from"]').val();
    date_to = $('[name="date_to"]').val();
    if (date_from != '') {
        params += '&date_from='+encodeURIComponent(date_from);
    }
    if (date_to != '') {
        params += '&date_to='+encodeURIComponent(date_to);
    }
    $.get('ajax/stat/stat.php'+params, function(data) {
	
	           var series = {
	                data: []
	            };
	
	    series.name = 'Сумма заказов, {/literal}{$currency->sign}{literal}';
	    
        $('#total_price').text(data.total_price);
        data = data.data;
        interval = 30;
        if (date_from != '' && date_to != '') {
            interval = (new Date(date_to).getTime() - new Date(date_from).getTime())/1000/3600/24;
            d = new Date(date_to);
        } else if (date_from != '' && date_to == '') {
            d = new Date(date_from);
            d.setDate(d.getDate()+interval);
        } else if (date_from == '' && date_to != '') {
            d = new Date(date_to);
        } else {
            d = new Date();
        }
        
        //d = new Date();
		for(i=0; i<interval; i++)
		{	
 			series.data.push([Date.UTC(1900+d.getYear(), d.getMonth(), d.getDate()), 0]);
			d.setDate(d.getDate()-1);
 		}
	    
	    // Iterate over the lines and add categories or series
	    $.each(data, function(lineNo, line) {

   	                    series.data.push([Date.UTC(line.year, line.month-1, line.day), parseInt(line.y)]);

	  
	    });
        options.series = [];
	    options.series.push(series);
	    
	    // Create the chart
	    var chart = new Highcharts.Chart(options);
	});
}

var options = {
      chart: {
         renderTo: 'container',
         defaultSeriesType: 'line'
      },
      title: {
         text: 'Статистика заказов'
      },
      subtitle: {
         text: ''
      },
      xAxis: {
         type: 'datetime'
      },
      yAxis: {
		title: {
            text: '{/literal}{$currency->name}{literal}'
         }
      },

 
      plotOptions: {
         line: {
            dataLabels: {
               enabled: true
            },
            enableMouseTracking: true
         }
      },
      series: []

};

	get_info();

});
 

 
Highcharts.theme = {
   colors: ["#DDDF0D", "#7798BF", "#55BF3B", "#DF5353", "#aaeeee", "#ff0066", "#eeaaee", 
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: [0, 0, 0, 400],
         stops: [
            [0, 'rgb(96, 96, 96)'],
            [1, 'rgb(16, 16, 16)']
         ]
      },
      borderWidth: 0,
      borderRadius: 15,
      plotBackgroundColor: null,
      plotShadow: false,
      plotBorderWidth: 0
   },
   title: {
      style: { 
         color: '#FFF',
         font: '16px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
      }
   },
   subtitle: {
      style: { 
         color: '#DDD',
         font: '12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
      }
   },
   xAxis: {
      gridLineWidth: 0,
      lineColor: '#999',
      tickColor: '#999',
      labels: {
         style: {
            color: '#999',
            fontWeight: 'bold'
         }
      },
      title: {
         style: {
            color: '#AAA',
            font: 'bold 12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
         }            
      }
   },
   yAxis: {
      alternateGridColor: null,
      minorTickInterval: null,
      gridLineColor: 'rgba(255, 255, 255, .1)',
      lineWidth: 0,
      tickWidth: 0,
      labels: {
         style: {
            color: '#999',
            fontWeight: 'bold'
         }
      },
      title: {
         style: {
            color: '#AAA',
            font: 'bold 12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
         }            
      }
   },
   legend: {
      itemStyle: {
         color: '#CCC'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#333'
      }
   },
   labels: {
      style: {
         color: '#CCC'
      }
   },
   tooltip: {
      backgroundColor: {
         linearGradient: [0, 0, 0, 50],
         stops: [
            [0, 'rgba(96, 96, 96, .8)'],
            [1, 'rgba(16, 16, 16, .8)']
         ]
      },
      borderWidth: 0,
      style: {
         color: '#FFF'
      }
   },
   
   
   plotOptions: {
      line: {
         dataLabels: {
            color: '#CCC'
         },
         marker: {
            lineColor: '#333'
         }
      },
      spline: {
         marker: {
            lineColor: '#333'
         }
      },
      scatter: {
         marker: {
            lineColor: '#333'
         }
      }
   },
   
   toolbar: {
      itemStyle: {
         color: '#CCC'
      }
   },
   
   navigation: {
      buttonOptions: {
         backgroundColor: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#606060'],
               [0.6, '#333333']
            ]
         },
         borderColor: '#000000',
         symbolStroke: '#C0C0C0',
         hoverSymbolStroke: '#FFFFFF'
      }
   },
   
   exporting: {
      buttons: {
         exportButton: {
            symbolFill: '#55BE3B'
         },
         printButton: {
            symbolFill: '#7797BE'
         }
      }
   },   
   
   // special colors for some of the demo examples
   legendBackgroundColor: 'rgba(48, 48, 48, 0.8)',
   legendBackgroundColorSolid: 'rgb(70, 70, 70)',
   dataLabelsColor: '#444',
   textColor: '#E0E0E0',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme); 

</script>
{/literal}
 
 
<div>
<div id='container'>
</div>
<br />
Показать статистику по
<select name="type">
    <option value="sum_order">Сумме заказов</option>
    <option value="sum_margin">М</option>
</select>
за период с
<input name="date_from" type="text" value="" />
по 
<input name="date_to" type="text" value="" />
&nbsp;<a id="show" href="javascript:;">Показать</a>
&nbsp;<span style="color: blue;">Всего:&nbsp;<span id="total_price"></span></span>
</div>
