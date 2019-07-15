<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wana Indo Raya - Monitoring</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/grayscale.min.css') }}" rel="stylesheet">

    <!-- data tabel css -->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- jquery data tabel -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <!-- untuk chart air -->
    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
        rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme2.css') }}" />

    <!-- Head Libs -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>

    <!-- ini untuk chart line -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


</head>

<body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">HOME</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">Data Terkini</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#projects">Grafik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#signup">Histori</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="masthead">
        <div class="container d-flex h-100 align-items-center">
            <div class="mx-auto text-center">
                <img src="{{ asset('img/logo.png') }}">
                <h1 class="mx-auto my-0">Wana Indo Raya</h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5">Monitoring Level Air.</h2>
                <a href="#about" class="btn btn-primary js-scroll-trigger">Mulai</a>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="text-white mb-4">Data Terkini</h2>
                    <h4 class="text-white-50">Volume Air</h4>
                    <div class="circle col-lg-8 mx-auto mb-4" id="data_terkini">0</div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="projects-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h2 class="text-black">Grafik Level Air</h2>
                </div>
                <div class="col-md-3">
                    <input id="date" type="date" class="form-control" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::now())) }}">  
                </div>
            </div>
            <canvas id="myChart" width="200" height="95"></canvas>

        </div>
    </section>

    <!-- Signup Section -->
    <section id="signup" class="signup-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 mx-auto text-center">

                    {{-- <i class="far fa-paper-plane fa-2x mb-2 text-white"></i> --}}
                    <h2 class="text-black mb-5">Histori Data Level Air</h2>

                    <table id="histori" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Level Air</th>
                            </tr>
                        </thead>
                    </table>

                    <script>
                        var ctx = document.getElementById('myChart');

                        var data = @json($data);
                        var label = @json($label);

                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: label,
                                datasets: [{
                                    label: 'Level Air',
                                    data: data,
                                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                                    borderColor: 'rgba(0, 0, 255, 1)',
                                    borderWidth: 1
                                }]
                            }
                        });

                        var table = $('#histori').DataTable({
                            "ajax": "{{ route('api.show') }}"
                        });

                        setInterval(function () {
                            var date = $('#date').val();
                            load();
                            var lastData = table.row().data()[1];
                            var newData = "";
                            $.ajax({
                                type: "GET",
                                url: "{{ route('api.show') }}",
                                success: function (dt) {
                                    newData = dt.data[0][1];
                                    if (!(lastData===newData)) {
                                        table.ajax.reload();    
                                    }
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "{{ route('api.update') }}",
                                data: {
                                    date: date
                                },
                                success: function (dt) {
                                    myChart.data.labels = dt.label;
                                    myChart.data.datasets.forEach((dataset) => {
                                        dataset.data = dt.data;
                                    });
                                    myChart.update();
                                }
                            });
                        }, 2000);
                        
                        function load() {
                            $.ajax({
                                url: "{{ route('api.showLatest') }}",
                            }).done(function (data) {
                                $('#data_terkini').html(data+" L");
                            });
                        }

                    </script>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black small text-center text-white-50">
        <div class="container">
            {{-- Copyright &copy; Your Website 2019 --}}
            Wana Indo Raya
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('js/grayscale.min.js') }}"></script>

    <!-- ini untuk chart air -->
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendor/snap-svg/snap.svg.js') }}"></script>
    <script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/javascripts/theme.js') }}"></script>

    <!-- Examples -->
    <script src="{{ asset('assets/javascripts/dashboard/examples.dashboard.js') }}"></script>


</body>

</html>
