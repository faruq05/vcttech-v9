var data = {
    labels: [
        "Claritas est etiam processus",
        "Mirum est notare quam littera",
        "Investigationes demonstraverunt",
        "Eodem modo typi"
    ],
    datasets: [
        {
            data: [48, 23, 17, 22],
            backgroundColor: [
                "#1A71FF",
                "#84DADF",
                "#34b8ed",
                "#1A71FF"
            ]
        }]
};
var ctx = document.getElementById("myChart");
$(document).ready(function () {

    $('#myChart').waypoint(function () {
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                legend: {
                    display: false
                }
            },
            animation: {
                animateScale: true
            }
        });
        this.destroy();
    }, {offset: '75%'});
});
