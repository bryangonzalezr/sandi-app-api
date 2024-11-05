<x-mail::message>
# Su cuenta ha sido activada

{{ __(
    key: 'Estimado :patient , has sido asignado al nutricionista :nutritionist , por lo que ahora tu cuenta posee el rol
    de paciente',
    replace: [
        'patient' => $patient_user->name . ' ' . $patient_user->last_name,
        'nutritionist' => $nutritionist->name . ' ' . $nutritionist->last_name
]) }}

Es ideal que vuelva a iniciar sesion.

Atte,<br>
{{ config('app.name') }}
</x-mail::message>
