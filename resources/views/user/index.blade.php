@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Сотрудники'))

@section('content')
    @include('components/tabs/users')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Сотрудники') }}</div>

        <div class="card-body bg-light">
            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components.filters.user')
            </div>

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Имя') }}</th>
                    <th class="text-start">{{ __('Роль') }}</th>
                    <th class="text-end">{{ __('UD') }}</th>
                </tr>
                </thead>

                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-start">
                            <a class="text-primary" href="{{ route('dict.user.show', $user->id) }}">{{ $user->name }}</a>
                        </td>
                        <td class="text-start">{{ Helper::detectRole($user->roles) }}</td>
                        <td class="text-end">
                            <form method="post" action="{{ route('dict.user.destroy', $user->id) }}"
                                  class="admin-table__nomargin">
                                @csrf
                                @method('DELETE')

                                <div class="mmot-table__action">
                                    <a title="Изменить" href="{{ route('dict.user.edit', $user->id) }}"
                                       class="mmot-table__action__one">
                                        <svg class="mmot-table_view mmot-table__ico">
                                            <use xlink:href="#site-edit"></use>
                                        </svg>
                                    </a>
                                    <button title="{{ __('Удалить') }}" type="submit" class="mmot-table__action__one"
                                            onclick="return confirm('{{ __('Вы уверены, что хотите удалить сотрудника?') }}')">
                                        <svg class="mmot-table__delete mmot-table__ico">
                                            <use xlink:href="#site-delete"></use>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Сотрудники отсутствуют') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $users->links() }}
                </div>
                </tbody>
            </table>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('dict.user.create') }}" class="btn btn-primary rounded">{{ __('Добавить сотрудника') }}</a>
            </div>
        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection

