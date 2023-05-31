<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateSymmetricKeyComponents;
use App\Http\Controllers\Controller;
use App\Models\SymmetricKey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SymmetricKeyComponentController extends Controller
{
    public function update(int $key): RedirectResponse
    {
        $symmetricKey = SymmetricKey::where('user_id', Auth::id())
            ->where('id', $key)
            ->with('components:id,component,kcv,symmetric_key_id')
            ->firstOrFail(['id', 'key', 'kcv', 'cryptogram', 'transport_key_kcv']);

        $symmetricKey->components()->delete();

        CreateSymmetricKeyComponents::execute($symmetricKey);

        flash('The transport key was updated successful')->success();

        return redirect()->route('admin.symmetrics.show', $symmetricKey);
    }
}
