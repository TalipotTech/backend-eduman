@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.environment.classic.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-code fa-fw" aria-hidden="true"></i> {{ trans('installer_messages.environment.classic.title') }}
@endsection

@section('container')

    <form class="eduman-installer-runner-form" method="post" action="{{ route('edumanEnvironmentDbSave') }}">
        {!! csrf_field() !!}
        <textarea class="textarea" name="envConfig">{{ $envConfig }}</textarea>
        <div class="buttons buttons--right">&nbsp;</div>
        @if( ! isset($environment['errors']))
            <div class="buttons-container">
                {{--<a class="button float-left" href="{{ route('LaravelInstaller::environmentWizard') }}">
                    <i class="fa fa-sliders fa-fw" aria-hidden="true"></i>
                    {!! trans('installer_messages.environment.classic.back') !!}
                </a> --}}
                <button class="button float-right" type="submit">
                    <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                    {!! trans('installer_messages.environment.classic.install') !!}
                    <i class="fa fa-angle-double-right fa-fw" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </form>

@endsection
