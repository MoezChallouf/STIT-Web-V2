<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DevisResource\Pages;
use App\Filament\Resources\DevisResource\RelationManagers;
use App\Models\Devis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

class DevisResource extends Resource
{
    protected static ?string $model = Devis::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
                
    //         ]);
    // }

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
                TextColumn::make('e_mail')
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

    public static function infolist(Infolist $infolist): Infolist
{
        return $infolist
            ->schema([

            Section::make('About Client')
            ->schema([
            Infolists\Components\TextEntry::make('first_name'),
            Infolists\Components\TextEntry::make('last_name'),
            Infolists\Components\TextEntry::make('e_mail')->label('Email Address :'),
            Infolists\Components\TextEntry::make('phone')->label('Phone Number :'),
            Infolists\Components\TextEntry::make('postal')->label('Postal Zip Code :'),
            ])->columns(2),
            Section::make('Client Interest')
            ->schema([
            Infolists\Components\TextEntry::make('interest')->label('Interested by :'),
            Infolists\Components\TextEntry::make('message')->label('Message :'),
            Infolists\Components\TextEntry::make('product.name')->label('Intersted by this Product :')
            ])
                ->columnSpanFull(),
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
            'index' => Pages\ListDevis::route('/'),
            'create' => Pages\CreateDevis::route('/create'),
            'edit' => Pages\EditDevis::route('/{record}/edit'),
        ];
    }
}
