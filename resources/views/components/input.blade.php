@props(['name','label','type'=>'text','value'=>'','required'=>false])
<div class="mb-2">
    <label class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name,$value) }}"
        {{ $attributes->merge(['class'=>'form-control', $required?'required':'']) }}>
</div>