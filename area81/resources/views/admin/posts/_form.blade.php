{{-- Partial compartilhado por create e edit de posts --}}
<div class="form-group">
    <label for="title">Título *</label>
    <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}" required>
    @error('title') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug ?? '') }}"
               placeholder="gerado automaticamente pelo título">
        @error('slug') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="reading_time">Tempo de leitura (min)</label>
        <input type="number" id="reading_time" name="reading_time" min="1" max="999"
               value="{{ old('reading_time', $post->reading_time ?? '') }}">
        @error('reading_time') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <label for="excerpt">Resumo</label>
    <textarea id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    @error('excerpt') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-group">
    <label for="content">Conteúdo HTML *</label>
    <textarea id="content" name="content" rows="16" required
              style="font-family: 'Courier New', monospace; font-size:0.82rem;">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <div class="field-error">{{ $message }}</div> @enderror
</div>

<div class="form-row">
    <div class="form-group">
        <label for="category_id">Categoria</label>
        <select id="category_id" name="category_id">
            <option value="">— sem categoria —</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="tags">Tags <span style="color:var(--muted); font-weight:400;">(Ctrl/Cmd para múltiplas)</span></label>
        <select id="tags" name="tags[]" multiple>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}"
                    {{ in_array($tag->id, old('tags', $postTags ?? [])) ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        @error('tags') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="status">Status *</label>
        <select id="status" name="status" required>
            <option value="draft"      {{ old('status', $post->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Rascunho</option>
            <option value="published"  {{ old('status', $post->status ?? '')      === 'published' ? 'selected' : '' }}>Publicado</option>
        </select>
        @error('status') <div class="field-error">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="published_at">Data de publicação</label>
        <input type="datetime-local" id="published_at" name="published_at"
               value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
        @error('published_at') <div class="field-error">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-group">
    <div class="form-check">
        <input type="checkbox" id="is_featured" name="is_featured" value="1"
               {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }}>
        <label for="is_featured">Destaque na home</label>
    </div>
</div>
