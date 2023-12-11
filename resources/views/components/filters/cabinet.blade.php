@php

@endphp

<form method="get" action="{{ route('cabinet.owner') }}" data-filterline__sandwich>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">{{ __('Фильтр') }}</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="user" id="user" class="form-select form-control">
                    @foreach($users as $u)
                        <option title="{{ $u->name }}" {{ (request()->user ?? null) == $u->id ? 'selected' : '' }} value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                <input type="date" class="form-control" id="from" name="from" placeholder="{{ __('Дата начала') }}" onfocus="(this.showPicker())" data-input_clear value="{{ request()->from }}">
            </div>

            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                <input type="date" class="form-control" id="to" name="to" placeholder="{{ __('Дата завершения') }}" onfocus="(this.showPicker())" data-input_clear value="{{ request()->to }}">
            </div>

        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('cabinet.owner') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
