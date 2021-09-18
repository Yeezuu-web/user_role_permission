<?php

namespace App\Http\Controllers\Auth;

use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ChangePasswordController extends Controller
{
    use MediaUploadingTrait;
    
    public function edit()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('auth.passwords.edit');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return redirect()->route('profile.password.edit')->with('message', __('global.change_password_success'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        if ($request->input('profile', false)) {
            if (!$user->profile || $request->input('profile') !== $user->profile->file_name) {
                if ($user->profile) {
                    $user->profile->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
            }
        } elseif ($user->profile) {
            $user->profile->delete();
        }

        return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('leave_info_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}