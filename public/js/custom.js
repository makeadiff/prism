

$(function () {

    $(".button-collapse").sideNav();

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
            text: "You received an average rating of N/A. Your rating is in the N/A of all N/A."
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
                text: "Opportunity<br>for growth",
                rotation: 0,
                align: "middle",
                offset: 35,
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
                offset: 30,
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
            name: "Your rating",
            color: "#03A9F4",
            data: [[0, 0]],
        }, {
            name: "National strat average",
            color: "#303F9F",
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
        ". Your rating is in the " + percentile_strings['managee'][1] + " of all " + user_type + "s."
    managee_integrity['series'][1]['name'] = "National " + user_type + " average";
    managee_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['managee'][1]['score']);
    managee_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['managee'][1]['average']);

    managee_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['managee'][2]['score']) +
        ". Your rating is in the " + percentile_strings['managee'][2] + " of all " + user_type + "s."
    managee_team['series'][1]['name'] = "National " + user_type + " average";
    managee_team['series'][0]['data'][0][0] = parseFloat(chart_data['managee'][2]['score']);
    managee_team['series'][1]['data'][0][0] = parseFloat(chart_data['managee'][2]['average']);


    //Manager
    manager_integrity['title']['text'] = "You received an average rating of " + parseFloat(chart_data['manager'][1]['score']) +
        ". Your rating is in the " + percentile_strings['manager'][1] + " of all " + user_type + "s."
    manager_integrity['series'][1]['name'] = "National " + user_type + " average";
    manager_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['manager'][1]['score']);
    manager_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['manager'][1]['average']);

    manager_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['manager'][2]['score']) +
        ". Your rating is in the " + percentile_strings['manager'][2] + " of all "+ user_type + "s."
    manager_team['series'][1]['name'] = "National " + user_type + " average";
    manager_team['series'][0]['data'][0][0] = parseFloat(chart_data['manager'][2]['score']);
    manager_team['series'][1]['data'][0][0] = parseFloat(chart_data['manager'][2]['average']);


    //Peer
    peer_integrity['title']['text'] = "You received an average rating of " + parseFloat(chart_data['peer'][1]['score']) +
                                        ". Your rating is in the " + percentile_strings['peer'][1] + " of all " + user_type + "s."
    peer_integrity['series'][1]['name'] = "National " + user_type + " average";
    peer_integrity['series'][0]['data'][0][0] = parseFloat(chart_data['peer'][1]['score']);
    peer_integrity['series'][1]['data'][0][0] = parseFloat(chart_data['peer'][1]['average']);

    peer_team['title']['text'] = "You received an average rating of " + parseFloat(chart_data['peer'][2]['score']) +
        ". Your rating is in the " + percentile_strings['peer'][2] + " of all " + user_type + "s."
    peer_team['series'][1]['name'] = "National " + user_type + " average";
    peer_team['series'][0]['data'][0][0] = parseFloat(chart_data['peer'][2]['score']);
    peer_team['series'][1]['data'][0][0] = parseFloat(chart_data['peer'][2]['average']);


    $('#chart-managee-Integrity').highcharts(managee_integrity);
    $('#chart-managee-Team-Work').highcharts(managee_team);
    $('#chart-manager-Integrity').highcharts(manager_integrity);
    $('#chart-manager-Team-Work').highcharts(manager_team);
    $('#chart-peer-Integrity').highcharts(peer_integrity);
    $('#chart-peer-Team-Work').highcharts(peer_team);




    //Code to generate heatmap

    // Function to get the max value in an Array
    Array.max = function(array){
        return Math.max.apply(Math,array);
    };

    // Get all data values from our table cells making sure to ignore the first column of text
    // Use the parseInt function to convert the text string to a number

    var counts= $('.heat-map tbody td').not('.stats-title').map(function() {
        return parseFloat($(this).text());
    }).get();

    // run max value function and store in variable
    var max = Array.max(counts);

    n = 200; // Declare the number of groups

    // Define the ending colour, which is white
    xr = 244; // Red value
    xg = 67; // Green value
    xb = 54; // Blue value

    // Define the starting colour #f32075
    yr = 76; // Red value
    yg = 175; // Green value
    yb = 80; // Blue value

    // Loop through each data point and calculate its % value
    $('.heat-map tbody td').not('.stats-title').each(function(){
        if(parseFloat($(this).text()) >= 4 )
            clr = '#039be5'
        else if(parseFloat($(this).text()) >= 3.5 && parseFloat($(this).text()) < 4 )
            clr = '#4fc3f7'
        else if(parseFloat($(this).text()) >= 2 && parseFloat($(this).text()) < 3.5 )
            clr = '#b3e5fc'
        else
            clr = '#e1f5fe'
        $(this).css({backgroundColor:clr});
    });



});


