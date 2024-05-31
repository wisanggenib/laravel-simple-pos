@extends('template-admin.admin')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="card-title" style="margin-bottom: 0.8rem; font-weight:bold;font-size:1.2rem">Laporan
                    Penggunaan Budget</h2>
            </div>
            <div class="col-md-12">
                <a href="https://sales.wisanggenib.net/export-excel-budget" target="_blank">Download Excel</a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Area</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Area</th>
                                    <th>Budget</th>
                                    <th>Pembelian</th>
                                    <th>Sisa Budget</th>
                                </tr>
                            </thead>
                            <tbody id="dashboard-budget">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
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
        fetchDataBudget()

        function fetchDataBudget(){
            $.ajax({
                type:"GET",
                url:"/dashboard-fetch-budget",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    console.log(respons)
                    $('#dashboard-budget').html('')
                    $.each(respons.data, function(key, d){
                        let a = parseInt(key) + 1
                        let expenses = d.expenses > 0 ? d.expenses : 0
                        let curBal = d.expenses > 0 ? d.area_budget - parseInt(d.expenses) : d.area_budget-0
                        $('#dashboard-budget').append('<tr>\
                        <td>'+a+'.</td>\
                        <td>'+d.area_name+'</td>\
                        <td><span class="badge">'+formatRupiah(d.area_budget)+'</span></td>\
                        <td><span class="badge">'+formatRupiah(expenses)+'</span></td>\
                        <td><span class="badge bg-success">'+formatRupiah(curBal)+'</span></td>\
                        <tr>\
                        ')
                    })
                }
            })
        }

    })
</script>
@endsection
@endsection