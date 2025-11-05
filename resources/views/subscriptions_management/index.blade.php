@extends('layouts.app')

@section('content')
<div class="container-fluid p-3">
        <div class="row border-bottom mb-3">
            <h4 class="fw-bold">GESTIÓN DE SUSCRIPCIONES</h4>
        </div>
        @include('messages.alert')
        <div class="btn mb-3">
            <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg fw-bold"> Nueva Suscripción</i></a>
        </div>

        
        @if (!is_null($tenants))
            <div class="table-responsive">
            @include('subscriptions_management.tables.subscriptions')
            </div>
        
        @endif
        
        
    </div>
@endsection
