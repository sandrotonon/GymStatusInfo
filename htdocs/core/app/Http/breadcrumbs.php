<?php

/*
|--------------------------------------------------------------------------
| Index breadcrumb
|--------------------------------------------------------------------------
*/
// Startseite
Breadcrumbs::register('index', function($breadcrumbs) {
    $breadcrumbs->push('Startseite', route('index'));
});


/*
|--------------------------------------------------------------------------
| Location breadcrumbs
|--------------------------------------------------------------------------
*/
// Startseite > Sporthallen
Breadcrumbs::register('Locations.index', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Sporthallen', route('Locations.index'));
});

// Startseite > Sporthallen > Erstellen
Breadcrumbs::register('Locations.create', function($breadcrumbs) {
    $breadcrumbs->parent('Locations.index');
    $breadcrumbs->push('Erstellen', route('Locations.create'));
});

// Startseite > Sporthallen > "Sporthalle X"
Breadcrumbs::register('Locations.{slug}.edit', function($breadcrumbs, $location) {
    $breadcrumbs->parent('Locations.index');
    $breadcrumbs->push($location->name, route('Locations.{slug}.edit', $location->slug));
});


/*
|--------------------------------------------------------------------------
| Teams routes
|--------------------------------------------------------------------------
*/
// Startseite > Mannschaften
Breadcrumbs::register('Teams.index', function($breadcrumbs) {
    $breadcrumbs->parent('index');
    $breadcrumbs->push('Mannschaften', route('Teams.index'));
});

// Startseite > Mannschaften > Erstellen
Breadcrumbs::register('Teams.create', function($breadcrumbs) {
    $breadcrumbs->parent('Teams.index');
    $breadcrumbs->push('Neu', route('Teams.create'));
});

// Startseite > Mannschaften > "Mannschaft X"
Breadcrumbs::register('Teams.{slug}.edit', function($breadcrumbs, $user) {
    $breadcrumbs->parent('Teams.index');
    $breadcrumbs->push($user->team, route('Teams.{slug}.edit', $user->team));
});
