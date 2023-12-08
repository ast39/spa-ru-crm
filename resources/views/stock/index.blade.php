@php
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Склад'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Склад') }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/stock')
            </div>

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Дата') }}</th>
                    <th class="text-start">{{ __('Название') }}</th>
                    <th class="text-center">{{ __('Приход') }}</th>
                    <th class="text-center">{{ __('Расход') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($stock as $item)
                    <tr>
                        <td class="text-start">{{ date('d-m-Y H:i', $item->created_at) }}</td>
                        <td class="text-start"><a class="text-primary" href="{{ route('dict.bar.show', $item->item_id) }}">{{ $item->title }}</a></td>
                        <td class="text-center">{{ 0 }}</td>
                        <td class="text-center">{{ 0 }}</td>
                        <td class="text-end">
                            <form method="post" action="{{ route('stock.destroy', $item->item_id) }}" class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    @if(Gate::allows('admin'))
                                        <button type="submit" class="mmot-table__action__one" onclick="return confirm('{{ __('Вы уверены, что хотите удалить запись?') }}')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Записи отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $stock->withQueryString()->links() }}
                </div>
                </tbody>
            </table>

            @if(Gate::allows('admin') || Gate::allows('owner'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('stock.create') }}" class="btn btn-primary rounded">{{ __('Добавить движение по складу') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection
