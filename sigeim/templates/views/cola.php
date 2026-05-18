<?php
$pendingJobs = [];
$completedJobs = [];

if ($isLoggedIn) {
    foreach ($jobs as $job) {
        if ($job['status'] === \App\Helpers\PrintStatus::COMPLETED) {
            $date = date('Y-m-d', strtotime($job['created_at']));
            $completedJobs[$date][] = $job;
        } else {
            $pendingJobs[] = $job;
        }
    }
} else {
    $pendingJobs = $jobs;
}
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary p-4 text-white border-bottom-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Cola de Impresión</h5>
            <p class="mb-0 small opacity-75">Estado actual de los trabajos de impresión en el sistema</p>
        </div>
        <div class="badge bg-white text-primary rounded-pill px-3 py-2">
            <?= count($jobs) ?> Trabajos
        </div>
    </div>

    <?php if ($isLoggedIn): ?>
    <div class="bg-primary px-4 pb-1">
        <ul class="nav nav-tabs border-0 custom-tabs" id="jobTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold text-white opacity-75 border-0 bg-transparent py-3" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                    Pendientes <span class="ms-1 badge bg-white text-primary rounded-pill"><?= count($pendingJobs) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-white opacity-75 border-0 bg-transparent py-3" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                    Terminados <span class="ms-1 badge bg-white text-primary rounded-pill"><?= array_sum(array_map('count', $completedJobs)) ?></span>
                </button>
            </li>
        </ul>
    </div>
    <?php endif; ?>

    <div class="tab-content" id="jobTabsContent">
        <!-- PENDING TAB -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary">
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
                        <?php if (empty($pendingJobs)): ?>
                        <tr>
                            <td colspan="<?= $isLoggedIn ? 8 : 6 ?>" class="text-center py-5 text-muted">
                                <i data-lucide="printer" class="mb-2 d-block mx-auto" style="width: 48px; height: 48px; opacity: 0.2;"></i>
                                No hay trabajos pendientes.
                            </td>
                        </tr>
                        <?php endif; ?>
                        
                        <?php foreach ($pendingJobs as $job): ?>
                        <?= renderJobRow($job, $isLoggedIn) ?>
                        <?php if ($isLoggedIn): ?>
                        <?= renderJobDetail($job) ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- COMPLETED TAB -->
        <?php if ($isLoggedIn): ?>
        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary">
                        <tr>
                            <th class="ps-4">Nro</th>
                            <th>Documento</th>
                            <th>Departamento</th>
                            <th class="text-center">Total Copias</th>
                            <th>Fecha de Creación</th>
                            <th>Estado</th>
                            <th>Tipo</th>
                            <th class="pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-body">
                        <?php if (empty($completedJobs)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i data-lucide="check-check" class="mb-2 d-block mx-auto" style="width: 48px; height: 48px; opacity: 0.2;"></i>
                                No hay trabajos terminados aún.
                            </td>
                        </tr>
                        <?php endif; ?>
                        
                        <?php foreach ($completedJobs as $date => $dayJobs): ?>
                        <tr class="bg-body-tertiary border-top border-bottom">
                            <td colspan="8" class="ps-4 py-2 small fw-bold text-uppercase text-muted">
                                <i data-lucide="calendar" class="icon-xs me-1"></i>
                                <?= date('d M Y', strtotime($date)) ?>
                            </td>
                        </tr>
                        <?php foreach ($dayJobs as $job): ?>
                        <?= renderJobRow($job, true) ?>
                        <?= renderJobDetail($job) ?>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
function renderJobRow($job, $isLoggedIn) {
    ob_start();
    ?>
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
            <div class="d-flex gap-2">
                <a href="<?= htmlspecialchars($job['file_path']) ?>" class="btn btn-sm btn-light border shadow-sm" download title="Descargar archivo" onclick="event.stopPropagation();">
                    <i data-lucide="download" class="icon-sm"></i>
                </a>
                <?php if ($job['status'] !== \App\Helpers\PrintStatus::COMPLETED): ?>
                <button class="btn btn-sm btn-success border shadow-sm btn-complete" 
                        data-id="<?= $job['id'] ?>" 
                        title="Marcar como completado"
                        onclick="event.stopPropagation(); updateJobStatus(<?= $job['id'] ?>, 'completado')">
                    <i data-lucide="check" class="icon-sm"></i>
                </button>
                <?php endif; ?>
            </div>
        </td>
        <?php endif; ?>
    </tr>
    <?php
    return ob_get_clean();
}

function renderJobDetail($job) {
    ob_start();
    ?>
    <tr class="collapse" id="job-<?= $job['id'] ?>">
        <td colspan="8" class="bg-tertiary p-0 border-0">
            <div class="p-4 bg-body border-start border-primary border-4 shadow-inner">
                <div class="d-flex align-items-center mb-3">
                    <i data-lucide="list" class="me-2 text-primary"></i>
                    <h6 class="mb-0 fw-bold">Configuración de Copias</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle bg-body mb-0 shadow-sm">
                        <thead class="bg-body-tertiary small">
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
    <?php
    return ob_get_clean();
}
?>

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

    /* Refinamientos para modo oscuro */
    [data-bs-theme="dark"] .table {
        --bs-table-bg: #0a0a0a;
        --bs-table-border-color: #1a1a1a;
    }
    
    [data-bs-theme="dark"] .bg-body-tertiary {
        background-color: #141414 !important;
    }

    [data-bs-theme="dark"] .table-hover tbody tr:hover td {
        background-color: #121212;
    }

    [data-bs-theme="dark"] .bg-tertiary {
        background-color: #050505 !important;
    }

    [data-bs-theme="dark"] .badge {
        color: #fff !important;
    }

    /* Ajuste específico para los badges en áreas primarias (header y tabs) en modo oscuro */
    [data-bs-theme="dark"] .card .bg-primary .badge.bg-white {
        background-color: #0a0a0a !important;
        color: var(--bs-primary) !important;
        border: 1px solid var(--bs-primary) !important;
    }

    /* Tabs Personalizadas */
    .custom-tabs .nav-link {
        border-radius: 0;
        border-bottom: 3px solid transparent !important;
        transition: all 0.2s;
    }
    .custom-tabs .nav-link.active {
        opacity: 1 !important;
        border-bottom: 3px solid white !important;
    }
    .custom-tabs .nav-link:hover {
        opacity: 1 !important;
    }
    .custom-tabs .badge {
        font-size: 0.7rem;
    }
</style>

<script>
    // Asegurar que Lucide reconozca los nuevos iconos después de cargar
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    function updateJobStatus(id, status) {
        if (!confirm('¿Estás seguro de que deseas marcar este trabajo como ' + status + '?')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);

        fetch('/cola/actualizar-estado', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el estado: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de red al intentar actualizar el estado');
        });
    }
</script>
