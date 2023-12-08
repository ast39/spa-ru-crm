@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Программа') . ' : '. $program->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ $program->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Название') }}</th>
                        <td class="text-end">{{ $program->title }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Для кого') }}</th>
                        <td class="text-end">{{ Helper::programType($program->type) }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Длительность') }}</th>
                        <td class="text-end">{{ $program->period }} {{ __('мин.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Стоимость') }}</th>
                        <td class="text-end">{{ number_format($program->price, 0, '.', ' ') }} {{ __('руб.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ $program->note ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Статус') }}</th>
                        <td class="text-end">{{ Helper::programStatus($program->status) }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Дата добавления') }}</th>
                        <td class="text-end">{{ date('d.m.Y', $program->created_at) }}</a></td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="{{ route('dict.program.destroy', $program->program_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.program.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Список') }}</a>
                    @if(Gate::allows('owner'))
                        <a href="{{ route('dict.program.edit', $program->program_id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                        <button type="submit" onclick="return confirm('{{ __('Вы уверены, что хотите удалить программу?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                        <a href="{{ route('dict.program.create') }}" class="btn btn-primary rounded">{{ __('Добавить программу') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

