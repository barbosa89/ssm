<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateSymmetricKeyComponents;
use App\Constants\Bits;
use App\Constants\SymmetricKeyTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrUpdateSymmetricKeyRequest;
use App\Models\SymmetricKey;
use App\Util\KeyGenerator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SymmetricKeyController extends Controller
{
    public function index(): View
    {
        $keys = SymmetricKey::whereBelongsTo(Auth::user())
            ->latest('id')
            ->paginate(15, ['id', 'description', 'type', 'bits', 'created_at']);

        return view('admin.symmetric_keys.index', compact('keys'));
    }

    public function create(): View
    {
        return view('admin.symmetric_keys.create');
    }

    public function store(StoreOrUpdateSymmetricKeyRequest $request): RedirectResponse
    {
        $symmetricKey = new SymmetricKey();
        $symmetricKey->description = $request->string('description');
        $symmetricKey->type = SymmetricKeyTypes::TripleDES->name;
        $symmetricKey->bits = Bits::Medium->value;
        $symmetricKey->key = KeyGenerator::make(Bits::Medium)->toBase64();
        $symmetricKey->user()->associate(Auth::user());

        CreateSymmetricKeyComponents::execute($symmetricKey);

        flash('Symmetric key was created successful')->success();

        return redirect()->route('admin.symmetrics.show', $symmetricKey);
    }

    public function show(int $key): View
    {
        $symmetricKey = SymmetricKey::where('user_id', Auth::id())
            ->where('id', $key)
            ->with('components:id,component,kcv,symmetric_key_id')
            ->firstOrFail(['id', 'description', 'key', 'type', 'bits', 'kcv', 'cryptogram', 'transport_key_kcv']);

        return view('admin.symmetric_keys.show', compact('symmetricKey'));
    }

    public function edit(int $key): View
    {
        $symmetricKey = SymmetricKey::where('user_id', Auth::id())
            ->where('id', $key)
            ->firstOrFail(['id', 'description']);

        return view('admin.symmetric_keys.edit', compact('symmetricKey'));
    }

    public function update(StoreOrUpdateSymmetricKeyRequest $request, int $key): RedirectResponse
    {
        $symmetricKey = SymmetricKey::where('user_id', Auth::id())
            ->where('id', $key)
            ->firstOrFail(['id', 'description']);

        $symmetricKey->description = $request->string('description');
        $symmetricKey->save();

        flash('Symmetric key was updated successful')->success();

        return redirect()->route('admin.symmetrics.show', $symmetricKey);
    }

    public function destroy(int $key): RedirectResponse
    {
        SymmetricKey::where('user_id', Auth::id())
            ->where('id', $key)
            ->delete();

        flash('Symmetric key was deleted successful')->success();

        return redirect()->route('admin.symmetrics.index');
    }
}
