@php
    use App\Http\Services\Helper;
    use App\Http\Enums\PercentType;
@endphp

@extends('layouts.app')

@section('title', __('Администратор') . ' : ' . $admin->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Администратор') }} : {{ $admin->name }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Имя') }}</th>
                        <td class="text-end">{{ $admin->name }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Процент от программы') }}</th>
                        <td class="text-end">{{ number_format(Helper::adminPercent($admin->roles, PercentType::Program->value), 2, '.', ' ') }}%</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Процент от сервиса') }}</th>
                        <td class="text-end">{{ number_format(Helper::adminPercent($admin->roles, PercentType::Service->value), 2, '.', ' ') }}%</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Процент от бара') }}</th>
                        <td class="text-end">{{ number_format(Helper::adminPercent($admin->roles, PercentType::Bar->value), 2, '.', ' ') }}%</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Логин') }}</th>
                        <td class="text-end">{{ $admin->email }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ $admin->note ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Дата добавления') }}</th>
                        <td class="text-end">{{ date('d.m.Y', $admin->created_at) }}</a></td>
                    </tr>
                </tbody>
            </table>
            <form method="post" action="{{ route('dict.admin.destroy', $admin->id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.admin.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <a href="{{ route('dict.admin.edit', $admin->id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                    <button type="submit" title="Delete" onclick="return confirm('{{ __('"Вы уверены, что хотите убрать сотрудника с должности администратора?') }}')" class="btn btn-danger me-1 rounded">{{ __('Убрать') }}</button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
