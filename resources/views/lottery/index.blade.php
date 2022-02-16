
@extends('layout')

@section('content')
 <!-- Lottery-Popup -->
        <div class="container-fluid a1 mt-5" >
            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                <h3 class="text-center my-5" style="color: #1773d1;">Click below button to trigger Lottery-Popup</h3>
                <a target="_blank" href="https://steponexp.net:8096/api/senddollarmessage?message=hi&ids=" class="btn lotbtn px-5">Lottery</a>
            </div>
        </div>
    <style type="text/css">
        table.dataTable tbody tr td {
    color: black; !important;
}
    </style>
@endsection