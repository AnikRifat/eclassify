<script type="text/javascript" src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>

{{-- Firebasejs 8.10.0--}}
{{--<script type="text/javascript" src="{{ asset('assets/js/firebase-app.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('assets/js/firebase-messaging.js')}}"></script>--}}


{{--Sweet Alert --}}
<script type="text/javascript" src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

{{--Tiny MCE--}}
<script type="text/javascript" src="{{ asset('assets/extensions/tinymce/tinymce.min.js') }}"></script>

{{--Jquery Vector Map--}}
<script type="text/javascript" src="{{ asset('assets/extensions/jquery-vector-map/jquery-jvectormap-2.0.5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/jquery-vector-map/jquery-jvectormap-asia-merc.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/jquery-vector-map/jquery-jvectormap-world-mill-en.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/jquery-vector-map/jquery-jvectormap-world-mill.js') }}"></script>

{{--Toastify--}}
<script type="text/javascript" src="{{ asset('assets/extensions/toastify-js/toastify.js') }}"></script>

{{--Parsley--}}
<script type="text/javascript" src="{{ asset('assets/js/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/parsley.js') }}"></script>


{{--Magnific Popup--}}
<script type="text/javascript" src="{{ asset('assets/extensions/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

{{--Select2--}}
<script type="text/javascript" src="{{ asset('assets/extensions/select2/select2.min.js') }}"></script>

{{--Jquery UI--}}
<script type="text/javascript" src="{{ asset('assets/extensions/jquery-ui/jquery-ui.min.js') }}"></script>

{{--Clipboard JS--}}
<script type="text/javascript" src="{{ asset('assets/js/clipboard.min.js') }}"></script>

{{--Filepond--}}
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond.jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond-plugin-image-preview.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond-plugin-pdf-preview.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond-plugin-file-validate-type.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/filepond/filepond-plugin-image-validate-size.min.js') }}"></script>

{{--JS Tree--}}
<script src="{{asset("assets/extensions/jstree/jstree.min.js")}}"></script>


{{-- Custom JS --}}
<script type="text/javascript" src="{{ asset('assets/js/custom/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom/function.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom/bootstrap-table/formatter.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom/bootstrap-table/queryParams.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom/bootstrap-table/actionEvents.js') }}"></script>


{{--Bootstrap Table--}}
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/bootstrap-table.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/fixed-columns/bootstrap-table-fixed-columns.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/mobile/bootstrap-table-mobile.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/jquery.tablednd.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/extensions/bootstrap-table/bootstrap-table-reorder-rows.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/extensions/bootstrap-table/export/bootstrap-table-export.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/extensions/bootstrap-table/export/tableExport.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/extensions/bootstrap-table/export/jspdf.umd.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/extensions/bootstrap-table/mobile/bootstrap-table-mobile.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/extensions/bootstrap-table/filter/bootstrap-table-filter-control.min.js')}}"></script>

{{--Language Translation--}}
<script src="{{route('common.language.read')}}"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> --}}
{{--<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>--}}
{{--<script src="https://bevacqua.github.io/dragula/dist/dragula.js"></script>--}}
<script type="text/javascript">
    window.baseurl = "{{ URL::to('/') }}/";
    @if (Session::has('success'))
    showSuccessToast("{{ Session::get('success') }}")
    @endif

    {{--    @if (Session::has('errors'))--}}
    {{--    @if(is_array(Session::get('errors')))--}}
    {{--    @foreach ($errors->all() as $error)--}}

    {{--    showErrorToast("{{ $error }}")--}}
    {{--    @endforeach--}}
    {{--    @else--}}
    {{--    @dd(Session::get('errors'))--}}
    {{--    console.log("{{ Session::get('errors') }}")--}}
    {{--    showErrorToast("{{ Session::get('errors')->message }}")--}}
    {{--    @endif--}}
    {{--    @endif--}}

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    showErrorToast("{!! $error !!}");
    @endforeach
    @endif
    @if (Session::has('error'))
    showErrorToast('{!!  Session::get('error') !!}')
    @endif

</script>
