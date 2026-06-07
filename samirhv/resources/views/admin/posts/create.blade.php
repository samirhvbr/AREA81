@extends('admin.layouts.app')

@section('title', 'Novo post')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Novo post</h1>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-ghost">
            <i class="fa-solid fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.posts.store') }}">
                @csrf
                @include('admin.posts._form', ['post' => null, 'postTags' => []])
                <div style="display:flex; justify-content:flex-end; margin-top:8px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Salvar post
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
