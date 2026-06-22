@extends('admin.layouts.admin')

@section('title', trans('skin-api::admin.capes'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('skin-api::admin.api.title') }}</h5>
        </div>
        <div class="card-body">
            <p>{{ trans('skin-api::admin.api.info') }}</p>
            <a href="https://market.azuriom.com/resources/18" class="btn btn-primary" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-journals"></i> {{ trans('admin.nav.documentation') }}
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="POST" action="{{ route('skin-api.admin.capes.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="enableSwitch" name="enable" @checked($enable)>
                    <label class="form-check-label" for="enableSwitch">{{ trans('skin-api::admin.enable_capes') }}</label>
                </div>

                @include('skin-api::admin._fields')

                <hr>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" class="form-check-input" id="defaultCapeSwitch" name="default_enable" @checked($defaultCapeEnabled)>
                    <label class="form-check-label" for="defaultCapeSwitch">{{ trans('skin-api::admin.enable_default_cape') }}</label>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="defaultCapeInput">{{ trans('skin-api::admin.fields.default_cape') }}</label>
                    <input type="file" class="form-control @error('default_cape') is-invalid @enderror" id="defaultCapeInput" name="default_cape" accept="image/png">
                    <div class="form-text">{{ trans('skin-api::admin.default_cape_requirements') }}</div>
                    @error('default_cape')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    @if($defaultCape)
                        <img src="{{ $defaultCape }}" alt="{{ trans('skin-api::admin.fields.default_cape') }}" class="mt-2 img-fluid" style="max-width: 325px; image-rendering: pixelated;">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
