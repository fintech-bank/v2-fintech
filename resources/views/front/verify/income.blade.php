@extends("front.layouts.app")

@section("content")

@endsection

@section("scripts")
    <script type="text/javascript">
        const client = new Persona.Client({
            templateId: 'itmpl_1KZgojcfDHDbq185tYBTkdUQ',
            environment: 'sandbox',
            referenceId: "{{ isset($customer) ? $customer->persona_reference_id : '' }}",
            onReady: () => client.open(),
            onComplete: ({ inquiryId, status, fields }) => {
                console.log(inquiryId)
                console.log(status)
                console.log(fields)
                window.location.href='/verify/verify-success?sector=income&customer_id={{ $customer->id }}'
            },
            onCancel: ({ inquiryId, sessionToken }) => {},
            onError: (error) => {},
            fields: {
                nameFirst: "{{ $customer->info->firstname }}",
                nameLast: "{{ $customer->info->lastname }}",
                birthdate: "{{ $customer->info->datebirth->format('Y-m-d') }}",
                addressStreet1: "{{ $customer->info->address }}",
                addressCity: "{{ $customer->info->city }}",
                addressPostalCode: "{{ $customer->info->postal }}",
                addressCountryCode: "{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::limit($customer->info->address, 2, '')) }}",
                phoneNumber: "{{ $customer->info->mobile }}",
                emailAddress: "{{ $customer->user->email }}",
            }
        });
    </script>
@endsection
