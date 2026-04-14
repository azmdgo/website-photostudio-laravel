@extends('admin.layouts.app')

@section('title', 'Business Intelligence Dashboard')
@section('page-title', 'Business Intelligence')
@section('page-subtitle', 'Dashboard Analytics & Insights')

@push('styles')
    @include('admin.business-intelligence.partials.styles')
@endpush

@section('content')
<div class="container-fluid">
    @include('admin.business-intelligence.partials.header')
    @include('admin.business-intelligence.partials.kpi-metrics')
    @include('admin.business-intelligence.partials.charts-section')
    @include('admin.business-intelligence.partials.ai-decision-support')
</div>

@include('admin.business-intelligence.partials.scripts')
@endsection
