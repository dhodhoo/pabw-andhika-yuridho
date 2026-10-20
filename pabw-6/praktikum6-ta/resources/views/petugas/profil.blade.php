@extends('layouts.app')

@section('title', 'Profil Petugas')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Profil Petugas</h4>
                    <span class="badge bg-primary">Petugas BPBD</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ Auth::user()->name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ Auth::user()->email }}</dd>

                        <dt class="col-sm-4">Akun dibuat</dt>
                        <dd class="col-sm-8">
                            {{ Auth::user()->created_at->format('d-m-Y H:i') }}
                            ({{ Auth::user()->created_at->diffForHumans() }})
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
