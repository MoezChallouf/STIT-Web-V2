<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slider_title')->required()->placeholder('enter title'),
                TextInput::make('slider_subtitle')->required()->placeholder('enter SubTitle'),
                TextInput::make('slider_button')->placeholder('exemple : show more, explore...'),
                Select::make('page')
                ->label('Select Slider Page')
                ->options([
                    'Acceuil' => 'Acceuil',
                    'Usine' => 'Usine',
                    'NosValeurs' => 'NosValeurs',
                    'NosProduit' => 'NosProduit',
                    'NosGammes' => 'NosGammes',
                    'Contactez-nous' => 'Contactez-nous',
                    'Franges&Bobine' => 'Franges&Bobine',
                ])->required(),
                ToggleButtons::make('display')
                ->required()
                ->colors([
                    'Hide' => 'danger',
                    'Show' => 'success',])
                ->grouped()
                ->options([
                    'Show' => 'Show',
                    'Hide' => 'Hide',
                ]),
                SpatieMediaLibraryFileUpload::make('image')
                ->label('Slider image')
                ->image()
                ->imageEditor()
                ->multiple()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                SpatieMediaLibraryImageColumn::make('image'),
                TextColumn::make('slider_title'),
                TextColumn::make('slider_subtitle'),
                TextColumn::make('slider_button'),
                TextColumn::make('slider_button'),
                IconColumn::make('display')
                ->color(fn (string $state): string => match ($state) {
                    'Hide' => 'danger',
                    'Show' => 'success',
                    })
                ->icon(fn (string $state): string => match ($state) {
                    'Show' => 'heroicon-o-check-circle',
                    'Hide' => 'heroicon-o-x-circle',
                })->searchable()
                ->sortable(),
                SelectColumn::make('page')
                ->label('Slider Page')
                ->options([
                    'Acceuil' => 'Acceuil',
                    'Usine' => 'Usine',
                    'NosValeurs' => 'NosValeurs',
                    'NosProduit' => 'NosProduit',
                    'NosGammes' => 'NosGammes',
                    'Contactez-nous' => 'Contactez-nous',
                    'Franges&Bobine' => 'Franges&Bobine',
                ])
            ])
            ->filters([
                SelectFilter::make('page')
                ->label('Slider Page')
                ->options([
                    'Acceuil' => 'Acceuil',
                    'Usine' => 'Usine',
                    'NosValeurs' => 'NosValeurs',
                    'NosProduit' => 'NosProduit',
                    'NosGammes' => 'NosGammes',
                    'Contactez-nous' => 'Contactez-nous',
                    'Franges&Bobine' => 'Franges&Bobine',
                ])
                ->preload(),

                SelectFilter::make('display')
                    ->options([
                        'Show' => 'Show',
                        'Hide' => 'Hide',
                    ])->preload(),
                    
                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
