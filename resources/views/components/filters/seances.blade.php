@php

@endphp

<form method="get" action="{{ route('shift.index') }}" data-filterline__sandwich>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">{{ __('Фильтр') }}</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="admin" id="admin" class="form-select form-control">
                    <option title="Все" {{ (request()->admin ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Администратор') }}</option>
                    @foreach($admins as $admin)
                        <option title="{{ $admin->name }}" {{ (request()->admin ?? 0) == $admin->admin_id ? 'selected' : '' }} value="{{ $admin->admin_id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="admin" id="admin" class="form-select form-control">
                    <option title="Все" {{ (request()->master ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Мастер') }}</option>
                    @foreach($masters as $master)
                        <option title="{{ $master->name }}" {{ (request()->master ?? 0) == $master->master_id ? 'selected' : '' }} value="{{ $master->master_id }}">{{ $master->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="admin" id="admin" class="form-select form-control">
                    <option title="Все" {{ (request()->program ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Программа') }}</option>
                    @foreach($programs as $program)
                        <option title="{{ $program->title }}" {{ (request()->program ?? 0) == $program->program_id ? 'selected' : '' }} value="{{ $program->program_id }}">{{ $program->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                <input type="datetime-local" class="form-control" id="from" name="from" placeholder="{{ __('Время начала') }}" onfocus="(this.showPicker())" data-input_clear value="{{ request()->from }}">
            </div>

            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                <input type="datetime-local" class="form-control" id="to" name="to" placeholder="{{ __('Время завершения') }}" onfocus="(this.showPicker())" data-input_clear value="{{ request()->to }}">
            </div>

            <div class="mmot-filterline">
                <div class="mmot-filterline__one" data-input_clear_content>
                    <input type="text" name="guest" id="guest" class="form-control" value="{{ request('guest') }}" placeholder="{{ __('Гость') }}" data-input_clear>
                </div>
            </div>

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="status" id="status" class="form-select form-control">
                    <option title="Все" {{ (request()->status ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                    <option title="Состоялся" {{ (request()->status ?? 0) == 1 ? 'selected' : '' }} value="1">{{ __('Состоялся') }}</option>
                    <option title="Отмена" {{ (request()->status ?? 0) == 2 ? 'selected' : '' }} value="2">{{ __('Отмена') }}</option>
                    <option title="Отказ" {{ (request()->status ?? 0) == 3 ? 'selected' : '' }} value="3">{{ __('Отказ') }}</option>
                </select>
            </div>
        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('shift.index') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
