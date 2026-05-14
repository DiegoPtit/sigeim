<div class="row justify-content-center flex-grow-1 align-items-center py-5">
    <div class="col-md-6 text-center">
        <div class="card shadow-sm border-0 p-5">
            <div class="mb-4">
                <lottie-player 
                    src="<?= asset('icons/' . ($type ?? 'success') . '.json') ?>" 
                    background="transparent" 
                    speed="1" 
                    style="width: 150px; height: 150px; margin: 0 auto;" 
                    autoplay>
                </lottie-player>
            </div>
            <h1 class="h3 fw-bold mb-3"><?= $message_title ?? 'Operación Exitosa' ?></h1>
            <p class="text-muted mb-5"><?= $message_body ?? 'La solicitud se ha procesado correctamente.' ?></p>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <?php if (isset($primary_link)): ?>
                    <a href="<?= $primary_link['url'] ?>" class="btn btn-primary px-4 py-2 fw-bold shadow-sm">
                        <?= $primary_link['text'] ?>
                    </a>
                <?php endif; ?>
                <a href="/" class="btn btn-outline-secondary px-4 py-2 fw-bold">
                    Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('js/lottie-player.js') ?>"></script>
