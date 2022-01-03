# Otto Project

## Prerequisite

Do a global search-and-replace on the string `__PROJECT__` to replace it
with the top-level namespace for your project.

## Application Services

Create Application Service classes in the `src/Domain/App/` directory. Use the
`__invoke()` method as the main method.

The `__invoke()` method should always-and-only return a Domain Payload; cf.
`src/Domain/Payload.php`.

The `App::run()` method is a wrapper around the `__invoke()` main method to
catch exceptions from the domain and report them as errors.

## Actions and Action Templates

You can create an action and its corresponding template like so:

`php bin/otto-action.php {$VERB} {$PATH} {$DOMAIN}`

- `{$VERB}` is an HTTP verb; e.g. `GET`
- `{$PATH}` is the URL path leading to the action, with dynamic placeholders
  as needed; e.g. `/user/{userId}`
- `{$DOMAIN}` is a domain subclass, e.g. `App\\User\\FetchUser`

Calling the above command will create an Action in the right place (in this
case, `src/Sapi/Http/Action/User/GetUser.php`) with an html template in the
right place (`resources/responder/html/action/User/GetUser.php`).

## Other Templates

All templates are in `resources/responder/{$FORMAT}`, where `{$FORMAT}` is
`html` or `json`.

Layout templates are in the `layout/` subdirectory.

Status templates are in the `status/` subdirectory.

Front templates (for presenting uncaught Throwables) are in the `front/`
subdirectory. Front templaes are named for the Throwable class they display. If
the specific Throwable does not have a template, Otto will try its parent class,
then *its* parent class, and so on, until it reaches the topmost parent class
(either `Exception` or `Error`).

In general, you should not depend on the FrontResponder too much for Throwable
presentation. Instead, your Application Service should return Payload objects
with an `ERROR` status, and your action or status templates should present
those errors appropriately.
