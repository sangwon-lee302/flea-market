# Coding Conventions

## Environment

- This project uses [Laravel Sail](https://laravel.com/docs/sail) for local development. Run Artisan, Composer, npm, and test commands through Sail (e.g. `./vendor/bin/sail artisan ...`, `./vendor/bin/sail composer ...`, `./vendor/bin/sail npm ...`, `./vendor/bin/sail test`) instead of invoking `php`, `composer`, or `npm` directly on the host, unless the user says otherwise.
- Start/stop the stack with `./vendor/bin/sail up -d` / `./vendor/bin/sail down`.
- Custom Composer scripts, use via Sail when relevant:
    - `./vendor/bin/sail composer stan` — runs PHPStan/Larastan (`phpstan.neon` + `phpstan-tests.neon`). Run after non-trivial PHP changes to catch type/static-analysis errors.
    - `./vendor/bin/sail composer ide` — regenerates IDE helper files (`ide-helper:generate`, `:models`, `:meta`). Run after changing Eloquent models or facades so autocompletion metadata stays in sync.

## Language

- Write code comments (PHPDoc/inline comments, Blade comments, JS comments) in Japanese.
- Write git commit messages in Japanese. Keep any Conventional Commits prefix (`feat:`, `fix:`, `chore:`, etc.) in English and write the subject and body in Japanese.
