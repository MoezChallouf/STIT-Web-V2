<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create New Category')->schema([
                    TextInput::make('name')
                    ->required(),
                    Select::make('parent_id')->relationship('parent', 'name'),
                    TextInput::make('slug')
                    ->required(),
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
                    MarkdownEditor::make('description')->required(),
              
                    SpatieMediaLibraryFileUpload::make('image')
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
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('parent.name')->label('Parent Category')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                SpatieMediaLibraryImageColumn::make('image'),
                SelectColumn::make('display')
                ->sortable()->searchable()
                ->options([
                    'Show' => 'Show',
                    'Hide' => 'Hide',
                ]),
                TextColumn::make('created_at'),
                
            ])
            ->filters([
                SelectFilter::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->preload(),

                SelectFilter::make('display')
                    ->options([
                        'Show' => 'Show',
                        'Hide' => 'Hide',
                    ])->preload(),
                    
                ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
            
            ->actions([
                Tables\Actions\ViewAction::make(),
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
    public static function infolist(Infolist $infolist): Infolist
    {
            return $infolist
                ->schema([
                   
                ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
