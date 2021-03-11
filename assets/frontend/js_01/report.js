$(document).ready(function() {
    if (typeof $('.custom-report-page').html() != 'undefined' || typeof $('.custom-report-graph-page').html() != 'undefined') {
        $('.add-report').on('click', function() {
            $('.add-form').toggle();
        });
        $('a.rm-data').on('click', function() {
            if (confirm('Are you sure you want to delete this report?')) {
                return true;
            }
            return false;
        });
        $('#graph_form #date_type').on('change', function() {
            if ($(this).val() == 'custom') {
                $('#from_date, #to_date').removeAttr('disabled');
            } else {
                $('#from_date, #to_date').attr('disabled', 'disabled');
            }
        });
        $('.custom-report-graph-page .show-dashboard').on('click', function() {
            if ($(this).children().attr('checked') == 'checked') {
                return false;
            }
            if (!confirm('Are you sure you want to show this graph on dashboard?')) {
                return false;
            }
            $(this).children().attr('checked', 'checked');
            var pid = $(this).children().val();
            $.ajax({
                url: base_url + 'report/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'graph_to_dashboard',
                    pid: pid
                },
                async: false,
                success: function(response) {
                    setAlert('success', response.msg);
                }
            });
        });
    }

    if (typeof $('.report-graph-page').html() != 'undefined') {
        var pos = location.href.lastIndexOf('/');
        var cid = location.href.substring(pos + 1);
        if (!isNaN(cid)) {
            $.ajax({
                url: base_url + 'report/ajaxupdate?ct=' + Date.now() + '&cr=' + Math.floor(Math.random() * 9999999999),
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'get_cstm_graph',
                    cid: cid
                },
                async: false,
                success: function(response) {
                    if (response.success) {
                        /*if (response.ut == 'breport') {
                            // var axisY2title = 'Resellers';
                            var axisY2title = 'Product Price';
                        } else {
                            // var axisY2title = 'Customers';
                            var axisY2title = 'Product Price';
                        }*/
                        var dp1 = [];
                        var is_empty = true;
                        // var dp2 = [];
                        $(response.content).each(function(i, v) {
                            is_empty = true;
                            var total_unit = (v.total_unit != 'undefined') ? v.total_unit : ((v.total_price != 'undefined') ? v.total_price : 0);
                            // var total_price = (v.sale_price != 'undefined') ? v.sale_price : ((v.product_price != 'undefined') ? v.product_price : 0);
                            // var dt = new Date(parseInt(v.modified_date) * 1000);
                            // var dt = v.modified_date;
                            // var dt = date.toString('dd-MM-yy');
                            var dt = new Date(v.modified_date);
                            dp1.push({
                                x: dt,
                                y: parseInt(total_unit)
                            });
                            // dp2.push({
                            //     x: dt,
                            //     y: parseInt(total_price)
                            // });
                        });

                        if (is_empty) {
                            // dp1 = [{x: '', y: 0}];
                            dp1 = [
                                {x: '', y: -3},
                                {x: '', y: -2},
                                {x: '', y: -1},
                                {x: '', y: 0},
                                {x: '', y: 1},
                                {x: '', y: 2},
                                {x: '', y: 3}
                            ];
                        }

                        $('.header .title').html(response.name);
                        $('.graph-container .gr-title').html('Total ' + response.type);
                        getGraph(dp1, response.type, 'graph');
                    }
                }
            });
        }

        $('.act button').on('click', function() {
          if ($(this).attr('class').indexOf('print') != -1) {
            $('.canvasjs-chart-toolbar > div div:eq(0)').trigger('click');
          } else if ($(this).attr('class').indexOf('jpg') != -1) {
            $('.canvasjs-chart-toolbar > div div:eq(1)').trigger('click');
          } else if ($(this).attr('class').indexOf('png') != -1) {
            $('.canvasjs-chart-toolbar > div div:eq(2)').trigger('click');
          }
        });
    }

});

function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}

function getGraph(dp1, type, ele) {
    var options = {
        exportEnabled: true,
        animationEnabled: true,
        title: {
            // text: "Units Sold VS Profit"
        },
        subtitles: [{
            // text: "Click Legend to Hide or Unhide Data Series"
        }],
        axisX: {
            title: ""
        },
        axisY: {
            title: '',
            // title: 'Total ' + type,
            // titleFontColor: "#4F81BC",
            titleFontColor: "#c0c0c0",
            lineColor: "#F4F6F8",
            // labelFontColor: "#4F81BC",
            labelFontColor: "#c0c0c0",
            tickColor: "#F4F6F8",
            includeZero: false
        },
        /*axisY2: {
            title: axisY2title,
            titleFontColor: "#C0504E",
            lineColor: "#C0504E",
            labelFontColor: "#C0504E",
            tickColor: "#C0504E",
            includeZero: false
        },*/
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            itemclick: toggleDataSeries
        },
        data: [{
                type: "spline",
                name: "Units",
                showInLegend: true,
                // xValueFormatString: "DD MM YYYY",
                yValueFormatString: "###",
                dataPoints: dp1
            }
            /*, {
                                            type: "spline",
                                            name: "Price",
                                            axisYType: "secondary",
                                            showInLegend: true,
                                            // xValueFormatString: "DD MM YYYY",
                                            yValueFormatString: "###",
                                            dataPoints: dp2
                                        }*/
        ]
    };
    $("#" + ele).CanvasJSChart(options);
}

/*if (typeof am4core != 'undefined') {
am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("graph", am4charts.XYChart);
    chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

    chart.data = [{
        country: "Product",
        visits: 23725
    }, {
        country: "Product1",
        visits: 1882
    }, {
        country: "Product2",
        visits: 1809
    }, {
        country: "Product3",
        visits: 1322
    }, {
        country: "Product4",
        visits: 1122
    }, {
        country: "Product5",
        visits: 1114
    }, {
        country: "Product6",
        visits: 984
    }];

    function rGraph () {
      var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.dataFields.category = "country";
      categoryAxis.renderer.minGridDistance = 40;
      categoryAxis.fontSize = 11;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
      valueAxis.min = 0;
      valueAxis.max = 12000;
      valueAxis.strictMinMax = true;
      valueAxis.renderer.minGridDistance = 30;
      // axis break
      var axisBreak = valueAxis.axisBreaks.create();
      axisBreak.startValue = 4100;
      axisBreak.endValue = 7000;
      axisBreak.breakSize = 0.005;

      // make break expand on hover
      var hoverState = axisBreak.states.create("hover");
      hoverState.properties.breakSize = 1;
      hoverState.properties.opacity = 0.1;
      hoverState.transitionDuration = 1500;

      axisBreak.defaultState.transitionDuration = 1000;
      /*
      // this is exactly the same, but with events
      axisBreak.events.on("over", function() {
        axisBreak.animate(
          [{ property: "breakSize", to: 1 }, { property: "opacity", to: 0.1 }],
          1500,
          am4core.ease.sinOut
        );
      });
      axisBreak.events.on("out", function() {
        axisBreak.animate(
          [{ property: "breakSize", to: 0.005 }, { property: "opacity", to: 1 }],
          1000,
          am4core.ease.quadOut
        );
      });*/

/*var series = chart.series.push(new am4charts.ColumnSeries());
      series.dataFields.categoryX = "country";
      series.dataFields.valueY = "visits";
      series.columns.template.tooltipText = "{valueY.value}";
      series.columns.template.tooltipY = 0;
      series.columns.template.strokeOpacity = 0;

      // as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
      series.columns.template.adapter.add("fill", function(fill, target) {
          return chart.colors.getIndex(target.dataItem.index);
      });
    }
}); // end am4core.ready()
}*/