@extends('admin.layouts.app')

@section('title', 'Editar post')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Editar post</h1>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card" style="border-radius: var(--radius-lg);">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.update', $post) }}">
                @csrf @method('PUT')
                @include('admin.posts._form')
                <div style="display:flex; justify-content:flex-end; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
