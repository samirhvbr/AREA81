@extends('admin.layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Novo post
        </a>
    </div>

    <div class="card" style="border-radius: var(--radius-lg);">
        <div class="table-wrap" style="border-radius: var(--radius-md) var(--radius-md) 0 0; border: 1px solid var(--border); border-bottom: none;">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Destaque</th>
                        <th>Publicado em</th>
                        <th style="width: 120px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td style="max-width:300px;">
                                <span style="font-weight: 500; display: block;">{{ $post->title }}</span>
                                <span style="font-size: 0.7rem; color:var(--muted-dim); margin-top:3px; font-family: 'Courier New', monospace;">/blog/{{ $post->slug }}</span>
                            </td>
                            <td>{{ $post->category?->name ?? '—' }}</td>
                            <td>
                                @if ($post->status === 'published')
                                    <span class="badge badge-green"><i class="fa-solid fa-circle-check" style="margin-right:4px; font-size:0.6rem;"></i>publicado</span>
                                @else
                                    <span class="badge badge-gray">rascunho</span>
                                @endif
                            </td>
                            <td>
                                @if ($post->is_featured)
                                    <span class="badge badge-yellow"><i class="fa-solid fa-star" style="margin-right:4px; font-size:0.6rem;"></i>sim</span>
                                @else
                                    <span style="color:var(--muted-dim); font-size: 0.82rem;">—</span>
                                @endif
                            </td>
                            <td style="color:var(--muted-dim); white-space:nowrap; font-size: 0.83rem;">
                                {{ $post->published_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">
                                        <i class="fa-solid fa-pen"></i>
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
                            <td colspan="6" style="text-align:center; color:var(--muted-dim); padding:36px; font-size: 0.88rem;">
                                Nenhum post encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($posts->hasPages())
            <div class="card-body" style="border-top: 1px solid var(--border); padding-top:16px;">
                {{ $posts->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>
@endsection
