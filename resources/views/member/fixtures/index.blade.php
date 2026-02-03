@extends('layouts.base')

@section('title', 'Daftar Jadwal Pertandingan');

@section('content')
<table class="table table-bordered text-center datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Kick Off</th>
            <th>Pertandingan</th>
            <th>Venu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fixtures as $fixture)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>@tanggalIndo($fixture->match_date)</td>
                <td>{{ $fixture->match_time }} WIT</td>
                <td>
                    <div class="row">
                    <div class="col-sm-4">
                    <img src="{{ asset('uploads/logo_club/'.$fixture->homeClub->logo) }}" height="40px" alt="home"/><br>
                    {{ $fixture->homeClub->name }} </div>
                     <div class="col-sm-4"><br>vs </div>
                     <div class="col-sm-4">
                    <img src="{{ asset('uploads/logo_club/'.$fixture->awayClub->logo) }}" height="40px" alt="home"/><br>
                    {{ $fixture->awayClub->name }}
                     </div>
                    </div>
                </td>
                <td>{{ $fixture->venue }}</td>
                <td>
                        <a href="{{ route('member.fixtures.show', $fixture->id) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye me-2"></i> Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
