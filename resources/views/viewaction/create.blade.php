@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h2">Barang Masuk</h1>
    </div>

    <main class="form-signin w-100 mt-3">
        <hr class="my-3">
        <div class="table-responsive small  col-lg-10">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Kuantitas</th>
                        <th scope="col">Catatan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>random</td>
                        <td>data</td>
                        <td>placeholder</td>
                        <td>oakwokaw</td>
                        <td>oakwokaw</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    {{-- <div class="col-lg-4">
        <div class="bg-light p-4 rounded ">
            <form method="POST" action="/action/create">
                <h1 class="h3 mb-3 fw-normal text-center">Header</h1>

                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
                    <label for="floatingInput">Kode</label>
                </div>

                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" />
                    <label for="floatingPassword">Tanggal</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" />
                    <label for="floatingPassword">Keterangan</label>
                </div>

                <button class="w-100 btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div> --}}
@endsection
