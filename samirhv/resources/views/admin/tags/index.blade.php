@extends('admin.layouts.app')

@section('title', 'Tags')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Tags</h1>
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nova tag
        </a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tags as $tag)
                        <tr>
                            <td style="font-weight:500;">{{ $tag->name }}</td>
                            <td style="color:var(--muted); font-family:'Courier New',monospace; font-size:0.8rem;">{{ $tag->slug }}</td>
                            <td><span class="badge badge-blue">{{ $tag->posts_count }}</span></td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-ghost btn-sm">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                                          onsubmit="return confirm('Remover tag?')">
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
                            <td colspan="4" style="text-align:center; color:var(--muted); padding:32px;">
                                Nenhuma tag cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
