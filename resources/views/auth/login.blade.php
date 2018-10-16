@extends('layouts.app')

@section('content')
<div class="container">
    <example-component 
        title="{{ __('Login') }}"
        action="{{ route('login') }}"
        ></example-component>
</div>
@endsection
