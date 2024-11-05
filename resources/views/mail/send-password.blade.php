<x-mail::message>
# Su cuenta ha sido creada

Su nutricionista ha creado su cuenta y hemos generado una contraseña aleatoria para que pueda ingresar en la App.

{{ __(
    key: 'La contraseña es :password',
    replace: [
        'password' => $password
]) }}

Una vez ingrese se le pedirá cambiar su contraseña.

Atte,<br>
{{ config('app.name') }}
</x-mail::message>
