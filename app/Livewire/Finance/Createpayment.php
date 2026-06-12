<?php

namespace App\Livewire\Finance;

use App\Models\Sinf;
use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Createpayment extends Component implements HasActions, HasSchemas
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
                Wizard::make([
                    Step::make('User')->completedIcon(Heroicon::CheckBadge)->icon(Heroicon::UserCircle)->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->required()->type('email'),
                        TextInput::make('password')->required()->type('password'),
                    ]),
                    Step::make('Student')->completedIcon(Heroicon::CheckBadge)->icon(Heroicon::AcademicCap)->schema([
                        TextInput::make('last_name')->required(),
                        TextInput::make('phone_number'),
                        TextInput::make('tazkira_no')->required()->label('Id Card'),
                        FileUpload::make('image_url')->directory('student_images')->disk ('public')
                    ]),
                    Step::make('Payment')->completedIcon(Heroicon::CheckBadge)->icon(Heroicon::Banknotes)->schema([
                        TextInput::make('amount')->type('number'),
                        Select::make('sinf_id')->label('Sinf Name')->options(Sinf::query()->pluck('title','id')),
                    ])
                ])->submitAction(new HtmlString('<button type="submit">Save</button>'))
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'=> $data['name'],
                'email'=> $data['email'],
                'password'=> bcrypt($data['password']),
                'role' => "student"
            ]);
            $student = $user->student()->create([
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'tazkira_no' => $data['tazkira_no'],
                'image_url' => $data['image_url'],
            ]);
            $student->payments()->create([
                'amount' => $data['amount'],
                'sinf_id' => $data['sinf_id'],
            ]);
            return redirect()->route('payment.index');
        });
    }

    public function render(): View
    {
        return view('livewire.finance.createpayment');
    }
}
