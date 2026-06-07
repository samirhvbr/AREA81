@extends('admin.layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Novo post
        </a>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Destaque</th>
                        <th>Publicado em</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td style="max-width:280px;">
                                <span style="font-weight:500;">{{ $post->title }}</span>
                                <div style="font-size:0.72rem; color:var(--muted); margin-top:2px;">/blog/{{ $post->slug }}</div>
                            </td>
                            <td>{{ $post->category?->name ?? '—' }}</td>
                            <td>
                                @if ($post->status === 'published')
                                    <span class="badge badge-green">publicado</span>
                                @else
                                    <span class="badge badge-gray">rascunho</span>
                                @endif
                            </td>
                            <td>
                                @if ($post->is_featured)
                                    <span class="badge badge-yellow">sim</span>
                                @else
                                    <span style="color:var(--muted);">—</span>
                                @endif
                            </td>
                            <td style="color:var(--muted); white-space:nowrap;">
                                {{ $post->published_at?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                          onsubmit="return confirm('Remover este post?')">
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
                            <td colspan="6" style="text-align:center; color:var(--muted); padding:32px;">
                                Nenhum post encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($posts->hasPages())
            <div class="card-body" style="border-top: 1px solid var(--border); padding-top:14px;">
                {{ $posts->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>
@endsection
