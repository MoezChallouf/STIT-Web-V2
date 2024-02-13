<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FringeResource\Pages;
use App\Filament\Resources\FringeResource\RelationManagers;
use App\Models\Fringe;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FringeResource extends Resource
{
    protected static ?string $model = Fringe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Create New Fringe')->schema([
                TextInput::make('ref')->label('Referance')
                ->required()->placeholder('enter fringe referance'),
                ColorPicker::make('color')->required()->placeholder('Choise Color Code #00ff25'),
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
            ])->columns(1)
                ->columnSpan(1)
                ->collapsible(),
                
            Section::make()->schema([
                SpatieMediaLibraryFileUpload::make('image')
                ->required()
                ->image()
                ->imageEditor()
                ->multiple()
                
            ])->columns(1)
            ->columnSpan(1),
            
           
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('ref')->sortable()->searchable(),
                ColorColumn::make('color')
                ->searchable()
                ->sortable(),
                SpatieMediaLibraryImageColumn::make('image'),
                SelectColumn::make('display')
                ->sortable()->searchable()
                ->options([
                    'Show' => 'Show',
                    'Hide' => 'Hide',
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFringes::route('/'),
            'create' => Pages\CreateFringe::route('/create'),
            'edit' => Pages\EditFringe::route('/{record}/edit'),
        ];
    }
}
