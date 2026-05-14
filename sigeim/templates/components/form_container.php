<div class="row justify-content-center flex-grow-1 align-items-center py-4">
    <div class="col-12 d-flex justify-content-center">
        <div class="card shadow-sm border-0 overflow-hidden" style="width: <?= $width ?? '50dvw' ?>; min-width: <?= $minWidth ?? '320px' ?>;">
            <div class="bg-primary p-4 text-white text-start">
                <div class="d-flex justify-content-between align-items-start <?= isset($steps) ? 'mb-4' : '' ?>">
                    <div>
                        <h2 class="h3 fw-bold mb-1"><?= $title ?? 'SIGEIM' ?></h2>
                        <p class="mb-0 small opacity-75"><?= $subtitle ?? '' ?></p>
                    </div>
                    <?php if (isset($showClose) && $showClose): ?>
                        <a href="/" class="btn btn-link text-white p-0 opacity-75 hover-opacity-100"><i data-lucide="x"></i></a>
                    <?php endif; ?>
                </div>

                <?php if (isset($steps)): ?>
                <div class="row g-2 mt-4 px-2">
                    <?php foreach ($steps as $i => $step): ?>
                    <div class="col">
                        <div class="progress" style="height: 4px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar <?= $i === 0 ? 'bg-white' : 'bg-transparent' ?>" style="width: 100%"></div>
                        </div>
                        <div class="text-center mt-2">
                            <span class="small fw-bold step-label" style="font-size: 0.65rem; text-transform: uppercase; color: <?= $i === 0 ? '#fff' : 'rgba(255,255,255,0.5)' ?>;"><?= $step ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-body p-5 d-flex justify-content-center">
                <div style="width: 100%; max-width: <?= $formMaxWidth ?? '350px' ?>;">
                    <?= $formContent ?? '' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ajustes específicos para inputs en modo oscuro */
    [data-bs-theme="dark"] .input-group-text,
    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .btn-outline-secondary,
    [data-bs-theme="dark"] .form-select {
        background-color: #080808 !important;
        border-color: #1a1a1a !important;
        color: #e1e1e1 !important;
    }
    
    [data-bs-theme="dark"] .form-control:focus,
    [data-bs-theme="dark"] .form-select:focus {
        background-color: #0a0a0a !important;
        border-color: var(--bs-primary) !important;
        box-shadow: none;
    }
</style>
