<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('settings.edit', [
            'settings' => SiteSetting::query()->firstOrCreate([], SiteSetting::defaults()),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = SiteSetting::query()->firstOrCreate([], SiteSetting::defaults());

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'footer_description' => ['required', 'string', 'max:255'],
            'whatsapp_url' => ['required', 'string', 'max:2048'],
            'instagram_url' => ['required', 'string', 'max:2048'],
        ]);

        foreach (['whatsapp_url', 'instagram_url'] as $field) {
            $this->validateExternalLink($field, $data[$field]);
        }

        $settings->update($data);

        return to_route('settings.edit')->with('status', 'Rodapé atualizado com sucesso.');
    }

    private function validateExternalLink(string $field, string $value): void
    {
        if ($value === '#') {
            return;
        }

        $scheme = parse_url($value, PHP_URL_SCHEME);

        if (! filter_var($value, FILTER_VALIDATE_URL) || ! in_array($scheme, ['http', 'https'], true)) {
            throw ValidationException::withMessages([
                $field => 'Informe uma URL iniciada com http:// ou https://, ou mantenha # enquanto o link não estiver pronto.',
            ]);
        }
    }
}
