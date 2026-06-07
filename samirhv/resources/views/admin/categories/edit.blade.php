@extends('admin.layouts.app')

@section('title', 'Editar categoria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Editar categoria</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card" style="max-width:580px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                    @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="icon">Ícone Font Awesome</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                           placeholder="ex: fa-solid fa-microchip">
                    @error('icon') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
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
