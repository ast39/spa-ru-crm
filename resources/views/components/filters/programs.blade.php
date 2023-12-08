@php

@endphp

<div data-filterline__sandwich>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">{{ __('Фильтр') }}</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">
            <div class="mmot-filterline__one nmw" data-input_clear_content>
                <div class="nav nav-pills">
                    <a href="{{ route('dict.program.index', ['type' => 0]) }}" class="nav-link {{ (request()->type ?? 0) == 0 ? 'active' : '' }}">{{ __('Для всех') }}</a>
                </div>
            </div>

            <div class="mmot-filterline__one nmw" data-input_clear_content>
                <div class="nav nav-pills">
                    <a href="{{ route('dict.program.index', ['type' => 1]) }}" class="nav-link {{ (request()->type ?? 0) == 1 ? 'active' : '' }}">{{ __('Для мужчин') }}</a>
                </div>
            </div>

            <div class="mmot-filterline__one nmw" data-input_clear_content>
                <div class="nav nav-pills">
                    <a href="{{ route('dict.program.index', ['type' => 2]) }}" class="nav-link {{ (request()->type ?? 0) == 2 ? 'active' : '' }}">{{ __('Для женщин') }}</a>
                </div>
            </div>

            <div class="mmot-filterline__one nmw" data-input_clear_content>
                <div class="nav nav-pills">
                    <a href="{{ route('dict.program.index', ['type' => 3]) }}" class="nav-link {{ (request()->type ?? 0) == 3 ? 'active' : '' }}">{{ __('Для пар') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
