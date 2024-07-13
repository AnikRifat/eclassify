{{--@php--}}
{{--    $lang = Session::get('language');--}}
{{--@endphp--}}
@if (empty($lang) || !$lang->rtl)
    {{--NON RTL CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/otherpages.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"/>
@else
    {{--RTL CSS--}}
    <link rel="stylesheet" href="{{ asset('assets/css/main/rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/otherpages_rtl.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"/>
@endif
{{--Bootstrap Switch --}}
<link rel="stylesheet" href="{{asset("assets/css/bootstrap-switch-button.min.css")}}">

{{--Toastify--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/toastify.css') }}">

{{--Bootstrap Table--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/bootstrap-table/bootstrap-table.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/extensions/bootstrap-table/fixed-columns/bootstrap-table-fixed-columns.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset("assets/extensions/bootstrap-table/bootstrap-table-reorder-rows.css")}}">


{{--Font Awesome--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css"/>

{{--Magnific Popup--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/magnific-popup/magnific-popup.css') }}">

{{--Select2--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2-bootstrap-5-theme.min.css') }}"/>

{{--Sweet Alert--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}"/>

{{--Filepond--}}
<link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond-plugin-image-preview.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond-plugin-pdf-preview.min.css') }}" type="text/css"/>

{{--Jquery Vectormap--}}
<link rel="stylesheet" href="{{ asset('assets/css/pages/jquery-jvectormap-2.0.5.css') }}" type="text/css"/>

{{--JS Tree--}}
<link rel="stylesheet" href="{{asset('assets/extensions/jstree/jstree.min.css')}}"/>

{{--<link href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>--}}
{{--<link rel="stylesheet" href="{{ url('assets/extensions/chosen.css') }}"/>--}}

<script>
    // Function to handle image errors
    function handleImageError(image) {
        image.classList.contains('custom-default-image')
        if (image.getAttribute('data-custom-image') != null) {
            image.src = image.getAttribute('data-custom-image');
        } else {
            image.src = "{{asset('/assets/images/no_image_available.png')}}";
        }
        // console.log('Image failed to load: ' + image.src);
    }

    // Create a MutationObserver to watch for DOM changes
    const observer = new MutationObserver((mutationsList) => {
        mutationsList.forEach((mutation) => {
            if (mutation.addedNodes) {
                mutation.addedNodes.forEach((node) => {
                    // Check if the added node is an image element
                    if (node instanceof HTMLImageElement) {
                        node.addEventListener('error', () => {
                            handleImageError(node);
                        });
                    }
                });
            }
        });
    });

    // Start observing changes in the DOM
    observer.observe(document, {childList: true, subtree: true});

    const onErrorImage = (e) => {
        if (!e.target.src.includes('no_image_available.png')) {
            e.target.src = "{{asset('/assets/images/no_image_available.png')}}";
        }
    };

    {{--const onErrorImageSidebarHorizontalLogo = (e) => {--}}
    {{--    if (!e.target.src.includes('no_image_available.jpg')) {--}}
    {{--        e.target.src = "{{asset('/assets/vertical-logo.svg')}}";--}}
    {{--    }--}}
    {{--};--}}
</script>
