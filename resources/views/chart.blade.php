@extends('layout')
@section('content')
<main>
<div class="container-fluid">
    <h3 class="mt-4">Statistiques des inscriptions</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Statistiques</li>
        </ol>
        <div class="card-deck">
            <div class="card col-sm-6">
                <div class="card-body" >
                        <h5 class="card-title">Diagramme en donut</h5><hr>
                        <canvas id="canvas" width="100%" height="50" ></canvas>
                </div>
            </div>
            <div class="card col-sm-6">
                <div class="card-body" >
                        <h5 class="card-title">Diagramme en bâtons</h5><hr>
                        <canvas id="baton" width="100%" height="50" ></canvas>
                </div>
            </div>
        </div><br>
        <div class="card-deck">
            <div class="card col-sm-12">
                <div class="card-body" >
                        <h5 class="card-title">Diagramme en ligne</h5><hr>
                        <canvas id="radar" width="100%" height="50" ></canvas>
                </div>
            </div>
        </div>
</div>
</main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <script>
            var url = "{{url('detailsChart')}}";
            var Numbers = new Array();
            var Labels = new Array();
            var Options = new Array();
            //var Numbers = new Array('1','2','4');
            //var Options = new Array('A','B','C');
            $.get(url, function(response){
                //alert(response.Nombres);
                response.Options.forEach(element=>{
                        Options.push(element);
                });
                response.Nombres.forEach(element=>{
                        Numbers.push(element);
                });
                var ctx = document.getElementById("baton").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels:Options,
                        datasets: [{
                            label: 'Statistiques',
                            barPercentage: 0.5,
                            backgroundColor : ["#007bff","#ffc107","#28a745","#dc3545"],
                            data: Numbers,
                            borderWidth: 0.5
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });

            });
</script>
<script>
                var url = "{{url('detailsChart')}}";
                var Labels = new Array();
                var Datas = new Array();
                $.get(url, function(response){
                //alert(response.Nombres);
                    response.Options.forEach(element=>{
                        Labels.push(element);
                    });
                    response.Nombres.forEach(element=>{
                        Datas.push(element);
                    });

                    Chart.defaults.defaultFontFamily = 'Century Gothic Regular';

                     //get the pie chart canvas
                        var ctx1 = document.getElementById("canvas");;
                        //pie chart data
                        var data1 =
                        {
                            labels: Labels,
                            data : Datas,
                            datasets: [
                            {
                                label: "Statistiques",
                                data: Datas,
                                backgroundColor: [
                                    "#007bff",
                                    "#ffc107",
                                    "#28a745",
                                    "#dc3545"
                                ],
                                borderColor: [
                                    "white",
                                    "white",
                                    "white",
                                    "white"
                                ],
                                borderWidth: [1, 1, 1, 1],
                                borderAlign : 'center'
                            }
                            ]
                        };

                        //options
                        var options = {
                            responsive: true,
                            cutoutPercentage: 50,
                            circumference : 2 * Math.PI,
                            title: {
                            display: true,
                            position: "top",
                            text: "Statistiques",
                            fontSize: 18,
                            fontColor: "#111",
                            fontFamily : 'Century Gothic Regular'
                            },
                            legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                fontColor: "#333",
                                fontSize: 15,
                                fontFamily : 'Century Gothic Regular'
                            }
                            }
                        };

                        //create Chart class object
                        var canvas = new Chart(ctx1, {
                            type: "pie",
                            data: data1,
                            options: options
                        });
                });
</script>
<script>
    var url = "{{url('detailsChart')}}";
            var Numbs = new Array();
            var Labels = new Array();
            var Opts = new Array();
            $.get(url, function(response){
                //alert(response.Nombres);
                response.Options.forEach(element=>{
                        Opts.push(element);
                });
                response.Nombres.forEach(element=>{
                        Numbs.push(element);
                });
                var ctx = document.getElementById("radar").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Opts,
                        datasets: [{
                            label: 'Statistiques',
                            backgroundColor : ["#007bff","#ffc107","#28a745","#dc3545"],
                            data: Numbs,
                            fill:false,
                            spanGaps:true
                        }]
                    },
                    options: {
                            scales: {
                                yAxes: [{
                                    stacked: true
                                }]
                            }
                    }
                });

            });
</script>
@endsection
