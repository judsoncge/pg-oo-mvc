$('#export').click(function () {

    var obj = {},
        chart;
    
    chart = $('#pizza1').highcharts();
    obj.svg = chart.getSVG();
    obj.type = 'image/png';
    obj.width = 650; 
    obj.async = true;
    
    
    $.ajax({
        type: 'post',
        url: chart.options.exporting.url,        
        data: obj, 
        success: function (data) {            
            var exportUrl = this.url,
                export_pizza1 = $("#export_pizza1");
            $('<img>').attr('src', exportUrl + data).attr('width','650px').appendTo(export_pizza1);
            $('<a>or Download Here</a>').attr('href',exportUrl + data).appendTo(export_pizza1);
            $('img').fadeIn();
        }        
    });


});

$(function () {
    Highcharts.chart('pizza1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '300 ENTRARAM SÓ NESSE MÊS'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}, {point.x:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}, {point.x:.1f}%',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'SUCOF',
                x: 20.01,
                y: 56.33,
                color: '#3498db'
            }, {
                name: 'SUPAD',
                x: 15,
                y: 24.03,
                /*sliced: true,
                selected: true,*/
                color: '#9b59b6'
            }, {
                name: 'SUCOR',
                x: 17.2,
                y: 10.38,
                color: '#f1c40f'
            }, {
                name: 'ADM',
                x: 44,
                y: 4.77,
                color: '#e67e22'
            }, {
                name: 'GABIN',
                x: 0.2,
                y: 0.91,
                color: '#2ecc71'
            }]
        }]
    });
});


$(function () {
    Highcharts.chart('pizza2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '3.000 ACUMULADOS ATÉ ESSE MÊS'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}, {point.x:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}, {point.x:.1f}%',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'SUCOF',
                x: 15,
                y: 26.33,
                color: '#3498db'
            }, {
                name: 'SUPAD',
                x: 30.04,
                y: 54.03,
                /*sliced: true,
                selected: true,*/
                color: '#9b59b6'
            }, {
                name: 'SUCOR',
                x: 17.50,
                y: 10.38,
                color: '#f1c40f'
            }, {
                name: 'ADM',
                x: 1,
                y: 0.77,
                color: '#e67e22'
            }, {
                name: 'GABIN',
                x: 10.06,
                y: 4.91,
                color: '#2ecc71'
            }]
        }]
    });
});



$(function () {
    Highcharts.chart('pizza3', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '6.000 PROCESSOS CONCLUÍDOS EM 2016'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}, {point.x:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}, {point.x:.1f}%',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                }
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'SUCOF',
                x: 15,
                y: 26.33,
                color: '#3498db'
            }, {
                name: 'SUPAD',
                x: 30.04,
                y: 54.03,
                /*sliced: true,
                selected: true,*/
                color: '#9b59b6'
            }, {
                name: 'SUCOR',
                x: 17.50,
                y: 10.38,
                color: '#f1c40f'
            }, {
                name: 'ADM',
                x: 1,
                y: 0.77,
                color: '#e67e22'
            }, {
                name: 'GABIN',
                x: 10.06,
                y: 4.91,
                color: '#2ecc71'
            }]
        }]
    });
});


$(function () {

    $(document).ready(function () {

        // Build the chart
        Highcharts.chart('pizza4', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'QUANTIDADE DE PROCESSOS POR TIPO'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}, {point.x:.1f}%',
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: '',
                colorByPoint: true,
                data: [{
                    name: 'Interno',
                    y: 56.33
                }, {
                    name: 'Externo',
                    y: 24.03,
                    color: '#16a085'
                }, {
                    name: 'Administrativo',
                    y: 10.38
                }, {
                    name: 'LAI',
                    y: 4.77
                }, {
                    name: 'Judiciário',
                    y: 0.91
                }, {
                    name: 'Outros',
                    y: 0.2
                }]
            }]
        });
    });
});
    $(function () {
    Highcharts.chart('barra1', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'RANKING DA EXECUÇÃO DOS PROCESSOS DE 2016'
        },
        xAxis: {
            categories: ['CGE', 'SUCOF', 'SUPAD', 'SUCOR', 'ADM', 'GABIN']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total fruit consumption'
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [ {
            name: 'Sem prazo',
            data: [6, 6, 4, 6, 6, 5],
            color: '#bdc3c7'
        }, {
            name: 'Finalizado',
            data: [5, 3, 4, 7, 2, 1],
            color: '#9b59b6'
        }, {
            name: 'Concluído',
            data: [2, 2, 3, 2, 1, 3],
            color: '#3498db'
        }, {
            name: 'Atrasado',
            data: [3, 4, 4, 2, 5, 5],
            color: '#e74c3c'
        }, {
            name: 'Em andamento',
            data: [3, 4, 4, 2, 5, 5],
            color: '#2ecc71'
        }]
    });
});






$(function () {
    Highcharts.chart('coluna1', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'COMPORTAMENTO DOS PROCESSOS NO MÊS'
        },

        xAxis: {
            categories: ['Setembro', 'Outubro', 'Novembro']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Quantidade de processos'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },

        series: [{
            name: 'Entraram',
            data: [10, 10, 10],
            stack: 'male',
            color: '#27ae60'
        }, {
            name: 'Vindo do mês anterior',
            data: [0, 2, 4],
            stack: 'male',
            color: '#2ecc71'
        }, {
            name: 'Déficit',
            data: [2, 4, 4],
            stack: 'female',
            color: '#bdc3c7'
        }, {
            name: 'Saíram',
            data: [8, 8, 10],
            stack: 'female',
            color: '#3498db'
        }]
    });
});




$(function () {
    Highcharts.chart('coluna2', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'QUANTIDADE DE PROCESSOS EM 2016'
        },

        xAxis: {
            categories: ['Semtembro', 'Outubro', 'Novembro']
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Quantidade de processos'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },

        series: [{
            name: 'Entraram',
            data: [10, 10, 10],
            color: '#27ae60'
        }, {
            name: 'Vindo do mês anterior',
            data: [0, 2, 4],
            stack: 'male',
            color: '#2ecc71'
        }, {
            name: 'Déficit',
            data: [2, 4, 4],
            color: '#bdc3c7'
        }, {
            name: 'Saíram',
            data: [8, 8, 10],
            color: '#3498db'
        }]
    });
});






$(function () {
    Highcharts.chart('coluna3', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'TEMPO MÉDIO DE CONCLUSÃO DOS PROCESSOS'
        },
        /*subtitle: {
            text: 'Source: WorldClimate.com'
        },*/
        xAxis: {
            categories: [
                'Até 15',
                'Até 30',
                'Até 45',
                'Até 60',
                'Até 120'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Dias no órgão'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                showInLegend: false,
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [{
            name: 'Até 15',
            data: [49, 71, 106, 129, 140],
            color: '#3498db'
        }]
    });
});



$(function () {
    Highcharts.chart('linha1', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'TEMPO MÉDIO DE TRAMITAÇÃO DOS PROCESSOS'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: {
            categories: ['Setembro', 'Outubro', 'Novembro']
        },
        yAxis: {
            title: {
                text: 'Dias no órgão'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true,
                showInLegend: false
            }
        },
        series: [{
            name: 'Dias',
            data: [7, 6, 9]
        }]
    });
});