<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $user?->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', $user?->email) }}" placeholder="nama@email.com" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="admin" @selected(old('role', $user?->role?->value) === 'admin')>Admin</option>
            <option value="user" @selected(old('role', $user?->role?->value) === 'user')>User</option>
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="password" class="form-label">
            Password @if ($user) <span class="text-muted small">(kosongkan jika tidak diubah)</span> @else <span
                    class="text-danger">*</span> @endif
        </label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
            name="password" @if (! $user) required @endif autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="password_confirmation" class="form-label">Ulangi Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            @if (! $user) required @endif autocomplete="new-password">
    </div>
</div>
