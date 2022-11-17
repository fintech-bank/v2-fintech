@extends("front.layouts.app")

@section("content")

@endsection

@section("scripts")
    <script type="text/javascript">
        const client = new Persona.Client({
            templateId: 'itmpl_qvuQuXt48aMJYd6o345x7Ldm',
            environmentId: 'env_4dTQPEjvQqhdSBciNzE7YzBi',
            onReady: () => client.open(),
            onComplete: ({ inquiryId, status, fields }) => {
                console.log(inquiryId)
                console.log(status)
                console.log(fields)
            },
            onCancel: ({ inquiryId, sessionToken }) => {},
            onError: (error) => {}
        });
    </script>
@endsection
