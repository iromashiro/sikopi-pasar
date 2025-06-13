@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        name="{{ $name }}" value="{{ old($name, $value) }}" {{ $required ? 'required' : '' }} {{ $attributes }}>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>