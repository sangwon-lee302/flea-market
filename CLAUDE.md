# Coding Conventions

## Environment

- This project uses [Laravel Sail](https://laravel.com/docs/sail) for local development. Run Artisan, Composer, npm, and test commands through Sail (e.g. `./vendor/bin/sail artisan ...`, `./vendor/bin/sail composer ...`, `./vendor/bin/sail npm ...`, `./vendor/bin/sail test`) instead of invoking `php`, `composer`, or `npm` directly on the host, unless the user says otherwise.
- Start/stop the stack with `./vendor/bin/sail up -d` / `./vendor/bin/sail down`.
- Custom Composer scripts, use via Sail when relevant:
    - `./vendor/bin/sail composer stan` — runs PHPStan/Larastan (`phpstan.neon` + `phpstan-tests.neon`). Run after non-trivial PHP changes to catch type/static-analysis errors.
    - `./vendor/bin/sail composer ide` — regenerates IDE helper files (`ide-helper:generate`, `:models`, `:meta`). Run after changing Eloquent models or facades so autocompletion metadata stays in sync.

## Language

- **Commit messages**: Always write in English.
- **Code comments**: Always write in English, regardless of the language used in conversation with the user.

These rules apply even when the user writes instructions in Japanese. Conversation replies to the user may still be in Japanese.
