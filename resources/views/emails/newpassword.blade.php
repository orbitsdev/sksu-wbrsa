




<x-mail::message>
# NEW PASSWORD REQUEST

<x-mail::panel>
<p> {{ $user->email}}</p>
</x-mail::panel>

<x-mail::button :url="'http://127.0.0.1:8000/resetnewpassword'">
GO TO TO PAGE 
</x-mail::button>

<hr>
If you having trouble redirecting to the set new passwrod page <br> you can copy and pasre the  url  below and and paste it to your browser 
<br>
<br>
<a href="{{$set_new_password_url  }}" style="display:block"> {{ $set_new_password_url}} </a> <br>

<hr>

From,<br>
{{ config('app.name') }}
</x-mail::message>
