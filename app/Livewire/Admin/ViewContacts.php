<?php

namespace App\Livewire\Admin;

use App\Models\ContactSubmission;
use Livewire\Component;

class ViewContacts extends Component
{
    public $contacts;
    public $selectedContact = null;

    public function mount()
    {
        $this->loadContacts();
    }

    public function loadContacts()
    {
        $this->contacts = ContactSubmission::orderBy('created_at', 'desc')->get();
    }

    public function viewContact($id)
    {
        $this->selectedContact = ContactSubmission::findOrFail($id);
        
        // Mark as read
        if (!$this->selectedContact->is_read) {
            $this->selectedContact->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            $this->loadContacts();
        }
    }

    public function closeModal()
    {
        $this->selectedContact = null;
    }

    public function delete($id)
    {
        ContactSubmission::findOrFail($id)->delete();
        session()->flash('message', 'Contact submission deleted successfully!');
        $this->loadContacts();
        $this->selectedContact = null;
    }

    public function markAsUnread($id)
    {
        ContactSubmission::findOrFail($id)->update([
            'is_read' => false,
            'read_at' => null,
        ]);
        $this->loadContacts();
    }

    public function render()
    {
        return view('livewire.admin.view-contacts');
    }
}
