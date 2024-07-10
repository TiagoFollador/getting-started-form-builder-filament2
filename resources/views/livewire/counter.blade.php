<?php
 
use Livewire\Volt\Component;
 
new class extends Component
{
    public int $count = 0;
 
    public function increment(): void
    {
        $this->count++;
    }
}; ?>
 
<div>
    <h1>{{ $count }}</h1>
    <button wire:click="increment">+</button>
</div>