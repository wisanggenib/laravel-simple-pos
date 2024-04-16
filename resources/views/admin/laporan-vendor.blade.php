@extends('template-admin.admin')

@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="card-title" style="margin-bottom: 0.8rem; font-weight:bold;font-size:1.2rem">Laporan
                    Vendor</h2>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Vendor</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Vendor</th>
                                    <th>Pembelian</th>
                                </tr>
                            </thead>
                            <tbody id="barang-vendor">
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
        fetchDataVendor()

        function fetchDataVendor(){
            $.ajax({
                type:"GET",
                url:"/dashboard-fetch-vendor",
                dataType:"json",
                success: function(respons){
                    // console.log(respons.areas)
                    let AA = respons.data.sort((a,b) => b.totals - a.totals);
                    $('#barang-vendor').html('')
                    $.each(AA, function(key, d){
                        let a = parseInt(key) + 1
                        $('#barang-vendor').append('<tr>\
                        <td>'+a+'.</td>\
                        <td>'+d.vendor_name+'</td>\
                        <td><span class="badge bg-secondary">'+d.totals+'</span></td>\
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