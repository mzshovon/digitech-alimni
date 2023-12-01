<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{URL::to('/')}}/public/assets/vendor/jquery/jquery.min.js"></script>
{{--  <script src="/cuma/public/') }}admin/assets/vendor/apexcharts/apexcharts.min.js"></script>  --}}
<script src="{{URL::to('/')}}/public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
{{--  <script src="/cuma/public/') }}admin/assets/vendor/jqueryui/js/jquery-ui.min.js"></script>  --}}
{{--  <script src="/cuma/public/') }}admin/assets/vendor/chart.js/chart.umd.js"></script>  --}}
{{--  <script src="/cuma/public/') }}admin/assets/vendor/echarts/echarts.min.js"></script>  --}}
{{--  <script src="/cuma/public/') }}admin/assets/vendor/quill/quill.min.js"></script>  --}}
<script src="{{URL::to('/')}}/public/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="{{URL::to('/')}}/public/assets/vendor/tinymce/tinymce.min.js"></script>
{{--  <script src="/cuma/public/') }}admin/assets/vendor/php-email-form/validate.js"></script>  --}}

<script src="{{URL::to('/')}}/public/assets/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

@stack('script')

<script>
    $(document).ready(function() {
		toastr.options.timeOut = 10000;
		@if (Session::has('error'))
			toastr.error('{{ Session::get('error') }}');
           {{ Session::forget('error')}}
		@elseif(Session::has('success'))
			toastr.success('{{ Session::get('success') }}');
            {{ Session::forget("success")}}
		@endif
	});
</script>

</body>

</html>
