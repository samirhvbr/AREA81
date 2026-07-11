@extends('admin.layouts.app')

@section('title', 'Nova categoria')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Nova categoria</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card" style="max-width:580px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                           placeholder="gerado automaticamente pelo nome">
                    @error('slug') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="icon">Ícone Font Awesome</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon') }}"
                           placeholder="ex: fa-solid fa-microchip">
                    @error('icon') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
