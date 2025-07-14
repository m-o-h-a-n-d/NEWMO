<x-mail::message>
# Introduction

Thanks for subscribe

<x-mail::button :url="route('frontend.home')">
Go to website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
