<?php

namespace App\Livewire\Sinf;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Sinf;

class CreateSinf extends Component implements HasActions, HasSchemas
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
                Section::make("Create new Sinf")->columns(2)->description("Add new Sinf")->schema([
                    TextInput::make("title"),
                    DatePicker::make("start_date"),
                    DatePicker::make("end_date"),
                    Textarea::make("description"),
                    TextInput::make("teacher_id"),
                    FileUpload::make('banner_url')->directory('Sinfs')->disk('public'),
                ])
            ])
            ->statePath('data')
            ->model(Sinf::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Sinf::create($data);

        $this->form->model($record)->saveRelationships();
    }

    public function render(): View
    {
        return view('livewire.sinf.create-sinf');
    }
}
