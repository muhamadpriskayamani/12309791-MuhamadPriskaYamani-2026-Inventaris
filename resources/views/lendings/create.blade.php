@extends('layouts.app')

@section('content')

<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="mb-4 fw-semibold">Add Lending</h4>

                    <form action="{{ route('lendings.store') }}" method="POST" id="lendingForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-medium">Borrower Name</label>
                            <input type="text" name="borrower_name" value="{{ old('borrower_name') }}"
                                class="form-control rounded-3" required>
                        </div>

                        {{-- Item Rows --}}
                        <div id="itemsWrapper"></div>

                        {{-- Add More Button --}}
                        <div class="mb-4">
                            <button type="button" id="addRowBtn"
                                class="btn btn-outline-secondary btn-sm rounded-3 px-3"
                                style="border-style: dashed;">
                                + More Item
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Description</label>
                            <input type="text" name="description" value="{{ old('description') }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lendings.index') }}" class="btn btn-light border rounded-3 px-4">
                                ← Back
                            </a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4" id="submitBtn">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

<script>
    const itemsData = @json($items);

    let rowIndex = 0;

    function buildOptions() {
        return itemsData.reduce((html, item) => {
            return html + `<option value="${item.id}" data-available="${item.available}">${item.name}</option>`;
        }, '<option value="">-- select item --</option>');
    }

    function createRowHTML(index) {
        return `
            <div class="item-row mb-3" data-index="${index}">
                <div class="row g-2 align-items-start">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Item</label>
                        <select name="items[${index}][item_id]" class="form-select rounded-3 item-select" required>
                            ${buildOptions()}
                        </select>
                        <small class="available-info text-muted d-block mt-1"></small>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-medium">Total</label>
                        <input type="number" name="items[${index}][total]"
                            class="form-control rounded-3 total-input" min="1" required>
                        <div class="total-alert alert alert-danger py-1 px-2 mt-1 mb-0 d-none"
                            style="font-size: .8rem;">
                            Total exceeds available stock!
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end pb-1" style="padding-top: 2rem;">
                        <button type="button"
                            class="btn btn-outline-danger btn-sm rounded-3 remove-row-btn d-none"
                            title="Remove">
                            &times;
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function attachRowEvents(row) {
        const select     = row.querySelector('.item-select');
        const totalInput = row.querySelector('.total-input');
        const availInfo  = row.querySelector('.available-info');
        const totalAlert = row.querySelector('.total-alert');
        const removeBtn  = row.querySelector('.remove-row-btn');

        function check() {
            const available = parseInt(select.options[select.selectedIndex]?.dataset?.available ?? 0);
            const total     = parseInt(totalInput.value ?? 0);

            availInfo.textContent = select.value ? `Available stock: ${available}` : '';

            const exceeded = select.value && total > available;
            totalAlert.classList.toggle('d-none', !exceeded);

            validateAll();
        }

        select.addEventListener('change', check);
        totalInput.addEventListener('input', check);

        removeBtn.addEventListener('click', () => {
            row.remove();
            updateRemoveButtons();
            validateAll();
        });
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            row.querySelector('.remove-row-btn').classList.toggle('d-none', rows.length === 1);
        });
    }

    function validateAll() {
        const hasError = [...document.querySelectorAll('.total-alert')]
            .some(a => !a.classList.contains('d-none'));
        document.getElementById('submitBtn').disabled = hasError;
    }

    function addRow() {
        const wrapper  = document.getElementById('itemsWrapper');
        const temp     = document.createElement('template');
        temp.innerHTML = createRowHTML(rowIndex).trim();
        const row      = temp.content.firstChild;
        wrapper.appendChild(row);
        attachRowEvents(row);
        updateRemoveButtons();
        rowIndex++;
    }

    document.getElementById('addRowBtn').addEventListener('click', addRow);

    // Init 1 row pertama
    addRow();
</script>

@endsection