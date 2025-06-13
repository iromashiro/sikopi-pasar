@props(['name', 'label', 'value' => '', 'required' => false, 'rows' => 3])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <textarea class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}"
        rows="{{ $rows }}" {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>