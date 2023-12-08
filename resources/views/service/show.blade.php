@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Услуга') . ' : ' .  $service->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ $service->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Название') }}</th>
                        <td class="text-end">{{ $service->title }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Цена') }}</th>
                        <td class="text-end">{{ number_format($service->price, 0, '.', ' ') }} {{ __('руб.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ $service->note ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Статус') }}</th>
                        <td class="text-end">{{ Helper::programStatus($service->status) }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Дата добавления') }}</th>
                        <td class="text-end">{{ date('d.m.Y', $service->created_at) }}</a></td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="{{ route('dict.service.destroy', $service->service_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.service.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Список') }}</a>
                    @if(Gate::allows('owner'))
                        <a href="{{ route('dict.service.edit', $service->service_id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                        <button type="submit" title="Delete" onclick="return confirm('{{ __('Вы уверены, что хотите удалить доп. услугу?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                        <a href="{{ route('dict.service.create') }}" class="btn btn-primary rounded">{{ __('Добавить услугу') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
