@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <datatable-component endpoint="{{ route('users.index') }}"></datatable-component>
            </div>
        </div>
    </div>
@endsection
