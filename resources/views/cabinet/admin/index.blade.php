@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Рандеву - Администраторы'))

@section('content')
    @include('components/tabs/cabinet')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Сводка') }}</div>

        <div class="card-body bg-light">

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">#</th>
                    <th class="text-start">Имя</th>
                </tr>
                </thead>

                <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td class="text-start" style="width: 60px">{{ $loop->iteration }}</td>
                        <td class="text-start"><a class="text-primary" href="{{ route('cabinet.admin', $admin->id) }}">{{ $admin->name }}</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ ('Администраторов нет') }}</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection