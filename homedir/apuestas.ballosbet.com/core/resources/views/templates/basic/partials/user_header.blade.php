<header class="header-primary user-header-primary">
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="header-fluid-custom-parent">
                <a class="logo" href="{{ route('home') }}">
                    <img class="img-fluid logo__is" src="{{ siteLogo() }}" alt="@lang('logo')">
                </a>

                <nav class="primary-menu-container justify-content-end">
                    <ul class="list list--row primary-menu justify-content-end align-items-center right-side-nav gap-3 gap-sm-4">
                        <li class="d-none d-lg-block">
                            <a class="btn btn--signup" href="{{ route('home') }}">
                                @lang('Bet Now')
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

