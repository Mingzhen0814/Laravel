<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 判斷使用者是否有上傳圖片，並做對應處理(是: 傳入圖片 / 否: 保留原有的圖片)
        $validated = $request->validated();
        if (isset($request->image)){
            $data = $request->image->get();
            $mime_type = $request->image->getMimeType(); // 假設使用者上傳的是jpg就會回傳"image/jpeg"
            $imageData = base64_encode($data);
            $src = "data: $mime_type;base64,$imageData"; // <img>要求的格式data: $mime_type;base64,(一定要這樣打)
            $validated["image"] = $src; // 補上rules的JSON，不寫在rules是不要寫死，使其能動態上傳
        }
        $request->user()->fill($validated); 
        // validate()會以JSON回傳requests的rules()的key
        // fill會參考models的$fillable對應到JSON的值就會填入到資料庫
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
