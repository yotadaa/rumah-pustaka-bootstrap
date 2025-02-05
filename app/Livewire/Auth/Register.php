<?php

namespace App\Livewire\Auth;
use Livewire\Component;

use App\Models\Role;
use App\Models\User;
use App\Models\UserAccess;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class Register extends Component
{
    public $email;
    public $password;
    public $password_confirmation;

    //form
    public $formRole;
    public $roles;
    public $selectedRoles = [];
    public $allRole = false;

    public function toggleAllRole()
    {
        $this->allRole = !$this->allRole;
    }

    public function toggleRole($id)
    {
        if (in_array($id, $this->selectedRoles)) {
            $this->selectedRoles = array_diff($this->selectedRoles, [$id]);
        } else {
            $this->selectedRoles[] = $id;
        }
    }

    public function register()
    {
        $this->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'selectedRoles.*' => 'integer',
        ]);

        $dataUser = [
            'name' => '',
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'pangkat' => 1,
        ];

        $user = User::create($dataUser);

        if (!$this->allRole) {
            foreach ($this->selectedRoles as $roleId) {
                if ($this->roles->contains('id', $roleId)) {
                    UserAccess::create([
                        'role_id' => $roleId,
                        'user_id' => $user->id,
                    ]);
                }
            }
        } else {
            foreach ($this->roles as $role) {
                UserAccess::create([
                    'role_id' => $role['id'],
                    'user_id' => $user->id,
                ]);
            }
        }

        $this->resetErrorBag();

        // Redirect to login page
        return redirect()->back();
    }

    public function render()
    {
        $this->roles = Role::all();
        return view('livewire.auth.register');
    }
}
