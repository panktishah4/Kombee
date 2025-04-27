<x-mail::message>
# Welcome to {{ config('app.name') }}, {{ $user->name }}!

Thanks for signing up. We're excited to have you join our community.

To get started, please verify your email address by clicking the button below:

<x-mail::button :url="$verificationUrl">
Verify Email
</x-mail::button>

If you didn’t create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
