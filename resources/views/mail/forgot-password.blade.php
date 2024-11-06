<x-mail::message>
# Recupere su contraseña

{{ __(
    key: 'Estimado :username , le hemos proporcionado una contraseña nueva para que pueda ingresar a la app nuevamente.
    La contraseña es :password ',
    replace: [
        'username' => $user->name . ' ' . $user->last_name,
        'password' => $password
]) }}

Una vez dentro se le pedirá modificar esta contraseña.

Atte,<br>
{{ config('app.name') }}
</x-mail::message>
