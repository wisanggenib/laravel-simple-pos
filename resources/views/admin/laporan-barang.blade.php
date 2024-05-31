@extends('template-admin.admin')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="card-title" style="margin-bottom: 0.8rem; font-weight:bold;font-size:1.2rem">Laporan
                    Penjualan Barang</h2>
            </div>
            <div class="col-md-12">
                <a href="https://sales.wisanggenib.net/export-excel-product" target="_blank">Download Excel</a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Barang</h3>
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

        function fetchData(){
            $.ajax({
                type:"GET",
                url:"/dashboard-fetch-product/all",
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

    })
</script>
@endsection
@endsection