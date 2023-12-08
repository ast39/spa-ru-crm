@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', __('Программы') . ' : ' . Helper::programType(request()->type ?? 0))

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Программы') }} - {{ Helper::programType(request()->type ?? 0) }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/programs')
            </div>

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Название') }}</th>
                    <th class="text-end">{{ __('Цена') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($programs as $program)
                    <tr>
                        <td class="text-start"><a class="text-primary" href="{{ route('dict.program.show', $program->program_id) }}">{{ $program->title }}</a> ({{ $program->period }} {{ __('мин.') }})</td>
                        <td class="text-end">{{ number_format($program->price, 0, '.', ' ') }}</td>
                        <td class="text-end">
                            <form method="post" action="{{ route('dict.program.destroy', $program->program_id) }}" class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    <a href="{{ route('dict.program.edit', $program->program_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                    @if(Gate::allows('owner'))
                                        <button type="submit" class="mmot-table__action__one" onclick="return confirm('{{ __('Вы уверены, что хотите удалить программу?') }}')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Программы отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $programs->withQueryString()->links() }}
                </div>
                </tbody>
            </table>

            @if(Gate::allows('owner'))
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.program.create') }}" class="btn btn-primary rounded">{{ __('Добавить программу') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection

