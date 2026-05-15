<div class="card shadow-sm border-0">
    <div class="card-header bg-body py-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Cola de Impresión</h5>
            <p class="text-muted small mb-0">Estado actual de los trabajos de impresión en el sistema</p>
        </div>
        <div class="badge bg-primary rounded-pill px-3 py-2">
            <?= count($jobs) ?> Trabajos
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nro</th>
                    <th>Documento</th>
                    <th>Departamento</th>
                    <th class="text-center">Total Copias</th>
                    <th>Fecha de Creación</th>
                    <th>Estado</th>
                    <?php if ($isLoggedIn): ?>
                    <th>Tipo</th>
                    <th class="pe-4">Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="bg-body">
                <?php if (empty($jobs)): ?>
                <tr>
                    <td colspan="<?= $isLoggedIn ? 8 : 6 ?>" class="text-center py-5 text-muted">
                        <i data-lucide="printer" class="mb-2 d-block mx-auto" style="width: 48px; height: 48px; opacity: 0.2;"></i>
                        No hay trabajos en la cola actualmente.
                    </td>
                </tr>
                <?php endif; ?>
                
                <?php foreach ($jobs as $job): ?>
                <tr <?php if ($isLoggedIn): ?>data-bs-toggle="collapse" data-bs-target="#job-<?= $job['id'] ?>" style="cursor: pointer;"<?php endif; ?>>
                    <td class="ps-4 fw-medium text-primary">#<?= $job['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i data-lucide="file-text" class="icon-sm me-2 text-muted"></i>
                            <?= htmlspecialchars($job['document_name']) ?>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted small">
                            <?= htmlspecialchars($job['department_name']) ?>
                        </span>
                    </td>
                    <td class="text-center fw-bold">
                        <?= $job['total_copies_sum'] ?>
                    </td>
                    <td>
                        <div class="small">
                            <?= date('d/m/Y', strtotime($job['created_at'])) ?>
                            <span class="text-muted d-block"><?= date('H:i', strtotime($job['created_at'])) ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-<?= \App\Helpers\PrintStatus::color($job['status']) ?>-subtle text-<?= \App\Helpers\PrintStatus::color($job['status']) ?> border border-<?= \App\Helpers\PrintStatus::color($job['status']) ?>-subtle px-3">
                            <?= \App\Helpers\PrintStatus::label($job['status']) ?>
                        </span>
                    </td>
                    <?php if ($isLoggedIn): ?>
                    <td class="text-uppercase small fw-bold text-muted"><?= htmlspecialchars($job['file_type']) ?></td>
                    <td class="pe-4">
                        <a href="<?= htmlspecialchars($job['file_path']) ?>" class="btn btn-sm btn-light border shadow-sm" download title="Descargar archivo">
                            <i data-lucide="download" class="icon-sm"></i>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                
                <?php if ($isLoggedIn): ?>
                <tr class="collapse" id="job-<?= $job['id'] ?>">
                    <td colspan="8" class="bg-tertiary p-0 border-0">
                        <div class="p-4 bg-body border-start border-primary border-4 shadow-inner">
                            <div class="d-flex align-items-center mb-3">
                                <i data-lucide="list" class="me-2 text-primary"></i>
                                <h6 class="mb-0 fw-bold">Configuración de Copias</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle bg-body mb-0 shadow-sm">
                                    <thead class="table-light small">
                                        <tr>
                                            <th class="text-center">Cant.</th>
                                            <th>Papel</th>
                                            <th>Color</th>
                                            <th>Orientación</th>
                                            <th>Escala</th>
                                            <th class="text-center">Doble Cara</th>
                                            <th>Páginas</th>
                                            <th>Notas</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <?php foreach ($job['copies'] as $copy): ?>
                                        <tr>
                                            <td class="text-center fw-bold text-primary"><?= $copy['quantity'] ?></td>
                                            <td><?= htmlspecialchars($copy['page_type']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $copy['color_mode'] === 'color' ? 'danger' : 'dark' ?>-subtle text-<?= $copy['color_mode'] === 'color' ? 'danger' : 'dark' ?> small">
                                                    <?= $copy['color_mode'] === 'color' ? 'Color' : 'B/N' ?>
                                                </span>
                                            </td>
                                            <td class="text-capitalize small"><?= $copy['orientation'] ?></td>
                                            <td class="small text-muted"><?= $copy['scale'] ?></td>
                                            <td class="text-center">
                                                <?php if ($copy['is_double']): ?>
                                                    <i data-lucide="check-circle-2" class="text-success icon-sm"></i>
                                                <?php else: ?>
                                                    <i data-lucide="circle" class="text-muted icon-sm" style="opacity: 0.3;"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="<?= $copy['specific_pages'] ? 'text-primary' : 'text-muted italic' ?>">
                                                    <?= $copy['specific_pages'] ?: 'Todas las páginas' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-wrap" style="max-width: 200px;">
                                                    <?= htmlspecialchars($copy['notes'] ?: '-') ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .shadow-inner {
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
    }
    .table-hover tbody tr:hover td {
        background-color: rgba(var(--bs-primary-rgb), 0.02);
    }
    .collapse.show {
        display: table-row !important;
    }
</style>

<script>
    // Asegurar que Lucide reconozca los nuevos iconos después de cargar
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
