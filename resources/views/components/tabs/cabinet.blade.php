<div class="nav nav-pills mb-2" id="nav-tab" role="tablist">
    <a href="{{ route('cabinet.index') }}" class="nav-link {{ request()->route()->getName() == 'cabinet.owner' ? 'active' : '' }}">{{ __('Отчеты') }}</a>
    <a href="{{ route('cabinet.admins.index') }}" class="nav-link {{ request()->route()->getName() == 'cabinet.admins.index' ? 'active' : '' }}">{{ __('Администраторы') }}</a>
    <a href="{{ route('cabinet.masters.index') }}" class="nav-link {{ request()->route()->getName() == 'cabinet.masters.index' ? 'active' : '' }}">{{ __('Мастера') }}</a>
</div>
