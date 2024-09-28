<!DOCTYPE html>

<html lang="en">
	@include('partials.auth._head')
	<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<style>body { background-image: url('assets/media/auth/bg1-dark.jpg'); } [data-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }</style>
			
            @section('mainContent')
            @show
		</div>
		@include('partials.auth._script')
	</body>
</html>