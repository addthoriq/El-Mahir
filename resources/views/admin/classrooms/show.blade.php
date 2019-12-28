@extends('admin.layouts.app')

@section('title', 'Tambah Data User')

@section('style')
    <link href="{{asset('inspinia/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/chartist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row wrapper white-bg page-heading">
        <div class="col-lg-10">
            <h2>Data Manajemen Kelas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.index') }}">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('classroom.index') }}">Manajemen Kelas</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Detail Kelas</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Profil Data Kelas</h5>
                        <div class="ibox-tools">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a data-toggle="modal" class="dropdown-item" href="#edit">Ubah Profil Kelas</a>
                                </li>
                            </ul>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        @include('admin.classrooms.edit')
                    </div>

                    <div class="ibox-content">
                        @if (session('notif'))
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                {{session('notif')}}
                            </div>
                        @endif
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                                <tr>
                                    <th>Wali Kelas</th>
                                    <td>{{$data->user->name}}</td>
                                </tr>
                                <tr>
                                    <th>Kapasitas Maksimal Siswa</th>
                                    <td>{{$data->max_student}}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Siswa</th>
                                    <td>{{$stds->count()}}</td>
                                </tr>
                                <tr>
                                    <th>Anggota Kelas </th>
                                    <td>
                                        <ul>
                                            @if ($stds)
                                                @foreach ($stds as $std)
                                                    <li>{{$std->student->name}}</li>
                                                @endforeach
                                            @else
                                                <i>Belum ada siswa disini</i>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Persentase</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="statistic-box mt-0">
                            <canvas id="siswa" height="50"></canvas>
                            <div class="m-t">
                                <small>Data diambil dari data manajemen kesiswaan.</small>
                            </div>
                        </div>
                        <form action="{{route('classroom.destroy',$data->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('classroom.index')}}" class="btn btn-success"><i class="fa fa-chevron-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-danger pull-right" onclick='javascript:return confirm(`Apakah anda yakin ingin menghapus data ini?`)'><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- iCheck -->
    <script src="{{ asset('inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- ChartJS-->
    <script src="{{asset('inspinia/js/plugins/chartJs/Chart.min.js')}}"></script>
    <script>
    var murid     = "{{route('classroom.chartMurid',$data->id)}}";
    $.get(murid, function(response){
        var ctx = document.getElementById('siswa').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: response,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                    ],
                    borderWidth: 1
                }]
            }
        });
        function addData(chart, label, color, data) {
            chart.data.datasets.push({
                backgroundColor: color,
                data: data
            });
            chart.update();
        }
    });
    $.get(guru, function(response){
        var ctx = document.getElementById('guru').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: response,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                    ],
                    borderWidth: 1
                }]
            }
        });
        function addData(chart, label, color, data) {
            chart.data.datasets.push({
                backgroundColor: color,
                data: data
            });
            chart.update();
        }
    });
    </script>
@endsection