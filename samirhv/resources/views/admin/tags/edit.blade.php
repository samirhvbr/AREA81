@extends('admin.layouts.app')

@section('title', 'Editar tag')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Editar tag</h1>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card" style="max-width:420px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.tags.update', $tag) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $tag->slug) }}">
                    @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
