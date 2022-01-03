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

You will then need to edit the new Action class to set the typehints on the
parameters (if any), and touch up the Domain call to add or modify any needed
arguments.

If you decide that the basic action class template is not suitable for your
purposes, edit `resources/action.tpl` as you see fit.

## Other Templates

All templates are in `resources/responder/{$FORMAT}`, where `{$FORMAT}` is
`html` or `json`.

Layout templates are in the `{$FORMAT}/layout/` subdirectory. For HTML, these provide
the common site wrapper display. For JSON, this provides a final chance to
manipulate the template variables that will be JSON-encoded for the Response.

Status templates are in the `{$FORMAT}/status/` subdirectory. These are used
when a domain payload is present but an action-specific template.
The payload status will determine which status template is used.

Front templates (for presenting uncaught Throwables) are in the
`{$FORMAT}/front/` subdirectory. Front templates are named for the Throwable
class they will display. If the specific Throwable does not have a template,
Otto will try its parent class, then *its* parent class, and so on, until it
reaches the topmost parent class(either `Exception` or `Error`).

In general, you should not depend on the front templates too much for Throwable
presentation. Instead, your Application Service should return Payload objects
with an `ERROR` status, and your action or status templates should present
those errors appropriately.

## Summary

Overall, the vast majority of you work should *not* be in the actinon
