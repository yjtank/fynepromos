<form method="POST" action="{{ $action }}" class="admin-form">
    @csrf
    @method($method)

    <div class="form-field">
        <label for="name">Nome da categoria</label>
        <input id="name" name="name" value="{{ old('name', $category?->name) }}" required autofocus placeholder="Ex.: Notebooks">
        <p class="form-help">O endereço amigável será criado automaticamente.</p>
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <label class="toggle-field">
        <input type="checkbox" name="active" value="1" @checked(old('active', $category?->active ?? true))>
        <span class="toggle-control" aria-hidden="true"></span>
        <span><strong>Categoria ativa</strong><small>Ela ficará disponível para seleção e no catálogo público.</small></span>
    </label>

    <div class="admin-form-actions">
        <a href="{{ route('categories.index') }}" class="button button--quiet">Cancelar</a>
        <button class="button" type="submit">Salvar categoria</button>
    </div>
</form>
