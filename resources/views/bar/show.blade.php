@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', $bar->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ $bar->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Название') }}</th>
                        <td class="text-end">{{ $bar->title }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Объем') }}</th>
                        <td class="text-end">{{ $bar->portion ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Цена') }}</th>
                        <td class="text-end">{{ number_format($bar->price, 0, '.', ' ') }} {{ __('руб.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Остаток') }}</th>
                        <td class="text-end">{{ $bar->stock ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ $bar->note ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Статус') }}</th>
                        <td class="text-end">{{ Helper::itemStatus($bar->status) }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Дата добавления') }}</th>
                        <td class="text-end">{{ date('d.m.Y', $bar->created_at) }}</a></td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="{{ route('dict.bar.destroy', $bar->item_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.bar.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Список') }}</a>
                    @if(Gate::allows('owner'))
                        <a href="{{ route('dict.bar.edit', $bar->item_id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                        <button type="submit" title="Delete" onclick="return confirm('{{ __('Вы уверены, что хотите удалить позицию бара?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                        <a href="{{ route('dict.bar.create') }}" class="btn btn-primary rounded">{{ __('Добавить позицию бара') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
