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
            <div class="stat-value">{{ $publishedPosts }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Assinantes</div>
            <div class="stat-value">{{ $totalSubscribers }}</div>
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

    <div class="card">
        <div class="card-body">
            <div class="page-header" style="margin-bottom:16px;">
                <span style="font-weight:600;">Últimos posts</span>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Novo post
                </a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestPosts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category?->name ?? '—' }}</td>
                                <td>
                                    @if ($post->status === 'published')
                                        <span class="badge badge-green">publicado</span>
                                    @else
                                        <span class="badge badge-gray">rascunho</span>
                                    @endif
                                </td>
                                <td style="color:var(--muted);">{{ $post->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="color:var(--muted); text-align:center; padding:28px;">Nenhum post ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
