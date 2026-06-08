<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListStudents extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Student::query())
            ->columns([
                TextColumn::make('user.name')->searchable()->label('Name'),
                TextColumn::make('user.email')->label('email'),
                TextColumn::make('last_name'),
                TextColumn::make('payments.sinf.title')->badge()->listWithLineBreaks(),
                ImageColumn::make('image_url'),
                TextColumn::make('phone_number')->toggleable(isToggledHiddenByDefault:false),
                TextColumn::make('tazkira_no')->toggleable(isToggledHiddenByDefault:true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('edit')->url(fn (Student $record):string => route('student.edit',$record->id))->openUrlInNewTab(),
                Action::make('delete')->action(fn (Student $record) => $record->delete($record->id))->color('danger')->badge()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.student.list-students');
    }
}
