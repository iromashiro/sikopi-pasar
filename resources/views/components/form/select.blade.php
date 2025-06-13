@props(['name', 'label', 'options' => [], 'value' => '', 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">
        {{ $label }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <select class="form-select @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}"
        {{ $required ? 'required' : '' }}>
        <option value="">Pilih {{ $label }}</option>
        @foreach($options as $key => $option)
        <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
            {{ $option }}
        </option>
        @endforeach
    </select>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>