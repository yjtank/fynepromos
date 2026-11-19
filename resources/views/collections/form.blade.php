<form method="POST" action="{{ $action }}" class="admin-form">
    @csrf
    @method($method)

    @php
        $selectedOfferIds = old('offer_ids', $collection?->offers->pluck('id')->all() ?? []);
        $selectedPositions = $collection
            ? $collection->offers->mapWithKeys(fn ($offer) => [$offer->id => $offer->pivot->position])->all()
            : [];
    @endphp

    <div class="form-field">
        <label for="name">Nome da coleção</label>
        <input id="name" name="name" value="{{ old('name', $collection?->name) }}" required autofocus placeholder="Ex.: Setup gamer completo">
        <p class="form-help">O endereço amigável será criado automaticamente.</p>
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div class="form-field">
        <label for="description">Descrição <span>opcional</span></label>
        <textarea id="description" name="description" rows="4" placeholder="Explique o tema desta seleção de produtos.">{{ old('description', $collection?->description) }}</textarea>
    </div>

    <div class="form-field">
        <label for="image_url">Imagem de capa <span>opcional</span></label>
        <input id="image_url" type="url" name="image_url" value="{{ old('image_url', $collection?->image_url) }}" placeholder="https://...">
        <x-input-error :messages="$errors->get('image_url')" />
    </div>

    <div class="form-toggle-grid">
        <label class="toggle-field">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $collection?->is_active ?? true))>
            <span class="toggle-control" aria-hidden="true"></span>
            <span><strong>Coleção ativa</strong><small>Fica disponível na área pública.</small></span>
        </label>
        <label class="toggle-field">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $collection?->is_featured))>
            <span class="toggle-control" aria-hidden="true"></span>
            <span><strong>Coleção em destaque</strong><small>Prioriza esta coleção nas listagens públicas.</small></span>
        </label>
    </div>

    <section class="collection-offers">
        <header>
            <h2>Produtos da coleção</h2>
            <p>Marque os produtos e informe a posição desejada.</p>
        </header>
        <x-input-error :messages="$errors->get('offer_ids')" />
        <div class="collection-offer-list">
            @forelse($offers as $offer)
                @php
                    $selected = in_array($offer->id, $selectedOfferIds);
                @endphp
                <label class="collection-offer-row">
                    <input type="checkbox" name="offer_ids[]" value="{{ $offer->id }}" @checked($selected)>
                    @if($offer->image_url)
                        <img src="{{ $offer->image_url }}" alt="">
                    @else
                        <span class="collection-offer-placeholder">{{ Str::upper(Str::substr($offer->title, 0, 1)) }}</span>
                    @endif
                    <span class="collection-offer-copy">
                        <strong>{{ $offer->title }}</strong>
                        <small>{{ $offer->store->name }} · R$ {{ number_format($offer->current_price, 2, ',', '.') }}</small>
                    </span>
                    <span class="collection-position">
                        <span>Posição</span>
                        <input type="number" min="1" name="offer_positions[{{ $offer->id }}]" value="{{ old('offer_positions.'.$offer->id, $selectedPositions[$offer->id] ?? 1) }}">
                    </span>
                </label>
            @empty
                <p class="collection-offers-empty">Cadastre promoções antes de montar uma coleção.</p>
            @endforelse
        </div>
    </section>

    <div class="admin-form-actions">
        <a href="{{ route('collections.index') }}" class="button button--quiet">Cancelar</a>
        <button class="button" type="submit">Salvar coleção</button>
    </div>
</form>
