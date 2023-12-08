@php
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Бар'))

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Бар') }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components.filters.bar')
            </div>

            <table class="table table-bordered mobile_page">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Название') }}</th>
                    <th class="text-end">{{ __('Объем') }}</th>
                    <th class="text-end">{{ __('Цена') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($bar as $item)
                    <tr>
                        <td class="text-start"><a class="text-primary" href="{{ route('dict.bar.show', $item->item_id) }}">{{ $item->title }}</a></td>
                        <td class="text-end mobile-price">{{ $item->portion }}</td>
                        <td class="text-end mobile-price">{{ number_format($item->price, 0, '.', ' ') }}</td>
                        <td class="text-end">
                            <form method="post" action="{{ route('dict.bar.destroy', $item->item_id) }}"
                                  class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    <a href="{{ route('dict.bar.edit', $item->item_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                    @if(Gate::allows('owner'))
                                        <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('{{ __('Вы уверены, что хотите удалить позицию бара?') }}')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Позиции бара отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $bar->links() }}
                </div>
                </tbody>
            </table>

            @if(Gate::allows('owner'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.bar.create') }}"
                       class="btn btn-primary rounded">{{ __('Добавить позицию бара') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection
