<?php
ob_start();

// $departments and $pageTypes are passed from the router
?>

<form id="multiStepForm" action="/subida" method="POST" enctype="multipart/form-data">
    <!-- Step 1: Documento -->
    <div id="step-1" class="step-content">
        <div class="mb-4">
            <label for="doc_name" class="form-label small fw-semibold">Nombre del Documento</label>
            <input type="text" class="form-control bg-body-tertiary" id="doc_name" name="doc_name" placeholder="Ej: Informe Trimestral" required>
        </div>
        <div class="mb-4">
            <label for="document" class="form-label small fw-semibold">Cargar Archivo</label>
            <div class="input-group">
                <span class="input-group-text bg-body-tertiary border-end-0">
                    <i data-lucide="file-up" class="icon-sm text-muted"></i>
                </span>
                <input type="file" class="form-control bg-body-tertiary border-start-0" id="document" name="document" required>
            </div>
        </div>
    </div>

    <!-- Step 2: Dirección -->
    <div id="step-2" class="step-content d-none">
        <div class="mb-4">
            <label for="department" class="form-label small fw-semibold">Seleccionar Dirección / Departamento</label>
            <div class="input-group">
                <span class="input-group-text bg-body-tertiary border-end-0">
                    <i data-lucide="building-2" class="icon-sm text-muted"></i>
                </span>
                <select class="form-select bg-body-tertiary border-start-0 ps-0" id="department" name="department" required>
                    <option value="" selected disabled>Selecciona una oficina...</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Step 3: Configuración -->
    <div id="step-3" class="step-content d-none">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-end mb-1">
                <label for="total_copies" class="form-label small fw-semibold mb-0">Cantidad de Copias</label>
                <div class="form-check form-switch mb-0">
                    <input name="sameCopies" class="form-check-input" type="checkbox" role="switch" id="sameCopies" checked>
                    <label class="form-check-label small text-muted" for="sameCopies">¿Son iguales?</label>
                </div>
            </div>
            <input type="number" class="form-control bg-body-tertiary" id="total_copies" name="total_copies" value="1" min="1" required>
        </div>
        
        <div id="copies-grid" class="row g-3">
            <!-- Grid dinámico -->
        </div>
    </div>

    <!-- Step 4: Notas -->
    <div id="step-4" class="step-content d-none">
        <div class="mb-4">
            <label for="notes" class="form-label small fw-semibold">Notas Adicionales</label>
            <textarea class="form-control bg-body-tertiary" id="notes" name="notes" rows="4" placeholder="Alguna instrucción específica..."></textarea>
        </div>
    </div>

    <!-- Step 5: Resumen -->
    <div id="step-5" class="step-content d-none">
        <div class="list-group list-group-flush rounded-3 border overflow-hidden mb-4">
            <!-- Documento -->
            <div class="list-group-item bg-body-tertiary p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Documento</div>
                        <div id="summary-doc-name" class="fw-bold">Sin nombre</div>
                        <div id="summary-file-name" class="small text-muted">No se ha seleccionado archivo</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="goToStep(1)">Editar</button>
                </div>
            </div>
            <!-- Dirección -->
            <div class="list-group-item bg-body-tertiary p-3 border-top">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Dirección / Departamento</div>
                        <div id="summary-dept" class="fw-bold">No seleccionado</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="goToStep(2)">Editar</button>
                </div>
            </div>
            <!-- Configuración -->
            <div class="list-group-item bg-body-tertiary p-3 border-top">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Configuración de Impresión</div>
                        <div id="summary-copies-count" class="fw-bold">1 Copia</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="goToStep(3)">Editar</button>
                </div>
                <div id="summary-copies-list" class="small text-muted">
                    <!-- Lista de configuraciones -->
                </div>
            </div>
            <!-- Notas -->
            <div class="list-group-item bg-body-tertiary p-3 border-top">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="small text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">Notas Adicionales</div>
                        <div id="summary-notes" class="small italic">Sin notas adicionales.</div>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-primary p-0" onclick="goToStep(4)">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 d-flex justify-content-between pt-3 border-top opacity-75">
        <div>
            <button type="button" class="btn btn-outline-danger px-3 py-2 small fw-bold me-2" id="clearBtn">
                <i data-lucide="trash-2" class="me-2 icon-sm"></i>Limpiar
            </button>
            <button type="button" class="btn btn-outline-secondary px-4 py-2 small fw-bold" id="prevBtn" disabled>
                Anterior
            </button>
        </div>
        <button type="button" class="btn btn-primary px-4 py-2 small fw-bold" id="nextBtn">
            Siguiente
        </button>
    </div>
</form>

<script>
let currentStep = 1;
const totalSteps = 5;

function goToStep(step) {
    currentStep = step;
    showStep(currentStep);
}

function showStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
    document.getElementById(`step-${step}`).classList.remove('d-none');
    
    document.getElementById('prevBtn').disabled = step === 1;
    
    if (step === totalSteps) {
        updateSummary();
        document.getElementById('nextBtn').innerHTML = '<i data-lucide="check" class="me-2 icon-sm"></i>Confirmar y Encolar';
    } else {
        document.getElementById('nextBtn').innerHTML = 'Siguiente';
    }
    lucide.createIcons();
    updateStepper();
}

function updateStepper() {
    const bars = document.querySelectorAll('.progress-bar');
    const headerLabels = document.querySelectorAll('.step-label');
    
    bars.forEach((bar, index) => {
        if (index < currentStep) {
            bar.classList.add('bg-white');
            bar.classList.remove('bg-transparent');
        } else {
            bar.classList.remove('bg-white');
            bar.classList.add('bg-transparent');
        }
    });

    headerLabels.forEach((label, index) => {
        if (index < currentStep) {
            label.style.color = '#fff';
        } else {
            label.style.color = 'rgba(255,255,255,0.5)';
        }
    });
}

function updateSummary() {
    // Basic Info
    document.getElementById('summary-doc-name').textContent = document.getElementById('doc_name').value || 'Sin nombre';
    const fileInput = document.getElementById('document');
    document.getElementById('summary-file-name').textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No se ha seleccionado archivo';
    
    const deptSelect = document.getElementById('department');
    document.getElementById('summary-dept').textContent = deptSelect.options[deptSelect.selectedIndex]?.text || 'No seleccionado';
    
    document.getElementById('summary-notes').textContent = document.getElementById('notes').value || 'Sin notas adicionales.';

    // Copies Config
    const copiesCount = document.getElementById('total_copies').value;
    document.getElementById('summary-copies-count').textContent = `${copiesCount} Copia(s)`;
    
    const summaryList = document.getElementById('summary-copies-list');
    summaryList.innerHTML = '';
    
    const rows = document.querySelectorAll('#copies-grid .col-12');
    rows.forEach((row, i) => {
        const selects = row.querySelectorAll('select');
        const modo = selects[0].options[selects[0].selectedIndex].text;
        const papel = selects[1].options[selects[1].selectedIndex].text;
        const orientation = selects[2].options[selects[2].selectedIndex].text;
        const escala = selects[3].options[selects[3].selectedIndex].text;
        
        const allPages = row.querySelector('.all-pages-check').checked;
        const isDouble = row.querySelector('.is-double-check').checked;
        const pages = allPages ? 'Todas las páginas' : `Páginas: ${row.querySelector('.pages-input').value}`;

        const item = document.createElement('div');
        item.className = 'mb-3 p-3 border rounded-3 bg-body-secondary shadow-sm';
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-secondary-subtle">
                <span class="badge bg-primary px-2 py-1" style="font-size: 0.65rem;">CONFIGURACIÓN #${i+1}</span>
                <div class="d-flex gap-1">
                    ${isDouble ? '<span class="badge bg-info text-dark" style="font-size: 0.6rem;">DOBLE CARA</span>' : ''}
                    <span class="badge bg-secondary" style="font-size: 0.6rem;">${papel.toUpperCase()}</span>
                </div>
            </div>
            <div class="row g-2 x-small text-body-secondary">
                <div class="col-6">
                    <i data-lucide="monitor" class="icon-xs me-1"></i><b>Modo:</b> ${modo}
                </div>
                <div class="col-6">
                    <i data-lucide="align-left" class="icon-xs me-1"></i><b>Orientación:</b> ${orientation}
                </div>
                <div class="col-6">
                    <i data-lucide="maximize" class="icon-xs me-1"></i><b>Escala:</b> ${escala}
                </div>
                <div class="col-12 mt-2 pt-2 border-top border-secondary-subtle text-primary">
                    <i data-lucide="layers" class="icon-xs me-1"></i><b>Alcance:</b> ${pages}
                </div>
            </div>
        `;
        summaryList.appendChild(item);
    });
    lucide.createIcons();
}

document.addEventListener('DOMContentLoaded', function() {
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const clearBtn = document.getElementById('clearBtn');
    const totalCopiesInput = document.getElementById('total_copies');
    const sameCopiesCheck = document.getElementById('sameCopies');
    const copiesGrid = document.getElementById('copies-grid');

    function validatePagesExpression(value) {
        if (!value.trim()) return false;
        const regex = /^[0-9,\-]+$/;
        if (!regex.test(value)) return false;

        const parts = value.split(',');
        for (let part of parts) {
            part = part.trim();
            if (part === "") continue;
            if (part.includes('-')) {
                const range = part.split('-');
                if (range.length !== 2) return false;
                const start = parseInt(range[0]);
                const end = parseInt(range[1]);
                if (isNaN(start) || isNaN(end) || start >= end || start < 1) return false;
            } else {
                if (isNaN(parseInt(part)) || parseInt(part) < 1) return false;
            }
        }
        return true;
    }

    nextBtn.addEventListener('click', () => {
        if (currentStep === 1) {
            if (!document.getElementById('doc_name').value || !document.getElementById('document').value) {
                showToast('Aviso', 'Complete los datos del documento.', 'warning');
                return;
            }
        }
        if (currentStep === 2) {
            if (!document.getElementById('department').value) {
                showToast('Aviso', 'Seleccione un departamento.', 'warning');
                return;
            }
        }
        if (currentStep === 3) {
            let allValid = true;
            document.querySelectorAll('.pages-input').forEach(input => {
                const container = input.closest('.specific-pages-container');
                if (container && !container.classList.contains('d-none')) {
                    let val = input.value;
                    const hyphenCount = (val.match(/-/g) || []).length;
                    if (hyphenCount > 1) {
                        val = val.replace(/-/g, ',');
                        val = val.replace(/,+/g, ',');
                        input.value = val;
                    }
                    if (!validatePagesExpression(input.value)) {
                        input.classList.add('is-invalid');
                        allValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                }
            });
            if (!allValid) {
                showToast('Error', 'Revise el formato de las páginas.', 'error');
                return;
            }
        }

        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        } else {
            document.getElementById('multiStepForm').submit();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    clearBtn.addEventListener('click', () => {
        if (confirm('¿Estás seguro de que deseas limpiar todo el formulario?')) {
            document.getElementById('multiStepForm').reset();
            totalCopiesInput.value = 1;
            sameCopiesCheck.checked = true;
            updateGrid();
            goToStep(1);
            showToast('Info', 'Formulario reiniciado.', 'info');
        }
    });

    const pageTypes = <?= json_encode($pageTypes ?? []) ?>;

    function createConfigRow(index) {
        const col = document.createElement('div');
        col.className = 'col-12';
        
        let pageTypeOptions = '';
        pageTypes.forEach(type => {
            pageTypeOptions += `<option value="${type.name.toLowerCase()}">${type.name}</option>`;
        });

        col.innerHTML = `
            <div class="card bg-body-tertiary border-0 p-3 position-relative">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-row" style="font-size: 0.7rem;"></button>
                <div class="row g-3">
                    <div class="col-md-1 d-flex align-items-center justify-content-center border-end">
                        <span class="badge bg-secondary rounded-circle">${index + 1}</span>
                    </div>
                    <div class="col-md-11">
                        <div class="row g-3 align-items-start">
                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1" style="font-size: 0.65rem;">MODO</label>
                                        <select name="configs[${index}][modo]" class="form-select form-select-sm bg-body border-0 shadow-none">
                                            <option value="blanco_negro">Blanco y Negro</option>
                                            <option value="color">Color</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1" style="font-size: 0.65rem;">PAPEL</label>
                                        <select name="configs[${index}][papel]" class="form-select form-select-sm bg-body border-0 shadow-none">
                                            ${pageTypeOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1" style="font-size: 0.65rem;">ORIENTACIÓN</label>
                                        <select name="configs[${index}][orientacion]" class="form-select form-select-sm bg-body border-0 shadow-none">
                                            <option value="vertical">Vertical</option>
                                            <option value="horizontal">Horizontal</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small fw-bold mb-1" style="font-size: 0.65rem;">ESCALA</label>
                                        <select name="configs[${index}][escala]" class="form-select form-select-sm bg-body border-0 shadow-none">
                                            <option value="original (100%)">Original (100%)</option>
                                            <option value="reducido (-50%)">Reducido (-50%)</option>
                                            <option value="agrandado (+50%)">Agrandado (+50%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 border-start ps-3">
                                <div class="form-check form-switch mb-2">
                                    <input name="configs[${index}][all_pages]" class="form-check-input all-pages-check" type="checkbox" role="switch" checked value="1">
                                    <label class="form-check-label small fw-bold" style="font-size: 0.65rem;">TODAS LAS PÁGINAS</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input name="configs[${index}][is_double]" class="form-check-input is-double-check" type="checkbox" role="switch" value="1">
                                    <label class="form-check-label small fw-bold" style="font-size: 0.65rem;">POR AMBAS CARAS</label>
                                </div>
                                <div class="specific-pages-container d-none">
                                    <label class="small fw-bold mb-1 d-block" style="font-size: 0.65rem;">RANGO / PÁGINAS</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="configs[${index}][pages]" class="form-control bg-body border-0 shadow-none pages-input" placeholder="1-5, 8..." style="font-size: 0.75rem;">
                                        <span class="input-group-text bg-body border-0 text-muted cursor-help" 
                                              data-bs-toggle="tooltip" 
                                              data-bs-html="true" 
                                              title="<b>Formatos permitidos:</b><ul class='small mb-0 mt-1 ps-3'><li><b>1-5</b>: De la página 1 a la 5.</li><li><b>1,4,8</b>: Las páginas 1, 4 y 8.</li><li><b>1-4-8-9</b>: Se interpretará como las páginas 1, 4, 8 y 9.</li></ul>">
                                            <i data-lucide="help-circle" style="width: 14px; height: 14px;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        const allPagesCheck = col.querySelector('.all-pages-check');
        const specificPagesContainer = col.querySelector('.specific-pages-container');
        const pagesInput = col.querySelector('.pages-input');

        pagesInput.addEventListener('input', (e) => {
            let val = e.target.value;
            val = val.replace(/ /g, '-').replace(/[^0-9,\-]/g, '').replace(/-+/g, '-').replace(/,+/g, ',');
            e.target.value = val;
        });

        allPagesCheck.addEventListener('change', () => {
            if (allPagesCheck.checked) {
                specificPagesContainer.classList.add('d-none');
                pagesInput.classList.remove('is-invalid');
            } else {
                specificPagesContainer.classList.remove('d-none');
            }
        });

        col.querySelector('.remove-row').addEventListener('click', () => {
            if (copiesGrid.children.length > 1) {
                const tooltipTrigger = col.querySelector('[data-bs-toggle="tooltip"]');
                const tooltip = bootstrap.Tooltip.getInstance(tooltipTrigger);
                if (tooltip) tooltip.dispose();
                col.remove();
                updateRowNumbers();
                if (!sameCopiesCheck.checked) totalCopiesInput.value = copiesGrid.children.length;
            } else {
                showToast('Aviso', 'Debe mantener al menos una configuración.', 'warning');
            }
        });
        
        setTimeout(() => {
            lucide.createIcons({ props: { parent: col } });
            const tooltipTrigger = col.querySelector('[data-bs-toggle="tooltip"]');
            if (tooltipTrigger) new bootstrap.Tooltip(tooltipTrigger);
        }, 0);

        return col;
    }

    function updateRowNumbers() {
        Array.from(copiesGrid.children).forEach((row, i) => {
            row.querySelector('.badge').textContent = i + 1;
        });
    }

    function updateGrid() {
        const isSame = sameCopiesCheck.checked;
        let count = parseInt(totalCopiesInput.value) || 1;
        if (isSame) count = 1;
        const currentCount = copiesGrid.children.length;

        if (count > currentCount) {
            for (let i = currentCount; i < count; i++) {
                copiesGrid.appendChild(createConfigRow(i));
            }
        } else if (count < currentCount) {
            for (let i = currentCount; i > count; i--) {
                copiesGrid.lastElementChild.remove();
            }
        }
    }

    totalCopiesInput.addEventListener('change', updateGrid);
    totalCopiesInput.addEventListener('keyup', updateGrid);
    sameCopiesCheck.addEventListener('change', updateGrid);

    updateGrid();
});
</script>

<?php
$formContent = ob_get_clean();
$title = "SIGEIM";
$subtitle = "Asistente de Subida de Documentos";
$width = "65dvw";
$formMaxWidth = "100%"; 
$steps = ['Documento', 'Dirección', 'Configuración', 'Notas', 'Resumen'];
$showClose = true;

include __DIR__ . '/../components/form_container.php';
?>
