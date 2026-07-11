@extends('admin.layouts.app')

@section('title', 'Assinantes')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Assinantes</h1>
        <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.subscribers.index') }}"
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-ghost' }}">Todos</a>
            <a href="{{ route('admin.subscribers.index', ['status' => 'confirmed']) }}"
               class="btn btn-sm {{ request('status') === 'confirmed' ? 'btn-primary' : 'btn-ghost' }}">Confirmados</a>
            <a href="{{ route('admin.subscribers.index', ['status' => 'pending']) }}"
               class="btn btn-sm {{ request('status') === 'pending' ? 'btn-primary' : 'btn-ghost' }}">Pendentes</a>
        </div>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Status</th>
                        <th>IP</th>
                        <th>Inscrito em</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subscribers as $sub)
                        <tr>
                            <td style="font-weight:500;">{{ $sub->name }}</td>
                            <td style="color:var(--muted);">{{ $sub->email }}</td>
                            <td>
                                @if ($sub->status === 'confirmed')
                                    <span class="badge badge-green">confirmado</span>
                                @elseif ($sub->status === 'pending')
                                    <span class="badge badge-yellow">pendente</span>
                                @else
                                    <span class="badge badge-red">cancelado</span>
                                @endif
                            </td>
                            <td style="color:var(--muted); font-size:0.78rem;">{{ $sub->subscribe_ip ?? '—' }}</td>
                            <td style="color:var(--muted); white-space:nowrap;">{{ $sub->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.subscribers.destroy', $sub) }}"
                                      onsubmit="return confirm('Remover assinante?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:var(--muted); padding:32px;">
                                Nenhum assinante encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($subscribers->hasPages())
            <div class="card-body" style="border-top: 1px solid var(--border); padding-top:14px;">
                {{ $subscribers->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>
@endsection
