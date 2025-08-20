<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SidebarNotifications extends Component
{
    public $unreadCount = 0;

    protected $listeners = ['notificationAdded' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    public function render()
    {
        $this->updateCount();
        return view('livewire.sidebar.sidebar-notifications');
    }
}
