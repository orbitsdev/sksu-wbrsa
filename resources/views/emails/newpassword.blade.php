


<x-mail::message>
# Forgot password request


Click below to set new password

<x-mail::button :url="'http://127.0.0.1:8000/resetnewpassword'">
SET NEW PASSWORD LINK
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
