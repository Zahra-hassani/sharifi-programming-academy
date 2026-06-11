<?php

namespace App\Livewire\Teacher;

use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class CreateTeacher extends Component implements HasActions, HasSchemas
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
                    Step::make('User')->schema([
                        TextInput::make('name'),
                        TextInput::make('email')->required(),
                        TextInput::make('password')->required(),
                    ]),
                    Step::make('Teacher')->columns(2)->schema([
                        TextInput::make('last_name')->required(),
                        Select::make('degree_of_education')->options([
                            "secondary school" => "Secondary School Diploma",
                            "bachelor" => "Bachelor Degree",
                            "master" => "Master Degree",
                            "PHD" => "PHD",
                        ]),
                        Select::make("field_of_education")->options([
                            "computer science"=> "Computer Science",
                            "political science"=> "Political Science",
                            "Ecommerce"=> "Ecommerce",
                            "English Literature"=> "English Literature",
                            "Environmental Science"=> "Environmental Science",
                            "Civil Engineer"=> "Civil Engineer",
                            "Electronic Engineer"=> "Electronic Engineer",
                        ]),
                        TextInput::make('phone_number'),
                        FileUpload::make('image_url')->directory('teacher_images')->disk('public'),
                        Textarea::make('bio')->required(),
                    ]),
                ])->submitAction(new HtmlString('<button type="submit">Submit</button>'))
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
                'user_type' => 'teacher'
            ]);
            $user->teacher()->create([
                'last_name' => $data['last_name'],
                'degree_of_education' => $data['degree_of_education'],
                'field_of_education' => $data['field_of_education'],
                'phone_number' => $data['phone_number'],
                'image_url' => $data['image_url'],
                'bio' => $data['bio'],
            ]);
            return redirect()->route('teachers.index');
        });
    }

    public function render(): View
    {
        return view('livewire.teacher.create-teacher');
    }
}
