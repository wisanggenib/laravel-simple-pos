@extends('template-admin.admin')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Stock Barang Menipis (Non Vendor)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Barang</th>
                                    <th>Sisa Stock</th>
                                </tr>
                            </thead>
                            <tbody id="barang-minus">
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top 10 Barang Terlaris</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Barang</th>
                                    <th>Penjualan</th>
                                </tr>
                            </thead>
                            <tbody id="barang-laris">
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Top Vendor</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="myChart" width="400" height="400"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix" id="donat-cart">
                                </ul>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Budget
                            </span>

                            <span class="mr-2">
                                <i class="fas fa-square text-gray"></i> Pembelian
                            </span>

                            <span>
                                <i class="fas fa-square text-gray" style="color:#28A745 !important"></i> Sisa
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@section('scripts')
{{-- custom script --}}
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function(){
        fetchData()
        fetchDataVendor()
        fetchDataBudget()
        fetchMinus()
        var vendorData = null;
        
        function fetchData(){
            $.ajax({
                type:"GET",
                url:"/dashboard-fetch-product/10",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    console.log(respons)
                    $('#barang-laris').html('')
                    $.each(respons.data, function(key, d){
                        let a = parseInt(key) + 1
                        $('#barang-laris').append('<tr>\
                        <td>'+a+'.</td>\
                        <td>'+d.product_name+'</td>\
                        <td>'+d.items_total+' Terjual</td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        function fetchMinus(){
            $.ajax({
                type:"GET",
                url:"/dashboard-fetch-product-minus",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    console.log(respons,"INI")
                    const sort = respons.products.sort((a,b) => a.available_stock - b.available_stock);
                    $('#barang-minus').html('')
                    $.each(sort, function(key, d){
                        let a = parseInt(key) + 1
                        $('#barang-minus').append('<tr>\
                        <td>'+a+'.</td>\
                        <td>'+d.product_name+'</td>\
                        <td>'+d.available_stock+' Terjual</td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

        function fetchDataVendor(){
            $.ajax({
                type:"GET",
                url:"/cart-fetch-vendor",
                dataType:"json",
                success: function(respons){
                    vendorData = {
                            labels: respons.data.labels,
                        datasets: [
                            {
                                data: respons.data.data,
                                backgroundColor: respons.data.background
                            }
                        ]
                    }

                    var ctx = document.getElementById('myChart').getContext('2d');
                    var pieOptions = {
                        legend: {
                        display: false
                        }
                    }
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: vendorData,
                        options:pieOptions
                    });

                    //handling label
                    $('#donat-cart').html('')
                    $.each(respons.data.data, function(key, d){
                        let a = parseInt(key) + 1
                        $('#donat-cart').append('<li><i class="far fa-circle" style="color: '+respons?.data?.background[key]+'"></i> '+respons?.data?.labels[key]+'</li>')
                    })
                }
            })
        }

        function fetchDataBudget(){
            $.ajax({
                type:"GET",
                url:"/cart-fetch-budget",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    console.log(respons)
                    var ctx2 = document.getElementById('sales-chart').getContext('2d');
                    let datass = {
                        labels: respons?.data?.labels,
                        datasets: [
                            {
                                backgroundColor: '#007bff',
                                borderColor: '#007bff',
                                data: respons?.data?.datas
                            },
                            {
                                backgroundColor: '#ced4da',
                                borderColor: '#ced4da',
                                data: respons?.data?.expenses
                            },
                            {
                                backgroundColor: '#28A745',
                                borderColor: '#28A745',
                                data: respons?.data?.leftover
                            }
                        ]
                        };
                    let optionsx = {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        }
                    };
                    var myBarChart = new Chart(ctx2, {
                        type: 'bar',
                        data: datass,
                        options: optionsx
                    });
                }
            })
        }

    })
</script>
@endsection
@endsection