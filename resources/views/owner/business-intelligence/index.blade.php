@extends('owner.layouts.app')

@section('title', 'Business Intelligence Dashboard')
@section('page-title', 'Business Intelligence')
@section('page-subtitle', 'Dashboard Analytics & Insights')

@push('styles')
    @include('owner.business-intelligence.partials.styles')
@endpush

@section('content')
<div class="container-fluid">
    @include('owner.business-intelligence.partials.header')
    @include('owner.business-intelligence.partials.kpi-metrics')
    @include('owner.business-intelligence.partials.charts-section')
    @include('owner.business-intelligence.partials.ai-decision-support')
</div>

@include('owner.business-intelligence.partials.scripts')
@endsection
