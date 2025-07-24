<?php

namespace App\View\Components\ModalCreateEvent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateEvent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-create-event.create-event');
    }
}
