@php

@endphp

<form method="get" action="{{ route('dict.bar.index') }}" data-filterline__sandwich>
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
        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('dict.bar.index') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
