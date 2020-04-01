@extends('layouts.page')
@section('title', 'Dashboard')
@push('css')

@endpush
@push('js')

@endpush
@section('body_class','sidebar-open')
@section('content')
<div class="container-fluid p-4">

    <div class="row row-no-padding">


        <div class="col-6 col-sm-4 col-md-2 p-2">
        <a href="{{ route('users.index') }}">
                <div class="topwidget" style="background:#dc3545;">

                    @include("icons.users")

                    <p class="text-center m-0 mt-3">Users</p>
                </div>
            </a>

        </div>

        <div class="col-6 col-sm-4 col-md-2 p-2">
            <a href="{{ route('roles.index') }}">
                <div class="topwidget" style="background:#28a745;">
                    @include("icons.roles")
                    <p class="text-center m-0 mt-3">Roles</p>
                </div>
            </a>
        </div>

        <div class="col-6 col-sm-4 col-md-2 p-2">
        <a href="{{ route('settings') }}">
                <div class="topwidget" style="background:#fd7e14;">
                    @include("icons.settings")
                    <p class="text-center m-0 mt-3">Settings</p>
                </div>
            </a>

        </div>

        <div class="col-6 col-sm-4 col-md-2 p-2">
            <a href="{{ route('preferences.index') }}">
                <div class="topwidget" style="background:#17a2b8;">

                    @include("icons.settings")

                    <p class="text-center m-0 mt-3">Preferences</p>
                </div>
            </a>
        </div>


        <div class="col-6 col-sm-4 col-md-2 p-2">
            <a href="{{ route('preference_categories.index') }}">
                <div class="topwidget" style="background:#e83e8c;">
                    @include("icons.settings")

                    <p class="text-center m-0 mt-3">Preference Categories</p>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-4 col-md-2 p-2">
            <a href="{{ route('dashboard') }}">
                <div class="topwidget" style="background:#6f42c1;">
                    @include("icons.settings")

                    <p class="text-center m-0 mt-3">Dashboard</p>
                </div>
            </a>
        </div>







    </div>


</div>

@stop