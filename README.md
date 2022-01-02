# Otto Project

## Application Services

Create Application services in the `src/Domain/App/` directory. Use the
`__invoke()` method as the main method.

The `__invoke()` method should always-and-only return a Domain Payload; cf.
`src/Domain/Payload.php`.

The `App::run()` method is a wrapper around the `__invoke()` main method to
catch exceptions from the domain and report them as errors.

## Actions

Use the AutoRoute conventions for class naming and `__invoke()` signatures. Put
action classes in the `src/Sapi/Http/Action/` directory. Action classes must
implement the `Otto\Sapi\Http\Action` interface.

In the Action, run the Application Service using the `run()` method (not
`__invoke()`).

## Responder Templates

Responder templates for HTML are in `resources/responder/{$format}/` where
`{$format}` is `html` or `json`.

Action templates are in the `action/` subdirectory.

Status templates are in the `status/` subdirectory.

Layout templates are in the `layout/` subdirectory.

Front templates are in the `front/` subdirectory.

### ActionResponder Templates

Place the responder template for an action in a path that mirrors the action
class path.

For example:

```
src/Sapi/Http/Action/Foo/Bar/GetFooBar.php
                     ^^^^^^^^^^^^^^^^^^^^^

resources/responder/{$format}/action/Foo/Bar/GetFooBar.php
                                     ^^^^^^^^^^^^^^^^^^^^^
```

To specify an action template for a specific payload status, add a `-{$status}`
suffix.

For example:

```
resources/responder/{$format}/action/Foo/Bar/GetFooBar-NotFound.php
```

If no `action` template is available, the ActionResponder will fall back to
a `status` template for the payload status.

### FrontResponder Templates

The `Front` controller catches unhandled Throwables, and presents them using
a template named for the Throwable class. If the specific Throwable does not
have a template, it will try the parent class, then its parent class, and so
on, until it reaches the topmost parent class (either `Exception` or `Error`).

In general, you should not depend on the FrontResponder too much for Throwable
presentation. Instead, your Application Service should return Payload objects
with an `ERROR` status, and your action or status templates should present
those errors appropriately.
