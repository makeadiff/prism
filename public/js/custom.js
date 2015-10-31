

$(function () {

    var chart_setting = {

        credits: {
            enabled: !1
        },
        chart: {
            type: "scatter",
            height: 140,

            renderTo: "chart"

        },
        title: {
            align: "left",
            style: {
                color: "#000",
                fontSize: "13px",

            },
            text: "You received an average rating of N/A. Your rating is in top N/A percentile of all N/A."
        },
        legend: {
            useHTML: !0,
            align: "center",
            itemStyle: {
                color: "#000",
                fontSize: "10px",
                lineHeight: "15px",
            },
            borderWidth: 1,
        },
        xAxis: {
            min: 1,
            max: 5,
            labels: {
                enabled: !1
            },
            tickLength: 0,
            lineWidth: 0
        },
        yAxis: [{
            max: 0,
            min: 0,
            tickInterval: 1,
            lineWidth: 0,

            title: {
                text: "Opportunity for<br/>growth",
                rotation: 0,
                align: "middle",
                offset: 60,
                style: {
                    color: "#000",
                    fontSize: "9px",
                    fontWeight: "normal",
                    lineHeight: "10px",
                    textTransform: "uppercase"
                }

            },
            labels: {

                enabled: !1
            },
        }, {
            title: {
                text: "Strength",
                rotation: 0,
                align: "middle",
                offset: 50,
                style: {
                    color: "#000",
                    fontSize: "9px",
                    fontWeight: "normal",
                    lineHeight: "10px",
                    textTransform: "uppercase"
                }
            },
            opposite: !0
        }],
        plotOptions: {
            scatter: {
                events: {
                    legendItemClick: function () {
                        return !1
                    }
                },
                marker: {
                    radius: 8,
                    states: {
                        hover: {
                            enabled: !0
                        }
                    },
                    symbol: "circle"
                },
                tooltip: {
                    headerFormat: "<b>{series.name}</b><br>",
                    pointFormat: "{point.x} out of 5",

                }
            }
        },
        series: [{
            name: "How you scored",
            color: "#4cb6e8",
            data: [[0, 0]],
        }, {
            name: "National strat average",
            color: "#b20303",
            data: [[0, 0]],
            zIndex: 8,
            marker: {
                symbol: "diamond"
            }

        }],


    };

    var managee_integrity,managee_team,manager_integrity,manager_team,peer_integrity,peer_team;

    //JS is weird. Hence.
    managee_integrity = JSON.parse(JSON.stringify(chart_setting));
    managee_team = JSON.parse(JSON.stringify(chart_setting));
    manager_integrity = JSON.parse(JSON.stringify(chart_setting));
    manager_team = JSON.parse(JSON.stringify(chart_setting));
    peer_integrity = JSON.parse(JSON.stringify(chart_setting));
    peer_team = JSON.parse(JSON.stringify(chart_setting));

    //Managee
    managee_integrity['title']['text'] = "You received an average rating of " + parseFloat(chart_data['managee'][1]['score']) +
        ". Your rating is in top N/A percentile of all " + user_type + "s."
    managee_integrity['series'][1]['name'] = "National " + user_type + " average";
    managee_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['managee'][1]['score']);
    managee_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['managee'][1]['average']);

    managee_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['managee'][2]['score']) +
        ". Your rating is in top N/A percentile of all " + user_type + "s."
    managee_team['series'][1]['name'] = "National " + user_type + " average";
    managee_team['series'][0]['data'][0][0] = parseFloat(chart_data['managee'][2]['score']);
    managee_team['series'][1]['data'][0][0] = parseFloat(chart_data['managee'][2]['average']);


    //Manager
    manager_integrity['title']['text'] = "You received an average rating of " + parseFloat(chart_data['manager'][1]['score']) +
        ". Your rating is in top N/A percentile of all " + user_type + "s."
    manager_integrity['series'][1]['name'] = "National " + user_type + " average";
    manager_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['manager'][1]['score']);
    manager_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['manager'][1]['average']);

    manager_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['manager'][2]['score']) +
        ". Your rating is in top N/A percentile of all " + user_type + "s."
    manager_team['series'][1]['name'] = "National " + user_type + " average";
    manager_team['series'][0]['data'][0][0] = parseFloat(chart_data['manager'][2]['score']);
    manager_team['series'][1]['data'][0][0] = parseFloat(chart_data['manager'][2]['average']);


    //Peer
    peer_integrity['title']['text'] = "You received an average rating of " + parseFloat(chart_data['peer'][1]['score']) +
                                        ". Your rating is in top N/A percentile of all " + user_type + "s."
    peer_integrity['series'][1]['name'] = "National " + user_type + " average";
    peer_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['peer'][1]['score']);
    peer_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['peer'][1]['average']);

    peer_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['peer'][2]['score']) +
        ". Your rating is in top N/A percentile of all " + user_type + "s."
    peer_integrity['series'][1]['name'] = "National " + user_type + " average";
    peer_team['series'][0]['data'][0][0] = parseFloat(chart_data['peer'][2]['score']);
    peer_team['series'][1]['data'][0][0] = parseFloat(chart_data['peer'][2]['average']);


    $('#chart-managee-Integrity').highcharts(managee_integrity);
    $('#chart-managee-Team-Work').highcharts(managee_team);
    $('#chart-manager-Integrity').highcharts(manager_integrity);
    $('#chart-manager-Team-Work').highcharts(manager_team);
    $('#chart-peer-Integrity').highcharts(peer_integrity);
    $('#chart-peer-Team-Work').highcharts(peer_team);

});


