@php
    use App\Http\Services\Helper;
@endphp

<form method="get" action="{{ route('stock.index') }}" data-filterline__sandwich>
    <div class="mmot-filterline__sandwich dselect-wrapper" data-filterline_sandwich_parent="filter_planing">
        <div class="mmot-filterline__sandwich__head form-select">Фильтр</div>
    </div>

    <div class="mmot-filterline-justify mmot-filterline__sandwich__list hide" data-filterline_sandwich_child="filter_planing">
        <div class="mmot-filterline">
            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="bar" id="bar" class="form-select form-control">
                    <option title="Все" {{ (request()->bar ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                    @foreach($bar as $item)
                        <option {{ (request()->bar ?? 0) == $item->item_id ? 'selected' : '' }} value="{{ $item->item_id }}">{{ $item->title }}: {{ $item->portion }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mmot-filterline__one" data-input_clear_content>
                <select name="type" id="type" class="form-select form-control">
                    <option {{ (request()->type ?? 0) == 0 ? 'selected' : '' }} value="0">{{ __('Все') }}</option>
                    <option {{ (request()->type ?? 0) == 1 ? 'selected' : '' }} value="1">{{ __('Приход') }}</option>
                    <option {{ (request()->type ?? 0) == 2 ? 'selected' : '' }} value="2">{{ __('Расход') }}</option>
                </select>
            </div>
        </div>

        <div class="mmot-filterline">
            <div class="mmot-filterline__one">
                <a href="{{ route('stock.index') }}" type="button" class="btn btn-secondary w block">{{ __('Сбросить') }}</a>
            </div>

            <div class="mmot-filterline__one">
                <button type="submit" class="btn btn-primary block">{{ __('Показать') }}</button>
            </div>
        </div>
    </div>
</form>
