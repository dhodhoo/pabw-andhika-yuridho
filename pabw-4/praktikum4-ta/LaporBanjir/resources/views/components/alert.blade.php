@if ($type === 'error')
<div style="padding: 10px; border: 1px solid red; margin: 10px 0; background-color: #f8d7da; color: #721c24;">
    @else
    <div style="padding: 10px; border: 1px solid green; margin: 10px 0; background-color: #d4edda; color: #155724;">
        @endif
        <strong>{{ ucfirst($type) }}:</strong> {{ $message }}
    </div>
</div>
