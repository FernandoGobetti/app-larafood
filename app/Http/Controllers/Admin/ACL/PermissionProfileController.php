<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{
    protected $profile, $permission;

    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;
    }

    public function permissions($idProfile)
    {
        $profile = $this->profile->find($idProfile);
        if (!$profile)
            return redirect()->back();

        return view('admin.pages.profiles.permissions.permissions', [
            'permissions' => $profile->permissions()->paginate(),
            'profile' => $profile
        ]);
    }

    public function permissionsAvailable(Request $request, $idProfile)
    {
        $profile = $this->profile->find($idProfile);
        if (!$profile)
            return redirect()->back();

        $filters = $request->except('_token');

        $permissions = $profile->permissionsAvailable($request->filter);

        return view('admin.pages.profiles.permissions.available', [
            'permissions' => $permissions,
            'profile' => $profile,
            'filters' => $filters
        ]);
    }

    public function attachPermissionsProfile(Request $request, $idProfile)
    {
        $profile = $this->profile->find($idProfile);
        if (!$profile)
            return redirect()->back();

        $profile->permissions()->attach($request->permissions);

        return redirect()->route('profiles.permissions', $profile->id);
    }

    public function detachPermissionProfile($idProfile, $idPermission)
    {

        $profile = $this->profile->find($idProfile);
        $permission = $this->permission->find($idPermission);

        if (!$profile || !$permission)
            return redirect()->back();

        $profile->permissions()->detach($permission);

        return redirect()->route('profiles.permissions', $profile->id);
    }

    public function profiles($idPermission)
    {
        $permission = $this->permission->find($idPermission);
        if (!$permission)
            return redirect()->back();

        return view('admin.pages.permissions.profiles.profiles', [
            'permission' => $permission,
            'profiles' => $permission->profiles()->paginate()
        ]);
    }
}
