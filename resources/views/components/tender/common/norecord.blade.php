@props(['msg'])
<div class="row py-1 mx-3">
	<div class="col-12">
		<div class="alert alert-secondary">
			<div class="iq-alert-text">
				{{ $msg ?? 'Belum ada data' }}
			</div>
		</div>
	</div>
</div>