<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class SetPassword extends Component
{
    public $slug;
    public $email = '';
    public $temp_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'temp_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->temp_password, $user->password)) {
            $this->addError('temp_password', 'Invalid credentials');
            return;
        }

        $user->update(['password' => Hash::make($this->new_password)]);

        return redirect()->route('success', ['slug' => $this->slug]);
    }

    public function render()
    {
        return view('livewire.set-password');
    }
}
