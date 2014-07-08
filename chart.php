<?php include "header.php" ?>
<?php
date_default_timezone_set('Europe/Istanbul');
include("source/Connection.php");
$conn = new Connection();
$conn->connectToDatabase();
$conn->selectDatabase();
$result = mysql_query("select * from path s where s.id = '".$_GET["pathId"]."'");
$row = mysql_fetch_row($result,MYSQL_BOTH);

?>
<div class="gboxtop" style="margin-top: 60px"></div>
<div class="gbox" style="text-align: left">
    <div id="title"><h2><?php echo $row[5]; ?></h2></div>
    <div id="description"><h3><?php echo $row[1]; ?></h3></div>
    <div id="url"><?php echo get_base_url().$_GET["pathId"]; ?></div>
    <div id="clickCount"></div>
</div>
    <script type="text/javascript">
        var chart;
        var pathId = <?php echo "'".$_GET["pathId"]."';";?>
        $(document).ready(function() {
            var optionsBrowser = {
                chart: {
                    renderTo: 'container1',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    margin:50
                },
                credits: {
                    text: '',
                    href: '#'
                },
                title: {
                    text: 'Browsers'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                    percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b><br /> '+ this.percentage.toFixed(1) +' %';
                            },
                            distance: 15.0,
                            crop: true

                        },
                        percentageDecimals:1
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Usage share of web browsers'
                }]
            }
            jQuery.get('dataBrowser.php',{ path_id:pathId },function(tsv) {
                var lines = [];
                traffic = [];
                try {// split the data return into lines and parse them
                    tsv = tsv.split(/\n/g);
                    jQuery.each(tsv, function(i, line) {
                        line = line.split(/\t/);
                        traffic.push([
                            line[0],
                            parseInt(line[1].replace(',', ''), 10)
                        ]);
                    });
                } catch (e) {  }
                optionsBrowser.series[0].data = traffic;
                chart = new Highcharts.Chart(optionsBrowser);
            });
/***************************************************************************************/
            var optionsCountries = {
                chart: {
                    renderTo: 'container2',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    margin:50
                },
                credits: {
                    text: '',
                    href: '#'
                },
                title: {
                    text: 'Countries'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                    percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b><br /> '+ this.percentage.toFixed(1) +' %';
                            },
                            distance: 15.0,
                            crop: true
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Usage share of countries'
                }]
            }
            jQuery.get('dataCountries.php',{ path_id:pathId },function(tsv) {
                var lines = [];
                traffic = [];
                try {// split the data return into lines and parse them
                    tsv = tsv.split(/\n/g);
                    jQuery.each(tsv, function(i, line) {
                        line = line.split(/\t/);
                        traffic.push([
                            line[0],
                            parseInt(line[1].replace(',', ''), 10)
                        ]);
                    });
                } catch (e) {  }
                optionsCountries.series[0].data = traffic;
                chart = new Highcharts.Chart(optionsCountries);
            });
            /***************************************************************************************/

            var optionsMobiles= {
                chart: {
                    renderTo: 'container3',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    margin:50
                },
                credits: {
                    text: '',
                    href: '#'
                },
                title: {
                    text: 'Mobile or Desktop'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                    percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b><br /> '+ this.percentage.toFixed(1) +' %';
                            },
                            distance: 15.0,
                            crop: false
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Usage share of mobile or desktop'
                }]
            }
            jQuery.get('dataMobiles.php',{ path_id:pathId },function(tsv) {
                var lines = [];
                traffic = [];
                try {// split the data return into lines and parse them
                    tsv = tsv.split(/\n/g);
                    jQuery.each(tsv, function(i, line) {
                        line = line.split(/\t/);
                        traffic.push([
                            line[0],
                            parseInt(line[1].replace(',', ''), 10)
                        ]);
                    });
                } catch (e) {  }
                optionsMobiles.series[0].data = traffic;
                chart = new Highcharts.Chart(optionsMobiles);
            });
            /***************************************************************************************/


            var optionsReferer= {
                chart: {
                    renderTo: 'container4',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    margin:50
                },
                credits: {
                    text: '',
                    href: '#'
                },
                title: {
                    text: 'Referers'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                    percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b><br /> '+ this.percentage.toFixed(1) +' %';
                            },
                            distance: 15.0,
                            crop: true
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Usage share by Referers'
                }]
            }
            jQuery.get('dataReferer.php',{ path_id:pathId },function(tsv) {
                var lines = [];
                traffic = [];
                try {// split the data return into lines and parse them
                    tsv = tsv.split(/\n/g);
                    jQuery.each(tsv, function(i, line) {
                        line = line.split(/\t/);
                        traffic.push([
                            line[0],
                            parseInt(line[1].replace(',', ''), 10)
                        ]);
                    });
                } catch (e) {  }
                optionsReferer.series[0].data = traffic;
                chart = new Highcharts.Chart(optionsReferer);
            });
            /***************************************************************************************/

            var optionsx= {
                chart: {
                    renderTo: 'container5',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'column'
                    //zoomType: 'x'
                },
                credits: {
                    text: '',
                    href: '#'
                },
                title: {
                    text: 'Time Line'
                },
                tooltip: {
                    xDateFormat: '%d-%m-%Y'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    type: 'column',
                    name: 'Usage share of date',
                    pointWidth: 10,
                    pointInterval: 24 * 3600 * 1000
                }],
                xAxis: {
                    type: 'datetime',
                    minRange: 24 * 3600 * 1000,
                    labels: {
                        rotation: 315,
                        align: 'right'
                    }
                },
                legend:{
                    enabled:false
                }
            }
            jQuery.get('dataTimeline.php',{ path_id:pathId },function(tsv) {
                var lines = [];
                traffic = [];
                try {// split the data return into lines and parse them
                    tsv = tsv.split(/\n/g);
                    jQuery.each(tsv, function(i, line) {
                        line = line.split(/\t/);
                        traffic.push([
                            Date.UTC(new Date(line[0]).getFullYear(),new Date(line[0]).getMonth(),new Date(line[0]).getDate()),
                            parseInt(line[1].replace(',', ''), 10)
                        ]);
                    });
                } catch (e) {  }
                optionsx.series[0].data = traffic;
                chart = new Highcharts.Chart(optionsx);
            });

        });

    </script>
<script src="highcharts/js/highcharts.js"></script>
    <style>
        .container{
            width: 450px; height: 300px; margin: 0 auto;padding: 0;
        }
    </style>
    <div style="margin: 80px auto; padding: 0 20px">
<table>
    <tr>
        <td>
            <div id="container1" class="container"></div>
        </td>
        <td>
            <div id="container2" class="container"></div>
        </td>
    </tr>
    <tr>
        <td>
            <div id="container3" class="container"></div>
        </td>
        <td>
            <div id="container4" class="container"></div>
        </td>
    </tr>
    <tr>
    <td colspan="2">
        <div id="container5" style="min-width: 800px; height: 300px; margin: 0 auto"></div>
    </td>
</tr>

</table>
</div>
<?php include "footer.php" ?>
