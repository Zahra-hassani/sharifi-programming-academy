<?php

namespace App\Livewire\Finance;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Payment;

class ListPayment extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Payment::query())
            ->columns([
                TextColumn::make("student.user.name")->label('Student Name'),
                TextColumn::make("sinf.title"),
                TextColumn::make("amount"),
                TextColumn::make("created_at")->label("Date"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make("create payment")->url(route('payment.create'))->color('info'),
            ])
            ->recordActions([
                Action::make('delete')->action(fn (Payment $record) => $record->delete($record->id))->color('danger')->badge()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.finance.list-payment');
    }
}
