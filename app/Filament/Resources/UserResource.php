<?php

namespace App\Filament\Resources;

use App\Mail\BulkEmail;
use App\Filament\Resources\UserResource\Pages;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required() // cannot empty
                    ->maxLength(255), // max char 255

                TextInput::make('email')
                    ->required() // cannot empty
                    ->email() // email validation
                    ->maxLength(255), // max char 255

                TextInput::make('password')
                    ->required() // cannot empty
                    ->password() //  password text input
                    ->revealable() // hide show password
                    ->maxLength(255), // max char 255
                CheckboxList::make('roles')
                    ->relationship('roles', 'name'),
                DatePicker::make('email_verified_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                IconColumn::make('email_verified_at')
                    ->boolean()
                    ->label('Verified'),
                // TextColumn::make('created_at')
                //     ->dateTime('M j, Y')
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime('M j, Y')
                //     ->toggleable(isToggledHiddenByDefault: true)
                //     ->sortable(),
            ])
            ->filters([
                Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Filter::make('unverified')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                // Action::make('print')
                //     ->url(fn (User $record): string => url('/'))
                //     ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                BulkAction::make('sendBulkEmail')
                    ->label('Send Bulk Email')
                    ->form([
                        TextInput::make('subject')
                            ->label('Email Subject')
                            ->required(),
                        TextInput::make('periode')
                            ->label('Periode')
                            ->required(),
                        TextInput::make('usd_rate')
                            ->label('USD / IDR')
                            ->numeric()
                            ->required(),
                        TextInput::make('jpy_rate')
                            ->label('JPY / IDR')
                            ->numeric()
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Due Date')
                            ->required(),
                        FileUpload::make('attachment')
                            ->label('Attachment')
                            ->disk('public') // Specify the disk to use
                            ->directory('attachments') // Specify the directory to save files
                            ->nullable(),
                    ])
                    ->action(function ($records, array $data) {
                        foreach ($records as $record) {
                            $details = [
                                'title' => $data['subject'],
                                'periode' => $data['periode'],
                                'usd_rate' => $data['usd_rate'],
                                'jpy_rate' => $data['jpy_rate'],
                                'due_date' => $data['due_date'],
                            ];
                            $attachmentPath = $data['attachment'] ? storage_path('app/public/' . $data['attachment']) : null;
                            Mail::to($record->email)->send(new BulkEmail($details, $details['title'], $attachmentPath));
                            Notification::make()
                                ->title('Send Email successfully')
                                ->success()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-m-envelope'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),

        ];
    }
}
