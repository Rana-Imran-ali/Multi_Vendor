@extends('admin.layout.layout')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Auth Pages</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.pages.auth') }}">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Auth</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Auth Pages Settings</h3>
                </div>
                <div class="card-body">
                    <p>Coming soon: Dynamic content editor for Authentication Pages.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
