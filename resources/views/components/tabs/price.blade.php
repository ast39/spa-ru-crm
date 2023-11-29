<div class="nav nav-pills mb-2" id="nav-tab" role="tablist">
    <a href="{{ route('dict.program.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.program.index' ? 'active' : '' }}">{{ __('Программы') }}</a>
    <a href="{{ route('dict.service.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.service.index' ? 'active' : '' }}">{{ __('Услуги') }}</a>
    <a href="{{ route('dict.bar.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.bar.index' ? 'active' : '' }}">{{ __('Бар') }}</a>
</div>
