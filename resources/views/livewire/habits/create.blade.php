<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use App\Models\Habit;

new class extends Component {
    public Habit $habit;

    #[Validate('required|string|max:255')]
    public string $name;

    #[Validate('required')]
    public $type;

    public function store() 
    {
        $validated = $this->validate();
        $validated['active'] = 1;

        auth()->user()->habits()->create($validated); 
        $this->name = '';
        $this->type = null;      
        $this->dispatch('habit-created');
    }

}; ?>

<div class="basis-1/4 mx-auto p-6 bg-white shadow-sm rounded-lg divide-y dark:bg-gray-700 dark:text-white">
    <form wire:submit="store"> 
    <div class="flex flex-col">
        <div class="flex-col justify-between items-center mx-auto my-auto">
            <div class="flex-col py-2 basis-1/2 mx-auto my-auto">
                <h3 class="basis-1/2 text-lg ">Create a New Habit:</h3>
            </div>
            <div class="flex-col py-2 basis-1/2 mx-auto my-auto">
                <label for="name" class=" ">Habit Name:</label>
                <input wire:model="name" id="name" type="text" class="bg-white shadow-sm rounded-lg divide-y dark:bg-gray-700 dark:text-white" aria-label="Habit Name" placeholder="Habit Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="flex-col py-2 basis-1/2 mx-auto my-auto">
                <div class="basis-1/2 mx-auto my-auto">
                    <input type="radio" class="dark:bg-gray-800" aria-label="Checkbox Count" id="CHECK" name="type" wire:model="type" value="Check" />
                    <label for="CHECK" class="mt-6">Checkbox style counts</label>
                </div>
                <div class="basis-1/2 mx-auto my-auto">
                    <input type="radio" class="dark:bg-gray-800" aria-label="Numeric Count" id="NUMBER" name="type" wire:model="type" value="Number" />
                    <label for="NUMBER" class="mt-6">Numeric style counts</label>
                </div>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>
            <x-primary-button class="py-2 mt-4 dark:bg-gray-800 dark:text-white" aria-label="Submit">Submit</x-primary-button> 
        </div>
    </div>
    @env('local')
        <p>{{print_r($errors)}}</p>
    @endenv
    </form> 
</div>