@extends('admin.layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Categorias</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nova categoria
        </a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Ícone</th>
                        <th>Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr>
                            <td style="font-weight:500;">{{ $cat->name }}</td>
                            <td style="color:var(--muted); font-family:'Courier New',monospace; font-size:0.8rem;">{{ $cat->slug }}</td>
                            <td style="color:var(--muted);">{{ $cat->icon ?? '—' }}</td>
                            <td><span class="badge badge-blue">{{ $cat->posts_count }}</span></td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-ghost btn-sm">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                          onsubmit="return confirm('Remover categoria?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:var(--muted); padding:32px;">
                                Nenhuma categoria cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
