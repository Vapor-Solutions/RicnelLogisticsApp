<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;

class Index extends Component
{
    public function delete($id)
    {

        if (!auth()->user()->hasPermissionTo('Delete Roles')) {
            $this->emit('done', [
                'error' => 'Wacha Ufala! You don\'t have the Authority to do that here'
            ]);
            return;
        }
        $role = Role::find($id);

        if (count($role->users) > 0) {
            $this->emit('done', [
                'error' => 'You Can\'t Delete this Role!Users Are attached!'
            ]);
            return;
        }


        if ($id == 1) {
            $this->emit('done', [
                'error' => 'You can\'t Delete this Role from the system.'
            ]);
            return;
        }

        $role->permissions()->detach();
        $role->delete();

        $this->emit('done', [
            'success' => 'Successfully Deleted that Role from the system'
        ]);
    }
    public function render()
    {
        return view('livewire.admin.roles.index', [
            'roles' => Role::with('permissions')->get()
        ]);
    }
}
