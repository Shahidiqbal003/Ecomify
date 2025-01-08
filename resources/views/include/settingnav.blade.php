<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}"
            href="{{ route('settings.index', ['shop' => request()->route('shop')]) }}">
            General Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('settings.homePage') ? 'active' : '' }}"
            href="{{ route('settings.homePage', ['shop' => request()->route('shop')]) }}">
            Home Page Settings
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('settings.checkout_form') ? 'active' : '' }}"
            href="{{ route('settings.checkout_form', ['shop' => request()->route('shop')]) }}">
            Checkout From Settings
        </a>
    </li>
</ul>
