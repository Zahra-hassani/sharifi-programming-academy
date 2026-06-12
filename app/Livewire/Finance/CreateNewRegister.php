<?php

namespace App\Livewire\Finance;

use App\Models\Sinf;
use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateNewRegister extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Take new class')->description('Register for new class')->schema([
                Select::make("student_id")->label("Student Name")->options(User::where("role","student")->pluck('name','id'))->searchable(),
                Select::make('sinf_id')->label('Class')->options(Sinf::query()->pluck('title','id'))->searchable(),
                TextInput::make('amount')->type('number'),
                ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        //
    }

    public function render(): View
    {
        return view('livewire.finance.create-new-register');
    }
}
