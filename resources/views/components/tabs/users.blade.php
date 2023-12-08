<div class="nav nav-pills mb-2" id="nav-tab" role="tablist">
    @if(Gate::allows('owner'))
        <a href="{{ route('dict.user.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.user.index' ? 'active' : '' }}">{{ __('Сотрудники') }}</a>
        <a href="{{ route('dict.admin.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.admin.index' ? 'active' : '' }}">{{ __('Администраторы') }}</a>
    @endif

    @if(Gate::allows('owner') || Gate::allows('admin'))
        <a href="{{ route('dict.master.index') }}" class="nav-link {{ request()->route()->getName() == 'dict.master.index' ? 'active' : '' }}">{{ __('Мастера') }}</a>
    @endif
</div>
