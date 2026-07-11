@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Posts totais</div>
            <div class="stat-value">{{ $totalPosts }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Publicados</div>
            <div class="stat-value" style="color: #4ade80;">{{ $publishedPosts }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Assinantes</div>
            <div class="stat-value" style="color: #818cf8;">{{ $totalSubscribers }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Categorias</div>
            <div class="stat-value">{{ $totalCategories }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tags</div>
            <div class="stat-value">{{ $totalTags }}</div>
        </div>
    </div>

    <div class="card" style="border-radius: var(--radius-lg);">
        <div class="card-body">
            <div class="page-header" style="margin-bottom: 20px;">
                <span style="font-weight: 600; font-size: 0.95rem;">Últimos posts</span>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Novo post
                </a>
            </div>
            <div class="table-wrap" style="border-radius: var(--radius-md); border: 1px solid var(--border);">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th style="width: 80px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestPosts as $post)
                            <tr>
                                <td>
                                    <span style="font-weight: 500; display: block;">{{ $post->title }}</span>
                                    <span style="font-size: 0.72rem; color: var(--muted-dim); margin-top: 2px; font-family: 'Courier New', monospace;">/blog/{{ $post->slug }}</span>
                                </td>
                                <td>{{ $post->category?->name ?? '—' }}</td>
                                <td>
                                    @if ($post->status === 'published')
                                        <span class="badge badge-green"><i class="fa-solid fa-circle-check" style="margin-right: 4px; font-size: 0.6rem;"></i>publicado</span>
                                    @else
                                        <span class="badge badge-gray">rascunho</span>
                                    @endif
                                </td>
                                <td style="color:var(--muted-dim); white-space: nowrap; font-size: 0.83rem;">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm" style="padding: 5px 10px;">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; color:var(--muted-dim); padding:32px; font-size: 0.88rem;">Nenhum post ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
