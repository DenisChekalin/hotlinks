@php
    /**
     * @var \App\Models\Link $entity
     * @var string $title
     */
@endphp

@extends('app')

@section('message')
    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        {{ Form::open(['url' => route('link.store'), 'method' => 'POST']) }}

        <div class="mb-4 row">
            {{ Form::label('link', 'Link', ['class' => 'col-sm-2 col-form-label required']) }}

            <div class="col-sm-10">
                {{ Form::url('link', '', [
                    'class' => 'form-control ' . $errors->first('link', 'is-invalid'),
                    'placeholder' => 'http://example.com',
                    'required' => 'required',
                ]) }}
            </div>
        </div>

        <div class="mb-4 row">
            {{ Form::label('limit', 'Usage limit', ['class' => 'col-sm-2 col-form-label required']) }}

            <div class="col-sm-10">
                {{ Form::number('usageLimit', '', [
                    'class' => 'form-control '  . $errors->first('usageLimit', 'is-invalid'),
                    'placeholder' => '0',
                    'min' => \App\Models\Link::MIN_USAGE,
                    'max' => \App\Models\Link::MAX_USAGE,
                ]) }}
            </div>
        </div>

        <div class="mb-4 row">
            {{ Form::label('ttl', 'TTL (seconds)', ['class' => 'col-sm-2 col-form-label required']) }}

            <div class="col-sm-10">
                {{ Form::number('ttl', '', [
                    'class' => 'form-control '  . $errors->first('ttl', 'is-invalid'),
                    'min' => \App\Models\Link::MIN_TTL,
                    'max' => \App\Models\Link::MAX_TTL,
                    'required' => 'required',
                ]) }}
            </div>
        </div>

        <div class="d-grid mb-4 d-md-flex justify-content-md-end">
            {{ Form::submit('Add new link', [
                'class' => 'btn btn-primary',
]           ) }}
        </div>

        {{ Form::close() }}
    </div>
@endsection

