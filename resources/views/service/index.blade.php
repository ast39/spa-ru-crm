@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Услуги'))

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Услуги') }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/services')
            </div>

            <table class="table table-bordered mobile_page">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Название') }}</th>
                    <th class="text-end">{{ __('Цена') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($services as $service)
                    <tr>
                        <td data-label="Название" class="text-start"><a class="text-primary" href="{{ route('dict.service.show', $service->service_id) }}">{{ $service->title }}</a></td>
                        <td data-label="Цена" class="text-end mobile-price">{{ number_format($service->price, 0, '.', ' ') }}</td>
                        <td data-label="Действия" class="text-end">
                            <form method="post" action="{{ route('dict.service.destroy', $service->service_id) }}" class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    <a href="{{ route('dict.service.edit', $service->service_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                    @if(Gate::allows('owner'))
                                        <button type="submit" class="mmot-table__action__one" onclick="return confirm('{{ __('Вы уверены, что хотите удалить доп. услугу?') }}')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Услуги отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $services->links() }}
                </div>
                </tbody>
            </table>

            @if(Gate::allows('owner'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.service.create') }}" class="btn btn-primary rounded">{{ __('Добавить услугу') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection

