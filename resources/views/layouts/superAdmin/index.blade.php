@extends('layouts.app')
@section('content')
    <div class="flex flex-col overflow-hidden">
        <div class="flex-1 transition-all duration-300 md:ml-80 py-6" id="mainContentSuperAdmin">

            @include('components.sidebar.sidebar')

            @include('pages.superAdmin.layouts.main')
        </div>
    </div>
@endsection
