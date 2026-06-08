<?php

namespace App\Livewire\Sinf;

use App\Models\Teacher;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Sinf;

class EditSinf extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Sinf $record;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Class Update Form')->description('Update Class Information')->columns(2)->schema([
                    TextInput::make('title')->required()->label('Course Name'),
                    Select::make('teacher_id')->options(Teacher::query()->pluck('last_name','id'))->label('Teacher'),
                    DatePicker::make('start_date')->format('Y-m-d')->native(true)->locale('fa'),
                    DatePicker::make('end_date')->format('Y-m-d')->native(true)->locale('fa'),
                    Textarea::make('description'),
                    FileUpload::make('banner_url')->directory('Sinfs')->visibility('public')
                ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update($data);
    }

    public function render(): View
    {
        return view('livewire.sinf.edit-sinf');
    }
}
