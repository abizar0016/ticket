<?php 

namespace App\Services\Users;

use App\Actions\Users\UpdateUser;
use App\Actions\Users\DestroyUser;
use Illuminate\Http\Request;

class UserService
{
    public function update(Request $request, $id)
    {
        return (new UpdateUser)->handle($request, $id);
    }

    public function destroy($id)
    {
        return (new DestroyUser)->handle($id);
    }
}