<form method="POST" action="{{ $action }}" class="admin-form">
    @csrf
    @method($method)

    <div class="form-field"><label for="name">Nome da loja</label><input id="name" name="name" value="{{ old('name', $store?->name) }}" required autofocus placeholder="Ex.: Amazon"><x-input-error :messages="$errors->get('name')" /></div>
    <div class="form-field"><label for="website">Site da loja <span>opcional</span></label><input id="website" name="website" type="url" value="{{ old('website', $store?->website) }}" placeholder="https://..."><x-input-error :messages="$errors->get('website')" /></div>
    <label class="toggle-field"><input type="checkbox" name="active" value="1" @checked(old('active', $store?->active ?? true))><span class="toggle-control" aria-hidden="true"></span><span><strong>Loja ativa</strong><small>Ela poderá ser escolhida ao cadastrar promoções.</small></span></label>
    <div class="admin-form-actions"><a href="{{ route('stores.index') }}" class="button button--quiet">Cancelar</a><button class="button" type="submit">Salvar loja</button></div>
</form>
