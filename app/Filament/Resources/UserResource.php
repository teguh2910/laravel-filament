<?php

namespace App\Filament\Resources;

use App\Mail\BulkEmail;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
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
                Forms\Components\TextInput::make('name')
                    ->required() // cannot empty
                    ->maxLength(255), // max char 255

                Forms\Components\TextInput::make('email')
                    ->required() // cannot empty
                    ->email() // email validation
                    ->maxLength(255), // max char 255

                Forms\Components\TextInput::make('password')
                    ->required() // cannot empty
                    ->password() //  password text input
                    ->revealable() // hide show password
                    ->maxLength(255), // max char 255
                Forms\Components\CheckboxList::make('roles')
                    ->relationship('roles', 'name'),
                Forms\Components\DatePicker::make('email_verified_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\BooleanColumn::make('email_verified_at')->label('Verified'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkAction::make('sendBulkEmail')
                    ->label('Send Bulk Email')
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->label('Email Subject')
                            ->required(),
                        Forms\Components\TextInput::make('periode')
                            ->label('Periode')
                            ->required(),
                        Forms\Components\TextInput::make('usd_rate')
                            ->label('USD / IDR')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('jpy_rate')
                            ->label('JPY / IDR')
                            ->numeric()
                            ->required(),
                        Forms\Components\DatePicker::make('due_date')
                            ->label('Due Date')
                            ->required(),
                        Forms\Components\FileUpload::make('attachment')
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
