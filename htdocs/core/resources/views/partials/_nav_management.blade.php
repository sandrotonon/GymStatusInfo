<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Verwaltung <i class="fa fa-caret-down"></i></a>
        <ul class="dropdown-menu">

        <!-- Only user with role "admins" should be able to edit master data -->
        @if (Entrust::hasRole('admins'))
            <li><a href="{{ route('Locations.index') }}">Sporthallen verwalten</a></li>
            <li><a href="{{ route('Teams.index') }}">Mannschaften verwalten</a></li>
            <li role="separator" class="divider"></li>
        @endif

        <li><a href="{{ route('profile.{slug}.edit', ['slug' => Auth::user()->slug]) }}">Passwort ändern</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('logout') }}">Abmelden</a></li>
    </ul>
</li>