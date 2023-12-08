@php
    use Illuminate\Support\Facades\Gate;
    use App\Http\Services\Helper;
    use App\Http\Enums\PercentType;
@endphp

@extends('layouts.app')

@section('title', __('Мастера'))

@section('content')
    @include('components/tabs/users')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Мастера') }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/masters')
            </div>

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Имя') }}</th>
                    <th class="text-center">{{ __('С программ') }}</th>
                    <th class="text-center">{{ __('С услуг') }}</th>
                    <th class="text-center">{{ __('С бара') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($masters as $master)
                    <tr>
                        <td class="text-start"><a class="text-primary" href="{{ route('dict.master.show', $master->id) }}">{{ $master->name }}</a></td>
                        <td class="text-center">{{ Helper::masterPercent($master->roles, PercentType::Program->value) }}%</td>
                        <td class="text-center">{{ Helper::masterPercent($master->roles, PercentType::Service->value) }}%</td>
                        <td class="text-center">{{ Helper::masterPercent($master->roles, PercentType::Bar->value) }}%</td>
                        <td class="text-end" style="min-width: 160px">
                            <form method="post" action="{{ route('dict.master.destroy', $master->id) }}" class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    <a title="Изменить" href="{{ route('dict.master.edit', $master->id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                    @if(Gate::allows('owner'))
                                        <button type="submit" class="mmot-table__action__one" onclick="return confirm('{{ __('Вы уверены, что хотите убрать сотрудника с должности мастера?') }}')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                    @endif
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Мастера отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $masters->links() }}
                </div>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
