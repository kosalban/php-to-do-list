<div class="toast-container-custom">
    {{-- Success Toast --}}
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Error / Danger Toast --}}
    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Info Toast --}}
    @if(session('info'))
        <div class="toast align-items-center text-bg-info text-dark border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Validation Errors Toast --}}
    @if($errors->any())
        <div class="toast align-items-center text-bg-danger border-0 mb-2 shadow" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="fw-bold d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Validation errors occurred:</span>
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

