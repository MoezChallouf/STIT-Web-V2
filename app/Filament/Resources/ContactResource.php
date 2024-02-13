<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('id')
                ->sortable()
                ->searchable(),
            TextColumn::make('first_name')
                ->sortable()
                ->searchable()
                ->label('First Name'),
            TextColumn::make('last_name')
                ->sortable()
                ->searchable()
                ->label('Last Name'),
            TextColumn::make('email')
                ->sortable()
                ->searchable()
                ->label('Email'),
            TextColumn::make('phone')
                ->sortable()
                ->searchable()
                ->label('Phone Number'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
            return $infolist
                ->schema([
    
                Section::make('About Client')
                ->schema([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('email')->label('Email Address :'),
                TextEntry::make('phone')->label('Phone Number :'),
                ])->columns(2),
                Section::make('Client Interest')
                ->schema([
                TextEntry::make('message')->label('Message :'),
                ])
                    ->columnSpanFull(),
            ]);
    }
}
