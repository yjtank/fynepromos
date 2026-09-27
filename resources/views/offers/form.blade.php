<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="admin-form offer-form">
    @csrf
    @method($method)

    <div class="offer-form-grid">
        <section class="offer-form-section">
            <header><h2>Informações da promoção</h2><p>Os dados que aparecem na vitrine e na página do produto.</p></header>
            <div class="form-field"><label for="title">Título</label><input id="title" name="title" value="{{ old('title', $offer?->title) }}" required autofocus placeholder="Ex.: Headset sem fio com cancelamento de ruído"><x-input-error :messages="$errors->get('title')" /></div>
            <div class="form-two-columns">
                <div class="form-field"><label for="category_id">Categoria</label><select id="category_id" name="category_id" required><option value="">Selecione uma categoria</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $offer?->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select><x-input-error :messages="$errors->get('category_id')" /></div>
                <div class="form-field"><label for="store_id">Loja</label><select id="store_id" name="store_id" required><option value="">Selecione uma loja</option>@foreach($stores as $store)<option value="{{ $store->id }}" @selected(old('store_id', $offer?->store_id) == $store->id)>{{ $store->name }}</option>@endforeach</select><x-input-error :messages="$errors->get('store_id')" /></div>
            </div>
            <div class="form-field"><label for="description">Descrição <span>opcional</span></label><textarea id="description" name="description" rows="5" placeholder="Destaque os detalhes mais importantes do produto.">{{ old('description', $offer?->description) }}</textarea><x-input-error :messages="$errors->get('description')" /></div>
        </section>

        <section class="offer-form-section">
            <header><h2>Preço e condições</h2><p>Informe o valor atual e as condições da promoção.</p></header>
            <div class="form-two-columns"><div class="form-field"><label for="current_price">Preço atual</label><input id="current_price" type="number" step="0.01" min="0" name="current_price" value="{{ old('current_price', $offer?->current_price) }}" required placeholder="0,00"><x-input-error :messages="$errors->get('current_price')" /></div><div class="form-field"><label for="old_price">Preço anterior <span>opcional</span></label><input id="old_price" type="number" step="0.01" min="0" name="old_price" value="{{ old('old_price', $offer?->old_price) }}" placeholder="0,00"><x-input-error :messages="$errors->get('old_price')" /></div></div>
            <div class="form-two-columns"><div class="form-field"><label for="installment_info">Parcelamento <span>opcional</span></label><input id="installment_info" name="installment_info" value="{{ old('installment_info', $offer?->installment_info) }}" placeholder="Ex.: 12x sem juros"></div><div class="form-field"><label for="coupon">Cupom <span>opcional</span></label><input id="coupon" name="coupon" value="{{ old('coupon', $offer?->coupon) }}" placeholder="Ex.: PROMO10"></div></div>
            <div class="form-field"><label for="purchase_url">Link de compra</label><input id="purchase_url" type="url" name="purchase_url" value="{{ old('purchase_url', $offer?->purchase_url) }}" required placeholder="https://..."><x-input-error :messages="$errors->get('purchase_url')" /></div>
            <div class="form-field form-field--compact"><label for="expires_at">Validade <span>opcional</span></label><input id="expires_at" type="datetime-local" name="expires_at" value="{{ old('expires_at', $offer?->expires_at?->format('Y-m-d\\TH:i')) }}"></div>
        </section>

        <section class="offer-form-section">
            <header><h2>Imagem</h2><p>Adicione uma imagem apenas se ela estiver disponível.</p></header>
            @if($offer?->image_url)<div class="offer-form-preview"><img src="{{ $offer->image_url }}" alt="Imagem atual da promoção"><span>Imagem atual</span></div>@endif
            <div class="form-two-columns"><div class="form-field"><label for="image_file">Enviar arquivo</label><input id="image_file" type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/avif"><p class="form-help">JPG, PNG, WebP ou AVIF de até 4 MB.</p><x-input-error :messages="$errors->get('image_file')" /></div><div class="form-field"><label for="image_url">Usar URL externa <span>opcional</span></label><input id="image_url" type="url" name="image_url" value="{{ old('image_url', $offer?->image_url && Str::startsWith($offer->image_url, ['http://', 'https://']) ? $offer->image_url : '') }}" placeholder="https://..."><p class="form-help">O arquivo enviado tem prioridade sobre a URL.</p><x-input-error :messages="$errors->get('image_url')" /></div></div>
        </section>

        <section class="offer-form-section offer-form-section--toggles">
            <header><h2>Publicação</h2><p>Controle como a promoção aparece no site.</p></header>
            <div class="form-toggle-grid"><label class="toggle-field"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $offer?->is_active ?? true))><span class="toggle-control" aria-hidden="true"></span><span><strong>Promoção ativa</strong><small>Fica visível na vitrine pública enquanto estiver válida.</small></span></label><label class="toggle-field"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $offer?->is_featured))><span class="toggle-control" aria-hidden="true"></span><span><strong>Exibir em destaques</strong><small>Também aparecerá na seção de promoções em destaque.</small></span></label></div>
        </section>
    </div>

    <div class="admin-form-actions"><a href="{{ route('offers.index') }}" class="button button--quiet">Cancelar</a><button class="button" type="submit">{{ $offer ? 'Salvar alterações' : 'Publicar promoção' }}</button></div>
</form>
