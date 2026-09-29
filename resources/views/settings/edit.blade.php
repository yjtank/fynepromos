<x-app-layout>
    <x-slot name="title">Rodapé e links</x-slot>
    <x-slot name="header"><div><div><span class="section-kicker">Personalização</span><h1>Rodapé e links</h1></div></div></x-slot>

    <section class="admin-form-shell settings-editor">
        <header><h2>Informações do site</h2><p>Defina o conteúdo que aparece no rodapé público.</p></header>
        @if(session('status'))<div class="admin-notice is-success">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('settings.update') }}" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-field"><label for="site_name">Nome do site</label><input id="site_name" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required maxlength="80">@error('site_name')<p class="form-help is-error">{{ $message }}</p>@enderror</div>
            <div class="form-field"><label for="footer_description">Descrição do rodapé</label><textarea id="footer_description" name="footer_description" required maxlength="255">{{ old('footer_description', $settings->footer_description) }}</textarea><p class="form-help">Uma apresentação curta para o rodapé.</p>@error('footer_description')<p class="form-help is-error">{{ $message }}</p>@enderror</div>
            <div class="form-two-columns">
                <div class="form-field"><label for="whatsapp_url">Link do WhatsApp</label><input id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', $settings->whatsapp_url) }}" required maxlength="2048" placeholder="# ou https://wa.me/...">@error('whatsapp_url')<p class="form-help is-error">{{ $message }}</p>@enderror</div>
                <div class="form-field"><label for="instagram_url">Link do Instagram</label><input id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}" required maxlength="2048" placeholder="# ou https://instagram.com/...">@error('instagram_url')<p class="form-help is-error">{{ $message }}</p>@enderror</div>
            </div>
            <div class="admin-form-actions"><button class="button" type="submit">Salvar rodapé</button></div>
        </form>
    </section>
</x-app-layout>
