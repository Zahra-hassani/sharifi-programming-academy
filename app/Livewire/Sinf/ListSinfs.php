<?php

namespace App\Livewire\Sinf;

use App\Models\Sinf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListSinfs extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Sinf::query())
            ->columns([
                TextColumn::make('title')->label('Course Name')->searchable(),
                TextColumn::make('teacher.user.name')->label('Teacher Name'),
                TextColumn::make('start_date'),
                TextColumn::make('payments.student.user.name')->label('Students'),
                TextColumn::make('end_date')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('description')->limit(15),
            ])
            ->filters([
                Filter::make('start_date')->label('Filter by Start Date' )->form([DatePicker::make('start_date')->label('Start Date')])->query(function (Builder $query , array $data): Builder {
                    return $query->when(
                        $data['start_date']
                        ,fn(Builder $query,$date):Builder =>$query->whereDate('start_date',$date),
                        );
                }),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('delete')->requiresConfirmation()->action(fn (Sinf $record)=> $record->delete())->successNotification(
                    Notification::make()->title('Deleted successfully')->success()->send()
                ),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.sinf.list-sinfs');
    }
}
