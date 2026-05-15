<div class="row justify-content-center flex-grow-1 align-items-center py-5">
    <div class="col-md-6 text-center">
        <div class="card shadow-sm border-0 p-5">
            <div class="mb-4">
                <lottie-player 
                    id="lottie-msg-icon"
                    background="transparent" 
                    speed="1" 
                    class="<?= ($type ?? 'success') === 'error' ? 'lottie-error-mask' : '' ?>"
                    style="width: 150px; height: 150px; margin: 0 auto;" 
                    autoplay>
                </lottie-player>
            </div>
            <h1 class="h3 fw-bold mb-3 <?= ($type ?? 'success') === 'error' ? 'text-danger' : '' ?>">
                <?= $message_title ?? 'Operación Exitosa' ?>
            </h1>
            <?php if (isset($job_id)): ?>
                <p class="fw-bold text-primary mb-3">#<?= $job_id ?></p>
            <?php endif; ?>
            <p class="text-muted mb-5"><?= $message_body ?? 'La solicitud se ha procesado correctamente.' ?></p>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <?php if (isset($primary_link)): ?>
                    <a href="<?= $primary_link['url'] ?>" class="btn <?= ($type ?? 'success') === 'error' ? 'btn-danger' : 'btn-primary' ?> px-4 py-2 fw-bold shadow-sm">
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

<style>
    .lottie-error-mask {
        /* Applies a red filter to the Lottie animation */
        filter: invert(24%) sepia(92%) saturate(7180%) hue-rotate(354deg) brightness(91%) contrast(119%);
    }
</style>

<script src="<?= asset('js/lottie-player.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const player = document.getElementById('lottie-msg-icon');
        const iconUrl = '<?= asset("icons/" . ($type ?? "success") . ".json") ?>';
        
        // Cargamos el JSON manualmente para evitar el bug de responseType en lottie-player.js
        fetch(iconUrl)
            .then(response => response.json())
            .then(data => {
                player.load(data);
            })
            .catch(err => console.error('Error loading Lottie animation:', err));
    });
</script>
