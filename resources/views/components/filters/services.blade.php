@php

@endphp

<form method="get" action="{{ route('dict.service.index') }}" data-filterline__sandwich>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">{{ __('Фильтр') }}</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">
            <div class="mmot-filterline">
                <div class="mmot-filterline__one" data-input_clear_content>
                    <input type="text" name="title" id="title" class="form-control" value="{{ request('title') }}" placeholder="{{ __('Название') }}" data-input_clear>
                </div>
            </div>

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="status" id="status" class="form-select form-control">
                    <option title="Все" {{ (request()->status ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                    <option title="Работает" {{ (request()->status ?? 0) == 1 ? 'selected' : '' }} value="1">{{ __('Доступные') }}</option>
                    <option title="Уволен" {{ (request()->status ?? 0) == 2 ? 'selected' : '' }} value="2">{{ __('Закрытые') }}</option>
                </select>
            </div>
        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('dict.service.index') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
