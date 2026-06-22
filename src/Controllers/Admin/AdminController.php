<?php

namespace Azuriom\Plugin\SkinApi\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\SkinApi\Render\AvatarRenderer;
use Azuriom\Plugin\SkinApi\SkinAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the skins admin page.
     */
    public function skins()
    {
        return view('skin-api::admin.skins', [
            'width' => setting('skin.width', 64),
            'height' => setting('skin.height', 64),
            'scale' => setting('skin.scale', 1),
            'notFound' => setting('skin.not_found_handling'),
            'defaultSkin' => SkinAPI::defaultSkin(),
        ]);
    }

    /**
     * Show the capes admin page.
     */
    public function capes()
    {
        return view('skin-api::admin.capes', [
            'enable' => setting('skin.capes.enable', false),
            'width' => setting('skin.capes.width', 64),
            'height' => setting('skin.capes.height', 32),
            'scale' => setting('skin.capes.scale', 1),
            'defaultCapeEnabled' => setting('skin.capes.default.enable', false),
            'defaultCape' => SkinAPI::defaultCape(),
        ]);
    }

    public function updateSkins(Request $request)
    {
        $settings = $this->validate($request, [
            'height' => 'required|integer|min:0',
            'width' => 'required|integer|min:0',
            'scale' => 'required|integer|min:0',
            'skin' => 'nullable|file|mimes:png',
            'not_found_handling' => 'required|in:default_skin,404_status',
        ]);

        $settings = Arr::except($settings, 'skin');

        if ($request->hasFile('skin')) {
            $request->file('skin')->storeAs('skins', 'default.png', 'public');

            AvatarRenderer::renderAll(Storage::disk('public')->path('skins/default.png'), 'default.png');
        }

        Setting::updateSettings(Arr::prependKeysWith($settings, 'skin.'));

        return redirect()->route('skin-api.admin.skins')
            ->with('success', trans('admin.settings.updated'));
    }

    public function updateCapes(Request $request)
    {
        $settings = $this->validate($request, [
            'height' => 'required|integer|min:0',
            'width' => 'required|integer|min:0',
            'scale' => 'required|integer|min:0',
            'default_cape' => ['nullable', 'mimes:png'],
        ]);

        $settings = Arr::except($settings, 'default_cape');
        $settings['enable'] = $request->boolean('enable');
        $settings['default.enable'] = $request->boolean('default_enable');

        if ($request->hasFile('default_cape')) {
            $request->file('default_cape')->storeAs('skins/capes', 'default.png', 'public');
        }

        Setting::updateSettings(Arr::prependKeysWith($settings, 'skin.capes.'));

        return redirect()->route('skin-api.admin.capes')
            ->with('success', trans('admin.settings.updated'));
    }
}
